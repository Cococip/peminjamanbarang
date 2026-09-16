<?php

namespace App\Controllers;

use App\Models\BorrowingModel;

class HistoryController extends BaseController
{
    public function index()
    {
        $borrowingModel = new BorrowingModel();

        $keyword = $this->request->getGet('keyword');
        $status  = $this->request->getGet('status');

        $data = [
            'pageTitle'  => 'Riwayat Peminjaman',
            'activeMenu' => 'history',
            'borrowings' => $borrowingModel->getWithRelations($keyword, $status, 10),
            'pager'      => $borrowingModel->pager,
            'keyword'    => $keyword,
            'status'     => $status,
        ];

        return view('history/index', $data);
    }
}
