<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;

class UsersController extends BaseController
{
    protected $users;
    protected $session;

    public function __construct()
    {
        $this->users = new UsersModel();
        $this->session = \Config\Services::session();
    }

    public function hlogin()
    {
        if ($this->session->get('login')) {
            return redirect()->to('/');
        }

        $data = [
            'judul' => 'Halaman Login'
        ];

        return view('users/login', $data);
    }

    public function login()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $cek = $this->users->where('username', $username)->first();
        if (!$cek) {
            $this->session->setFlashdata('flash', 'Username Tidak ditemukan!');
            return redirect()->to('/users/login');
        } else {
            if (password_verify($password, $cek['password'])) {
                $this->session->set(['login' => true]);
                $this->session->setFlashdata('flash', 'Login Berhasil!');
            } else {
                $this->session->setFlashdata('flash', 'Password Salah!');
                return redirect()->to('/users/login');
            }
        }
        return redirect()->to('/');
    }

    public function logout()
    {
        $this->session->setFlashdata('flash', 'Logout Berhasil!');
        $this->session->remove('login');
        return redirect()->to('/users/login');
    }

    public function hregister()
    {
        if ($this->session->get('login')) {
            return redirect()->to('/');
        }

        $data = [
            'judul' => 'Halaman Register',
            'validation' => \Config\Services::validation()
        ];

        return view('users/register', $data);
    }

    public function register()
    {
        // $data = [
        //     'judul' => 'Halaman Register',
        //     'validation' => \Config\Services::validation()
        // ];

        $validation = \Config\Services::validation();

        if (!$this->validate([
            'username' => [
                'rules' => 'required|is_unique[users.username]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'is_unique' => '{field} sudah terdaftar.'
                ]
            ],
            'password' => [
                'rules' => 'required|matches[password1]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'matches' => '{field} tidak sama.'
                ]
            ],
            'password1' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'matches' => '{field} tidak sama.'
                ]
            ]
        ])) {
            $this->session->setFlashdata('username', $validation->getError('username'));
            $this->session->setFlashdata('password', $validation->getError('password'));
            $this->session->setFlashdata('password1', $validation->getError('password1'));
            $this->session->setFlashdata('flash', 'Register Gagal!');
            return redirect()->to('/users/register')->withInput();
        }
        $password = $this->request->getVar('password');
        $passHash = password_hash($password, PASSWORD_DEFAULT);

        $this->users->save([
            'username' => $this->request->getVar('username'),
            'password' => $passHash
        ]);
        $this->session->setFlashdata('flash', 'Register Berhasil!');
        return redirect()->to('/users/login');
    }
}
