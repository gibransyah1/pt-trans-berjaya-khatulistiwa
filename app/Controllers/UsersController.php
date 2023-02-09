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
            return redirect()->to('/merek');
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
            return redirect()->to('/users/login');
        } else {
            if (password_verify($password, $cek['password'])) {
                $this->session->set(['login' => true]);
                $this->session->setFlashdata('flash', 'Login Berhasil!');
            } else {
                return redirect()->to('/users/login');
            }
        }
        return redirect()->to('/');
    }

    public function logout()
    {
        $this->session->remove('login');
        return redirect()->to('/users/login');
    }

    public function hregister()
    {
        if ($this->session->get('login')) {
            return redirect()->to('/merek');
        }

        $data = [
            'judul' => 'Halaman Register',
            'validation' => \Config\Services::validation()
        ];

        return view('users/register', $data);
    }

    public function register()
    {
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
            return redirect()->to('/users/register')->withInput();
        }
        $password = $this->request->getVar('password');
        $passHash = password_hash($password, PASSWORD_DEFAULT);

        $this->users->save([
            'username' => $this->request->getVar('username'),
            'password' => $passHash
        ]);

        return redirect()->to('/users/login');
    }
}
