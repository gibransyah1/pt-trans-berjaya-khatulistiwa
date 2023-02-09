<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SupirModel;

class SupirController extends BaseController
{
    protected $supir;
    protected $session;

    public function __construct()
    {
        $this->supir = new SupirModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }

        $data = [
            'judul' => 'List Supir',
            'data' => $this->supir->findAll()
        ];

        return view('supir/index', $data);
    }

    public function show($id)
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }

        $data = [
            'judul' => 'Detail Supir',
            'data' => $this->supir->find($id)
        ];

        return view('supir/detail', $data);
    }

    public function create()
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }

        $data = [
            'judul' => 'Form Tambah Supir',
        ];
        return view('supir/tambah', $data);
    }

    public function store()
    {
        $this->supir->save([
            'nama_supir' => $this->request->getVar('supir'),
            'alamat' => $this->request->getVar('alamat'),
            'no_telp' => $this->request->getVar('telp')
        ]);

        return redirect()->to('/supir');
    }

    public function edit($id)
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }

        $data = [
            'judul' => 'Form Ubah supir',
            'data' => $this->supir->find($id),
        ];
        return view('supir/ubah', $data);
    }

    public function edited()
    {
        $this->supir->save([
            'supir_id' => $this->request->getVar('id'),
            'nama_supir' => $this->request->getVar('supir'),
            'alamat' => $this->request->getVar('alamat'),
            'no_telp' => $this->request->getVar('telp')
        ]);

        return redirect()->to('/supir');
    }

    public function delete($id)
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }

        $this->supir->delete($id);

        return redirect()->to('/supir');
    }
}
