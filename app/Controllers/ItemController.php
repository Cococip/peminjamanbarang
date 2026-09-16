<?php

namespace App\Controllers;

use App\Models\ItemModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class ItemController extends BaseController
{
    protected ItemModel $itemModel;

    public function __construct()
    {
        $this->itemModel = new ItemModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        $data = [
            'pageTitle'  => 'Data Barang',
            'activeMenu' => 'items',
            'items'      => $this->itemModel->getItemsWithAvailability($keyword, 10),
            'pager'      => $this->itemModel->pager,
            'keyword'    => $keyword,
        ];

        return view('items/index', $data);
    }

    public function create()
    {
        $data = [
            'pageTitle'  => 'Tambah Barang',
            'activeMenu' => 'items',
        ];

        return view('items/create', $data);
    }

    public function store()
    {
        $rules = [
            'kode_barang' => 'required|max_length[30]|is_unique[items.kode_barang]',
            'nama_barang' => 'required|min_length[3]|max_length[150]',
            'jumlah'      => 'required|is_natural_no_zero',
            'kondisi'     => 'required|in_list[Baik,Rusak Ringan,Rusak]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->itemModel->insert([
            'kode_barang' => $this->request->getPost('kode_barang'),
            'nama_barang' => $this->request->getPost('nama_barang'),
            'jumlah'      => $this->request->getPost('jumlah'),
            'kondisi'     => $this->request->getPost('kondisi'),
            'status'      => 'Tersedia',
        ]);

        return redirect()->to('/items')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = $this->itemModel->find($id);

        if (! $item) {
            return redirect()->to('/items')->with('error', 'Barang tidak ditemukan.');
        }

        $data = [
            'pageTitle'  => 'Edit Barang',
            'activeMenu' => 'items',
            'item'       => $item,
        ];

        return view('items/edit', $data);
    }

    public function update($id)
    {
        $item = $this->itemModel->find($id);

        if (! $item) {
            return redirect()->to('/items')->with('error', 'Barang tidak ditemukan.');
        }

        $rules = [
            'kode_barang' => 'required|max_length[30]|is_unique[items.kode_barang,id,' . $id . ']',
            'nama_barang' => 'required|min_length[3]|max_length[150]',
            'jumlah'      => 'required|is_natural_no_zero',
            'kondisi'     => 'required|in_list[Baik,Rusak Ringan,Rusak]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->itemModel->update($id, [
            'kode_barang' => $this->request->getPost('kode_barang'),
            'nama_barang' => $this->request->getPost('nama_barang'),
            'jumlah'      => $this->request->getPost('jumlah'),
            'kondisi'     => $this->request->getPost('kondisi'),
        ]);

        $this->itemModel->refreshStatus((int) $id);

        return redirect()->to('/items')->with('success', 'Barang berhasil diperbarui.');
    }

    public function show($id)
    {
        $item = $this->itemModel->find($id);

        if (! $item) {
            return redirect()->to('/items')->with('error', 'Barang tidak ditemukan.');
        }

        $data = [
            'pageTitle'  => 'Detail Barang',
            'activeMenu' => 'items',
            'item'       => $item,
            'tersedia'   => $this->itemModel->getJumlahTersedia((int) $id),
            'dipinjam'   => $this->itemModel->getJumlahDipinjam((int) $id),
        ];

        return view('items/show', $data);
    }

    public function delete($id)
    {
        $item = $this->itemModel->find($id);

        if (! $item) {
            return redirect()->to('/items')->with('error', 'Barang tidak ditemukan.');
        }

        try {
            $this->itemModel->delete($id);
        } catch (DatabaseException $e) {
            return redirect()->to('/items')->with('error', 'Barang tidak dapat dihapus karena memiliki riwayat peminjaman.');
        }

        return redirect()->to('/items')->with('success', 'Barang berhasil dihapus.');
    }
}
