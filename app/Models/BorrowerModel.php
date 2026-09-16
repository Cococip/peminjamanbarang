<?php

namespace App\Models;

use CodeIgniter\Model;

class BorrowerModel extends Model
{
    protected $table            = 'borrowers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nama', 'identitas', 'kelas', 'no_hp'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'nama'      => 'required|min_length[3]|max_length[150]',
        'identitas' => 'required|max_length[50]',
        'kelas'     => 'permit_empty|max_length[100]',
        'no_hp'     => 'permit_empty|max_length[20]|numeric',
    ];

    protected $validationMessages = [
        'nama' => [
            'required'   => 'Nama wajib diisi.',
            'min_length' => 'Nama minimal 3 karakter.',
        ],
        'identitas' => [
            'required' => 'Identitas (NIM/NIP/ID) wajib diisi.',
        ],
        'no_hp' => [
            'numeric' => 'Nomor HP hanya boleh berisi angka.',
        ],
    ];

    public function searchAndPaginate(?string $keyword = null, int $perPage = 10)
    {
        if ($keyword) {
            $this->groupStart()
                ->like('nama', $keyword)
                ->orLike('identitas', $keyword)
                ->orLike('kelas', $keyword)
                ->groupEnd();
        }

        return $this->orderBy('id', 'DESC')->paginate($perPage);
    }

    public function hasActiveBorrowings(int $borrowerId): bool
    {
        return $this->db->table('borrowings')
            ->where('peminjam_id', $borrowerId)
            ->where('status', 'Dipinjam')
            ->countAllResults() > 0;
    }
}
