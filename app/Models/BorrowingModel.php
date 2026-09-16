<?php

namespace App\Models;

use CodeIgniter\Model;

class BorrowingModel extends Model
{
    protected $table            = 'borrowings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'kode_peminjaman',
        'barang_id',
        'peminjam_id',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'catatan',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'barang_id'       => 'required|is_natural_no_zero',
        'peminjam_id'     => 'required|is_natural_no_zero',
        'jumlah'          => 'required|is_natural_no_zero',
        'tanggal_pinjam'  => 'required|valid_date[Y-m-d]',
        'tanggal_kembali' => 'required|valid_date[Y-m-d]',
    ];

    protected $validationMessages = [
        'barang_id' => [
            'required' => 'Barang wajib dipilih.',
        ],
        'peminjam_id' => [
            'required' => 'Peminjam wajib dipilih.',
        ],
        'jumlah' => [
            'required'           => 'Jumlah wajib diisi.',
            'is_natural_no_zero' => 'Jumlah harus berupa angka minimal 1.',
        ],
        'tanggal_pinjam' => [
            'required'   => 'Tanggal pinjam wajib diisi.',
            'valid_date' => 'Format tanggal pinjam tidak valid.',
        ],
        'tanggal_kembali' => [
            'required'   => 'Tanggal rencana kembali wajib diisi.',
            'valid_date' => 'Format tanggal kembali tidak valid.',
        ],
    ];

    /**
     * Generate kode peminjaman unik berbasis tanggal + urutan harian.
     */
    public function generateKodePeminjaman(): string
    {
        $today  = date('Ymd');
        $prefix = 'PJM-' . $today . '-';

        $last = $this->like('kode_peminjaman', $prefix, 'after')
            ->orderBy('id', 'DESC')
            ->first();

        $urutan = 1;
        if ($last) {
            $urutan = (int) substr($last['kode_peminjaman'], -4) + 1;
        }

        return $prefix . str_pad((string) $urutan, 4, '0', STR_PAD_LEFT);
    }

    public function getWithRelations(?string $keyword = null, ?string $status = null, int $perPage = 10)
    {
        $this->select('borrowings.*, items.nama_barang, items.kode_barang, borrowers.nama AS nama_peminjam, borrowers.identitas')
            ->join('items', 'items.id = borrowings.barang_id')
            ->join('borrowers', 'borrowers.id = borrowings.peminjam_id')
            ->orderBy('borrowings.id', 'DESC');

        if ($keyword) {
            $this->groupStart()
                ->like('borrowings.kode_peminjaman', $keyword)
                ->orLike('items.nama_barang', $keyword)
                ->orLike('borrowers.nama', $keyword)
                ->groupEnd();
        }

        if ($status) {
            $this->where('borrowings.status', $status);
        }

        return $this->paginate($perPage);
    }

    public function findWithRelations(int $id)
    {
        return $this->select('borrowings.*, items.nama_barang, items.kode_barang, borrowers.nama AS nama_peminjam, borrowers.identitas')
            ->join('items', 'items.id = borrowings.barang_id')
            ->join('borrowers', 'borrowers.id = borrowings.peminjam_id')
            ->where('borrowings.id', $id)
            ->first();
    }

    public function getRecent(int $limit = 5)
    {
        return $this->select('borrowings.*, items.nama_barang, borrowers.nama AS nama_peminjam')
            ->join('items', 'items.id = borrowings.barang_id')
            ->join('borrowers', 'borrowers.id = borrowings.peminjam_id')
            ->orderBy('borrowings.id', 'DESC')
            ->findAll($limit);
    }
}
