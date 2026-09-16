<?php

namespace App\Controllers;

use App\Models\BorrowerModel;
use App\Models\BorrowingModel;
use App\Models\ItemModel;

class BorrowingController extends BaseController
{
    protected BorrowingModel $borrowingModel;
    protected ItemModel $itemModel;
    protected BorrowerModel $borrowerModel;

    public function __construct()
    {
        $this->borrowingModel = new BorrowingModel();
        $this->itemModel      = new ItemModel();
        $this->borrowerModel  = new BorrowerModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        $data = [
            'pageTitle'  => 'Peminjaman',
            'activeMenu' => 'borrowings',
            'borrowings' => $this->borrowingModel->getWithRelations($keyword, 'Dipinjam', 10),
            'pager'      => $this->borrowingModel->pager,
            'keyword'    => $keyword,
        ];

        return view('borrowings/index', $data);
    }

    public function create()
    {
        $data = [
            'pageTitle'  => 'Tambah Peminjaman',
            'activeMenu' => 'borrowings',
            'items'      => $this->itemModel->getAllWithAvailability(),
            'borrowers'  => $this->borrowerModel->orderBy('nama', 'ASC')->findAll(),
        ];

        return view('borrowings/create', $data);
    }

    public function store()
    {
        $rules = [
            'barang_id'       => 'required|is_natural_no_zero',
            'peminjam_id'     => 'required|is_natural_no_zero',
            'jumlah'          => 'required|is_natural_no_zero',
            'tanggal_pinjam'  => 'required|valid_date[Y-m-d]',
            'tanggal_kembali' => 'required|valid_date[Y-m-d]',
        ];

        $messages = [
            'barang_id'       => ['required' => 'Barang wajib dipilih.'],
            'peminjam_id'     => ['required' => 'Peminjam wajib dipilih.'],
            'jumlah'          => [
                'required'           => 'Jumlah wajib diisi.',
                'is_natural_no_zero' => 'Jumlah harus berupa angka minimal 1.',
            ],
            'tanggal_pinjam'  => ['required' => 'Tanggal pinjam wajib diisi.'],
            'tanggal_kembali' => ['required' => 'Tanggal rencana kembali wajib diisi.'],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $barangId   = (int) $this->request->getPost('barang_id');
        $jumlah     = (int) $this->request->getPost('jumlah');
        $tglPinjam  = $this->request->getPost('tanggal_pinjam');
        $tglKembali = $this->request->getPost('tanggal_kembali');

        $item = $this->itemModel->find($barangId);
        if (! $item) {
            return redirect()->back()->withInput()->with('error', 'Barang yang dipilih tidak ditemukan.');
        }

        if ($tglKembali < $tglPinjam) {
            return redirect()->back()->withInput()->with('errors', [
                'tanggal_kembali' => 'Tanggal kembali tidak boleh lebih kecil dari tanggal pinjam.',
            ]);
        }

        $tersedia = $this->itemModel->getJumlahTersedia($barangId);

        if ($jumlah > $tersedia) {
            return redirect()->back()->withInput()->with('error',
                'Jumlah pinjam melebihi stok tersedia. Stok tersedia untuk "' . $item['nama_barang'] . '" saat ini hanya ' . $tersedia . ' unit.'
            );
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $this->borrowingModel->insert([
            'kode_peminjaman' => $this->borrowingModel->generateKodePeminjaman(),
            'barang_id'       => $barangId,
            'peminjam_id'     => (int) $this->request->getPost('peminjam_id'),
            'jumlah'          => $jumlah,
            'tanggal_pinjam'  => $tglPinjam,
            'tanggal_kembali' => $tglKembali,
            'status'          => 'Dipinjam',
            'catatan'         => $this->request->getPost('catatan'),
        ]);

        $this->itemModel->refreshStatus($barangId);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan transaksi peminjaman. Silakan coba lagi.');
        }

        return redirect()->to('/borrowings')->with('success', 'Peminjaman berhasil disimpan.');
    }

    public function show($id)
    {
        $borrowing = $this->borrowingModel->findWithRelations((int) $id);

        if (! $borrowing) {
            return redirect()->to('/borrowings')->with('error', 'Data peminjaman tidak ditemukan.');
        }

        $data = [
            'pageTitle'  => 'Detail Peminjaman',
            'activeMenu' => 'borrowings',
            'borrowing'  => $borrowing,
        ];

        return view('borrowings/show', $data);
    }

    public function returnIndex()
    {
        $keyword = $this->request->getGet('keyword');

        $data = [
            'pageTitle'  => 'Pengembalian',
            'activeMenu' => 'return',
            'borrowings' => $this->borrowingModel->getWithRelations($keyword, 'Dipinjam', 10),
            'pager'      => $this->borrowingModel->pager,
            'keyword'    => $keyword,
        ];

        return view('borrowings/return', $data);
    }

    public function processReturn($id)
    {
        $borrowing = $this->borrowingModel->find($id);

        if (! $borrowing) {
            return redirect()->to('/borrowings/return')->with('error', 'Data peminjaman tidak ditemukan.');
        }

        if ($borrowing['status'] === 'Dikembalikan') {
            return redirect()->to('/borrowings/return')->with('error', 'Peminjaman ini sudah dikembalikan sebelumnya.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $this->borrowingModel->update($id, ['status' => 'Dikembalikan']);
        $this->itemModel->refreshStatus((int) $borrowing['barang_id']);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->to('/borrowings/return')->with('error', 'Gagal memproses pengembalian. Silakan coba lagi.');
        }

        return redirect()->to('/borrowings/return')->with('success', 'Pengembalian berhasil diproses. Kode: ' . $borrowing['kode_peminjaman']);
    }
}
