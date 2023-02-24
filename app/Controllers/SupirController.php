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
        $currentPage = $this->request->getVar('page_supir') ? $this->request->getVar('page_supir') : 1;

        $data = [
            'judul' => 'List Supir',
            'data' => $this->supir->paginate(5, 'supir'),
            'pager' => $this->supir->pager,
            'currentPage' => $currentPage
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
        $validation = \Config\Services::validation();

        if (!$this->validate([
            'supir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ],
            'telp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ]
        ])) {
            $this->session->setFlashdata('supir', $validation->getError('supir'));
            $this->session->setFlashdata('alamat', $validation->getError('alamat'));
            $this->session->setFlashdata('telp', $validation->getError('telp'));
            $this->session->setFlashdata('flash', 'Tambah Supir Gagal!');
            return redirect()->to('/supir/create')->withInput();
        }
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
        $validation = \Config\Services::validation();

        if (!$this->validate([
            'supir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ],
            'telp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ]
        ])) {
            $this->session->setFlashdata('supir', $validation->getError('supir'));
            $this->session->setFlashdata('alamat', $validation->getError('alamat'));
            $this->session->setFlashdata('telp', $validation->getError('telp'));
            $this->session->setFlashdata('flash', 'Ubah Supir Gagal!');
            return redirect()->to('/supir/edit/' . $this->request->getVar('id'))->withInput();
        }

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
