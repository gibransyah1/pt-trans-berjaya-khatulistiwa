<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MerekModel;
use App\Models\MobilModel;

class MobilController extends BaseController
{
    protected $mobil;
    protected $merek;
    protected $session;

    public function __construct()
    {
        $this->mobil = new MobilModel();
        $this->merek = new MerekModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }
        $currentPage = $this->request->getVar('page_mobil') ? $this->request->getVar('page_mobil') : 1;

        $data = [
            'judul' => 'List Mobil',
            'data' => $this->mobil->join('merek', 'mobil.merek_id = merek.merek_id')->paginate(2, 'mobil'),
            'pager' => $this->mobil->pager,
            'currentPage' => $currentPage
        ];

        return view('mobil/index', $data);
    }

    public function show($id)
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }

        $data = [
            'judul' => 'Detail Mobil',
            'data' => $this->mobil->join('merek', 'mobil.merek_id = merek.merek_id')->find($id)
        ];

        return view('mobil/detail', $data);
    }

    public function create()
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }

        $data = [
            'judul' => 'Form Tambah Mobil',
            'data' => $this->merek->findAll()
        ];
        return view('mobil/tambah', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        if (!$this->validate([
            'gambar' => [
                'rules' => 'uploaded[gambar]',
                'errors' => [
                    'uploaded' => '{field} belum diupload.'
                ]
            ],
            'namamobil' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ],
            'jenis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ],
            'kapasitas' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'numeric' => '{field} harus angka.'
                ]
            ],
            'harga' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ],
            'merek' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ],
            'unit' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'numeric' => '{field} harus angka.'
                ]
            ]
        ])) {
            $this->session->setFlashdata('gambar', $validation->getError('gambar'));
            $this->session->setFlashdata('namamobil', $validation->getError('namamobil'));
            $this->session->setFlashdata('jenis', $validation->getError('jenis'));
            $this->session->setFlashdata('kapasitas', $validation->getError('kapasitas'));
            $this->session->setFlashdata('harga', $validation->getError('harga'));
            $this->session->setFlashdata('merek', $validation->getError('merek'));
            $this->session->setFlashdata('unit', $validation->getError('unit'));
            $this->session->setFlashdata('flash', 'Tambah Mobil Gagal!');
            return redirect()->to('/mobil/create')->withInput();
        }

        $file = $this->request->getFile('gambar');
        $namaFile = $file->getRandomName();

        $this->mobil->save([
            'gambar' => $namaFile,
            'nama_mobil' => $this->request->getVar('namamobil'),
            'jenis' => $this->request->getVar('jenis'),
            'kapasitas_mesin' => $this->request->getVar('kapasitas'),
            'harga_sewa' => $this->request->getVar('harga'),
            'merek_id' => $this->request->getVar('merek'),
            'unit' => $this->request->getVar('unit')
        ]);

        $file->move('assets/gambar/', $namaFile);

        return redirect()->to('/mobil');
    }

    public function edit($id)
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }

        $data = [
            'judul' => 'Form Ubah Mobil',
            'data' => $this->mobil->join('merek', 'mobil.merek_id = merek.merek_id')->find($id),
            'mobil' => $this->merek->findAll()
        ];
        return view('mobil/ubah', $data);
    }

    public function edited()
    {
        $this->mobil->save([
            'mobil_id' => $this->request->getVar('id'),
            'nama_mobil' => $this->request->getVar('namamobil'),
            'jenis' => $this->request->getVar('jenis'),
            'kapasitas_mesin' => $this->request->getVar('kapasitas'),
            'harga_sewa' => $this->request->getVar('harga'),
            'merek_id' => $this->request->getVar('merek'),
            'unit' => $this->request->getVar('unit')
        ]);

        return redirect()->to('/mobil');
    }

    public function delete($id)
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }

        $this->mobil->delete($id);

        return redirect()->to('/mobil');
    }
}
