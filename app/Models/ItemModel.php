<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table            = 'items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['kode_barang', 'nama_barang', 'jumlah', 'kondisi', 'status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'kode_barang' => 'required|max_length[30]|is_unique[items.kode_barang,id,{id}]',
        'nama_barang' => 'required|min_length[3]|max_length[150]',
        'jumlah'      => 'required|is_natural_no_zero',
        'kondisi'     => 'required|in_list[Baik,Rusak Ringan,Rusak]',
    ];

    protected $validationMessages = [
        'kode_barang' => [
            'required'  => 'Kode barang wajib diisi.',
            'is_unique' => 'Kode barang sudah digunakan, gunakan kode lain.',
        ],
        'nama_barang' => [
            'required'   => 'Nama barang wajib diisi.',
            'min_length' => 'Nama barang minimal 3 karakter.',
        ],
        'jumlah' => [
            'required'             => 'Jumlah wajib diisi.',
            'is_natural_no_zero'   => 'Jumlah harus berupa angka minimal 1.',
        ],
        'kondisi' => [
            'required' => 'Kondisi wajib dipilih.',
            'in_list'  => 'Kondisi tidak valid.',
        ],
    ];

    /**
     * Jumlah barang yang sedang aktif dipinjam (status Dipinjam) untuk satu item.
     */
    public function getJumlahDipinjam(int $itemId): int
    {
        $result = $this->db->table('borrowings')
            ->selectSum('jumlah')
            ->where('barang_id', $itemId)
            ->where('status', 'Dipinjam')
            ->get()
            ->getRow();

        return (int) ($result->jumlah ?? 0);
    }

    /**
     * Jumlah barang yang masih tersedia untuk dipinjam.
     */
    public function getJumlahTersedia(int $itemId): int
    {
        $item = $this->find($itemId);
        if (! $item) {
            return 0;
        }

        return max(0, $item['jumlah'] - $this->getJumlahDipinjam($itemId));
    }

    /**
     * Ambil semua item beserta jumlah tersedia dan jumlah dipinjam (untuk listing).
     */
    public function getItemsWithAvailability(?string $keyword = null, int $perPage = 10)
    {
        $this->select('items.*, COALESCE(b.dipinjam, 0) AS dipinjam, (items.jumlah - COALESCE(b.dipinjam, 0)) AS tersedia')
            ->join(
                '(SELECT barang_id, SUM(jumlah) AS dipinjam FROM borrowings WHERE status = "Dipinjam" GROUP BY barang_id) b',
                'b.barang_id = items.id',
                'left'
            )
            ->orderBy('items.id', 'DESC');

        if ($keyword) {
            $this->groupStart()
                ->like('items.kode_barang', $keyword)
                ->orLike('items.nama_barang', $keyword)
                ->groupEnd();
        }

        return $this->paginate($perPage);
    }

    /**
     * Ambil semua item beserta jumlah tersedia, tanpa pagination (untuk dropdown form).
     */
    public function getAllWithAvailability(): array
    {
        return $this->select('items.*, COALESCE(b.dipinjam, 0) AS dipinjam, (items.jumlah - COALESCE(b.dipinjam, 0)) AS tersedia')
            ->join(
                '(SELECT barang_id, SUM(jumlah) AS dipinjam FROM borrowings WHERE status = "Dipinjam" GROUP BY barang_id) b',
                'b.barang_id = items.id',
                'left'
            )
            ->orderBy('items.nama_barang', 'ASC')
            ->findAll();
    }

    /**
     * Perbarui status Tersedia/Dipinjam berdasarkan sisa stok yang tersedia.
     */
    public function refreshStatus(int $itemId): void
    {
        $item = $this->find($itemId);
        if (! $item) {
            return;
        }

        $tersedia = $this->getJumlahTersedia($itemId);
        $status   = $tersedia > 0 ? 'Tersedia' : 'Dipinjam';

        if ($status !== $item['status']) {
            $this->skipValidation(true)->update($itemId, ['status' => $status]);
        }
    }
}
