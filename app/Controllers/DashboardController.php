<?php

namespace App\Controllers;

use App\Models\BorrowerModel;
use App\Models\BorrowingModel;
use App\Models\ItemModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $itemModel     = new ItemModel();
        $borrowerModel = new BorrowerModel();
        $borrowingModel = new BorrowingModel();

        $totalBarang   = $itemModel->countAllResults();
        $totalPeminjam = $borrowerModel->countAllResults();

        $barangDipinjam = (int) ($borrowingModel->db->table('borrowings')
            ->selectSum('jumlah')
            ->where('status', 'Dipinjam')
            ->get()
            ->getRow()
            ->jumlah ?? 0);

        $peminjamanAktif = $borrowingModel->where('status', 'Dipinjam')->countAllResults();

        $recentBorrowings = $borrowingModel->getRecent(5);

        $data = [
            'pageTitle'        => 'Dashboard',
            'activeMenu'       => 'dashboard',
            'totalBarang'      => $totalBarang,
            'totalPeminjam'    => $totalPeminjam,
            'barangDipinjam'   => $barangDipinjam,
            'peminjamanAktif'  => $peminjamanAktif,
            'recentBorrowings' => $recentBorrowings,
        ];

        return view('dashboard/index', $data);
    }
}
