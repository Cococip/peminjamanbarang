<?php

namespace App\Controllers;

use App\Models\BorrowerModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class BorrowerController extends BaseController
{
    protected BorrowerModel $borrowerModel;

    public function __construct()
    {
        $this->borrowerModel = new BorrowerModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        $data = [
            'pageTitle'  => 'Data Peminjam',
            'activeMenu' => 'borrowers',
            'borrowers'  => $this->borrowerModel->searchAndPaginate($keyword, 10),
            'pager'      => $this->borrowerModel->pager,
            'keyword'    => $keyword,
        ];

        return view('borrowers/index', $data);
    }

    public function create()
    {
        $data = [
            'pageTitle'  => 'Tambah Peminjam',
            'activeMenu' => 'borrowers',
        ];

        return view('borrowers/create', $data);
    }

    public function store()
    {
        $rules = [
            'nama'      => 'required|min_length[3]|max_length[150]',
            'identitas' => 'required|max_length[50]',
            'kelas'     => 'permit_empty|max_length[100]',
            'no_hp'     => 'permit_empty|max_length[20]|numeric',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->borrowerModel->insert([
            'nama'      => $this->request->getPost('nama'),
            'identitas' => $this->request->getPost('identitas'),
            'kelas'     => $this->request->getPost('kelas'),
            'no_hp'     => $this->request->getPost('no_hp'),
        ]);

        return redirect()->to('/borrowers')->with('success', 'Peminjam berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $borrower = $this->borrowerModel->find($id);

        if (! $borrower) {
            return redirect()->to('/borrowers')->with('error', 'Peminjam tidak ditemukan.');
        }

        $data = [
            'pageTitle'  => 'Edit Peminjam',
            'activeMenu' => 'borrowers',
            'borrower'   => $borrower,
        ];

        return view('borrowers/edit', $data);
    }

    public function update($id)
    {
        $borrower = $this->borrowerModel->find($id);

        if (! $borrower) {
            return redirect()->to('/borrowers')->with('error', 'Peminjam tidak ditemukan.');
        }

        $rules = [
            'nama'      => 'required|min_length[3]|max_length[150]',
            'identitas' => 'required|max_length[50]',
            'kelas'     => 'permit_empty|max_length[100]',
            'no_hp'     => 'permit_empty|max_length[20]|numeric',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->borrowerModel->update($id, [
            'nama'      => $this->request->getPost('nama'),
            'identitas' => $this->request->getPost('identitas'),
            'kelas'     => $this->request->getPost('kelas'),
            'no_hp'     => $this->request->getPost('no_hp'),
        ]);

        return redirect()->to('/borrowers')->with('success', 'Peminjam berhasil diperbarui.');
    }

    public function show($id)
    {
        $borrower = $this->borrowerModel->find($id);

        if (! $borrower) {
            return redirect()->to('/borrowers')->with('error', 'Peminjam tidak ditemukan.');
        }

        $data = [
            'pageTitle'  => 'Detail Peminjam',
            'activeMenu' => 'borrowers',
            'borrower'   => $borrower,
        ];

        return view('borrowers/show', $data);
    }

    public function delete($id)
    {
        $borrower = $this->borrowerModel->find($id);

        if (! $borrower) {
            return redirect()->to('/borrowers')->with('error', 'Peminjam tidak ditemukan.');
        }

        try {
            $this->borrowerModel->delete($id);
        } catch (DatabaseException $e) {
            return redirect()->to('/borrowers')->with('error', 'Peminjam tidak dapat dihapus karena memiliki riwayat peminjaman.');
        }

        return redirect()->to('/borrowers')->with('success', 'Peminjam berhasil dihapus.');
    }
}
