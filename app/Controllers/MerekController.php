<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MerekModel;

class MerekController extends BaseController
{
    protected $merek;
    protected $session;

    public function __construct()
    {
        $this->merek = new MerekModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }

        $data = [
            'judul' => 'List Merek',
            'data' => $this->merek->findAll()
        ];

        return view('merek/index', $data);
    }

    public function show($id)
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }

        $data = [
            'judul' => 'Detail Merek',
            'data' => $this->merek->find($id)
        ];

        return view('merek/detail', $data);
    }

    public function create()
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }

        $data = [
            'judul' => 'Form Tambah Merek'
        ];
        return view('merek/tambah', $data);
    }

    public function store()
    {
        $this->merek->save([
            'nama' => $this->request->getVar('nama'),
            'negara' => $this->request->getVar('negara')
        ]);

        return redirect()->to('/merek');
    }

    public function edit($id)
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }

        $data = [
            'judul' => 'Form Ubah Merek',
            'data' => $this->merek->find($id)
        ];
        return view('merek/ubah', $data);
    }

    public function edited()
    {
        $this->merek->save([
            'merek_id' => $this->request->getVar('id'),
            'nama' => $this->request->getVar('nama'),
            'negara' => $this->request->getVar('negara')
        ]);

        return redirect()->to('/merek');
    }

    public function delete($id)
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }

        $this->merek->delete($id);

        return redirect()->to('/merek');
    }
}
