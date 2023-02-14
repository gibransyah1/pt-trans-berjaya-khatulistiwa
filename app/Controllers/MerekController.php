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
        $currentPage = $this->request->getVar('page_merek') ? $this->request->getVar('page_merek') : 1;

        $data = [
            'judul' => 'List Merek',
            'data' => $this->merek->paginate(2, 'merek'),
            'pager' => $this->merek->pager,
            'currentPage' => $currentPage
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
        $validation = \Config\Services::validation();

        if (!$this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ],
            'negara' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ]
        ])) {
            $this->session->setFlashdata('nama', $validation->getError('nama'));
            $this->session->setFlashdata('negara', $validation->getError('negara'));
            $this->session->setFlashdata('flash', 'Tambah Merek Gagal!');
            return redirect()->to('/merek/create')->withInput();
        }

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
