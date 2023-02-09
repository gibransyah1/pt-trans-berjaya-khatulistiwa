<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }
        $db = db_connect();
        $januari = $db->query('SELECT * FROM transaksi WHERE MONTH(tgl_masuk) = 1 AND YEAR(tgl_masuk) = 2023')->getNumRows();
        $februari = $db->query('SELECT * FROM transaksi WHERE MONTH(tgl_masuk) = 2 AND YEAR(tgl_masuk) = 2023')->getNumRows();
        $maret = $db->query('SELECT * FROM transaksi WHERE MONTH(tgl_masuk) = 3 AND YEAR(tgl_masuk) = 2023')->getNumRows();
        $april = $db->query('SELECT * FROM transaksi WHERE MONTH(tgl_masuk) = 4 AND YEAR(tgl_masuk) = 2023')->getNumRows();


        $data = [
            'judul' => 'Halaman Dashboard',
            'januari' => $januari,
            'februari' => $februari,
            'maret' => $maret,
            'april' => $april
        ];

        return view('dashboard/index', $data);
    }
}
