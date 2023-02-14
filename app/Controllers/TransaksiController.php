<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MobilModel;
use App\Models\SupirModel;
use App\Models\TransaksiModel;
use App\ThirdParty\FPDF;

class TransaksiController extends BaseController
{
    protected $transaksi;
    protected $mobil;
    protected $supir;
    protected $session;
    protected $fpdf;

    public function __construct()
    {
        $this->transaksi = new TransaksiModel();
        $this->mobil = new MobilModel();
        $this->supir = new SupirModel();
        $this->session = \Config\Services::session();
        $this->fpdf = new FPDF('L', 'mm', 'Letter');
    }

    public function index()
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }
        $currentPage = $this->request->getVar('page_pinjam') ? $this->request->getVar('page_pinjam') : 1;
        $data = [
            'judul' => 'List Mobil Sedang dipinjam',
            'data' => $this->transaksi->join('mobil', 'transaksi.mobil_id = mobil.mobil_id')->join('supir', 'transaksi.supir_id = supir.supir_id')->where('total =', 0)->orderBy('tgl_keluar', 'DESC')->orderBy('jam_keluar', 'DESC')->paginate(2, 'pinjam'),
            'pager' => $this->transaksi->pager,
            'currentPage' => $currentPage
        ];

        return view('transaksi/index', $data);
    }

    public function masuk()
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }
        $currentPage = $this->request->getVar('page_kembali') ? $this->request->getVar('page_kembali') : 1;
        $data = [
            'judul' => 'List Mobil Sudah dikembalikan',
            'data' => $this->transaksi->join('mobil', 'transaksi.mobil_id = mobil.mobil_id')->join('supir', 'transaksi.supir_id = supir.supir_id')->where('total !=', 0)->orderBy('tgl_masuk', 'DESC')->orderBy('jam_masuk', 'DESC')->paginate(2, 'kembali'),
            'pager' => $this->transaksi->pager,
            'currentPage' => $currentPage
        ];

        return view('transaksi/masuk', $data);
    }

    public function show($id)
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }

        $data = [
            'judul' => 'Detail Transaksi',
            'data' => $this->transaksi->join('mobil', 'transaksi.mobil_id = mobil.mobil_id')->join('supir', 'transaksi.supir_id = supir.supir_id')->find($id)
        ];

        return view('transaksi/detail', $data);
    }

    public function create()
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }

        $data = [
            'judul' => 'Form Tambah Transaksi',
            'mobil' => $this->mobil->findAll(),
            'supir' => $this->supir->findAll()
        ];
        return view('transaksi/tambah', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        if (!$this->validate([
            'mobil' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ],
            'supir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ],
            'unit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ]
        ])) {
            $this->session->setFlashdata('mobil', $validation->getError('mobil'));
            $this->session->setFlashdata('supir', $validation->getError('supir'));
            $this->session->setFlashdata('unit', $validation->getError('unit'));
            $this->session->setFlashdata('flash', 'Tambah Transaksi Gagal!');
            return redirect()->to('/transaksi/create')->withInput();
        }

        date_default_timezone_set('Asia/Jakarta');

        $cek = $this->mobil->where('mobil_id', $this->request->getVar('mobil'))->first();

        if ($cek['unit'] < $this->request->getVar('unit')) {
            $this->session->setFlashdata('flash', 'Mobil Tidak Tersedia!');
            return redirect()->to('/transaksi/create');
        }

        $this->transaksi->save([
            'mobil_id' => $this->request->getVar('mobil'),
            'supir_id' => $this->request->getVar('supir'),
            'tgl_keluar' => date('Y-m-d'),
            'jam_keluar' => date('H:i:s'),
            'unit_total' => $this->request->getVar('unit'),
            'total' => 0
        ]);

        $this->mobil->save([
            'mobil_id' => $this->request->getVar('mobil'),
            'unit' => $cek['unit'] - $this->request->getVar('unit')
        ]);



        return redirect()->to('/transaksi/keluar');
    }

    public function edit($id)
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }

        // $data = [
        //     'judul' => 'Form Ubah Transaksi',
        //     'data' => $this->transaksi->join('mobil', 'transaksi.mobil_id = mobil.mobil_id')->join('supir', 'transaksi.supir_id = supir.supir_id')->find($id),
        //     'mobil' => $this->mobil->findAll(),
        //     'supir' => $this->supir->findAll()
        // ];
        // return view('transaksi/ubah', $data);

        date_default_timezone_set('Asia/Jakarta');
        $selesai = $this->transaksi->find($id);
        $cek = $this->mobil->where('mobil_id', $selesai['mobil_id'])->first();
        $db = db_connect();
        $dataWaktu = $db->query("SELECT *, DATEDIFF(CURDATE(), tgl_keluar) durasi_hari, (TIME_FORMAT(CURTIME(),'%H')-TIME_FORMAT(jam_keluar, '%H')) durasi_jam "
            . "FROM transaksi WHERE transaksi_id='" . $id . "' AND total=0")->getRowArray();

        if ($dataWaktu['durasi_hari'] > 0) {
            // $durasiHari = $dataWaktu['durasi_hari'] . ' Hari';
            // $durasiJam = '-';
            $biayaakhir = $cek['harga_sewa'] * $selesai['unit_total'] + ($cek['harga_sewa'] * $dataWaktu['durasi_hari']);
        } else {
            // $durasiHari = '0 hari';
            // $durasiJam = $dataWaktu['durasi_jam'] . ' jam';
            $biayaakhir = $cek['harga_sewa'] * $selesai['unit_total'] + (1000 * $dataWaktu['durasi_jam']);
        }


        $this->transaksi->save([
            'transaksi_id' => $selesai['transaksi_id'],
            'tgl_masuk' => date('Y-m-d'),
            'jam_masuk' => date('H:i:s'),
            'unit_total' => $selesai['unit_total'],
            'total' => $biayaakhir
        ]);

        $this->mobil->save([
            'mobil_id' => $selesai['mobil_id'],
            'unit' => $cek['unit'] + $selesai['unit_total']
        ]);

        return redirect()->to('/transaksi/masuk');
    }

    // public function edited()
    // {
    //     date_default_timezone_set('Asia/Jakarta');
    //     $this->transaksi->save([
    //         'transaksi_id' => $this->request->getVar('id'),
    //         'mobil_id' => $this->request->getVar('mobil'),
    //         'supir_id' => $this->request->getVar('supir'),
    //         'tgl_masuk' => date('Y-m-d'),
    //         'jam_masuk' => date('H:i:s'),
    //         'unit_total' => $this->request->getVar('unit'),
    //         'total' => 0
    //     ]);

    //     return redirect()->to('/transaksi/keluar');
    // }

    public function delete($id)
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }
        $selesai = $this->transaksi->find($id);

        $cek = $this->mobil->where('mobil_id', $selesai['mobil_id'])->first();

        $this->mobil->save([
            'mobil_id' => $selesai['mobil_id'],
            'unit' => $cek['unit'] + $selesai['unit_total']
        ]);

        $this->transaksi->delete($id);

        return redirect()->to('/transaksi/keluar');
    }

    public function bulanan()
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }

        $selectkan = [];
        $tahun = date('Y');
        for ($i = $tahun; $i > 2000; $i--) {
            $selectkan[] = $i;
        }

        $db = db_connect();
        $submit = $this->request->getVar('submit');
        if ($submit) {
            $bulan = $this->request->getVar('bulan');
            $tahun = $this->request->getVar('tahun');
            $datanya = $db->query("SELECT * FROM transaksi INNER JOIN mobil ON transaksi.mobil_id = mobil.mobil_id INNER JOIN supir ON transaksi.supir_id = supir.supir_id WHERE MONTH(tgl_masuk) = " . $bulan . " AND YEAR(tgl_masuk) = " . $tahun . " ORDER BY tgl_masuk DESC")->getResultArray();
            $dataTotal = $db->query("SELECT SUM(total) AS total_biaya FROM transaksi WHERE MONTH(tgl_masuk) = " . $bulan . " AND YEAR(tgl_masuk) = " . $tahun)->getRowArray();
            if (!$datanya) {
                echo "<script>
                    alert('Bulan ini kosong');
                    </script>";
                $dataPendapatan = null;
                $dataTotal = 0;
            } else {
                $dataPendapatan = $datanya;
            }
        } else {
            $datanya = $db->query("SELECT * FROM transaksi INNER JOIN mobil ON transaksi.mobil_id = mobil.mobil_id INNER JOIN supir ON transaksi.supir_id = supir.supir_id WHERE MONTH(tgl_masuk) = MONTH(CURRENT_DATE()) AND YEAR(tgl_masuk) = YEAR(CURRENT_DATE()) ORDER BY tgl_masuk DESC")->getResultArray();
            $dataTotal = $db->query("SELECT SUM(total) AS total_biaya FROM transaksi WHERE MONTH(tgl_masuk) = MONTH(CURRENT_DATE()) AND YEAR(tgl_masuk) = YEAR(CURRENT_DATE())")->getRowArray();
            if (!$datanya) {
                echo "<script>
                alert('Bulan ini kosong');
                </script>";
                $dataPendapatan = null;
                $dataTotal = 0;
            } else {
                $dataPendapatan = $datanya;
            }
        }

        $data = [
            'judul' => 'Pendapatan Bulanan',
            // 'data' => $this->parkir->where('biaya !=', 0)->orderBy('tgl_keluar', 'DESC')->findAll(),
            'data' => $dataPendapatan,
            // 'total' => $this->parkir->selectSum('biaya')->where('biaya !=', 0)->first()
            'total' => $dataTotal,
            'selectkan' => $selectkan
        ];
        return view('transaksi/bulanan', $data);
    }

    public function harian()
    {
        $db = db_connect();
        $datanya = $db->query("SELECT * FROM transaksi INNER JOIN mobil ON transaksi.mobil_id = mobil.mobil_id INNER JOIN supir ON transaksi.supir_id = supir.supir_id WHERE tgl_masuk = CURDATE() ORDER BY jam_masuk DESC")->getResultArray();
        $dataTotal = $db->query("SELECT SUM(total) AS total_biaya FROM transaksi WHERE tgl_masuk = CURDATE()")->getRowArray();
        if (!$datanya) {
            echo "<script>
                alert('Hari ini kosong');
                </script>";
            $dataPendapatan = null;
            $dataTotal = 0;
        } else {
            $dataPendapatan = $datanya;
        }

        $data = [
            'judul' => 'Pendapatan Harian',
            // 'data' => $this->parkir->where('biaya !=', 0)->orderBy('tgl_keluar', 'DESC')->findAll(),
            'data' => $dataPendapatan,
            // 'total' => $this->parkir->selectSum('biaya')->where('biaya !=', 0)->first()
            'total' => $dataTotal,
        ];
        return view('transaksi/harian', $data);
    }

    public function cetakharian()
    {
        $db = db_connect();
        $datanya = $db->query("SELECT * FROM transaksi INNER JOIN mobil ON transaksi.mobil_id = mobil.mobil_id INNER JOIN supir ON transaksi.supir_id = supir.supir_id WHERE tgl_masuk = CURDATE() ORDER BY jam_masuk DESC")->getResultArray();
        $dataTotal = $db->query("SELECT SUM(total) AS total_biaya FROM transaksi WHERE tgl_masuk = CURDATE()")->getRowArray();
        $this->fpdf->AddPage();
        $this->fpdf->SetFont('Arial', 'B', 16);
        $this->fpdf->Cell(0, 7, 'LIST TRANSAKSI HARIAN RENTAL MOBIL GIBRAN', 0, 1, 'C');
        $this->fpdf->Cell(10, 7, '', 0, 1);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Cell(10, 6, 'No', 1, 0, 'C');
        $this->fpdf->Cell(30, 6, 'Nama Mobil', 1, 0, 'C');
        $this->fpdf->Cell(30, 6, 'Nama Supir', 1, 0, 'C');
        $this->fpdf->Cell(30, 6, 'Tanggal Keluar', 1, 0, 'C');
        $this->fpdf->Cell(30, 6, 'Tanggal Masuk', 1, 0, 'C');
        $this->fpdf->Cell(30, 6, 'Jam Keluar', 1, 0, 'C');
        $this->fpdf->Cell(30, 6, 'Jam Masuk', 1, 0, 'C');
        $this->fpdf->Cell(30, 6, 'Unit', 1, 0, 'C');
        $this->fpdf->Cell(40, 6, 'Total Bayar', 1, 1, 'C');
        $this->fpdf->SetFont('Arial', '', 10);
        $i = 0;
        foreach ($datanya as $d) {
            $i++;
            $this->fpdf->Cell(10, 6, $i, 1, 0, 'C');
            $this->fpdf->Cell(30, 6, $d['nama_mobil'], 1, 0);
            $this->fpdf->Cell(30, 6, $d['nama_supir'], 1, 0);
            $this->fpdf->Cell(30, 6, date('d F Y', strtotime($d['tgl_keluar'])), 1, 0);
            $this->fpdf->Cell(30, 6, date('d F Y', strtotime($d['tgl_masuk'])), 1, 0);
            $this->fpdf->Cell(30, 6, $d['jam_keluar'], 1, 0);
            $this->fpdf->Cell(30, 6, $d['jam_masuk'], 1, 0);
            $this->fpdf->Cell(30, 6, $d['unit_total'], 1, 0);
            $this->fpdf->Cell(40, 6, 'Rp. ' . number_format($d['total'], 2, ',', '.'), 1, 1);
        }

        $this->fpdf->Cell(0, 7, "", 0, 1, 'C');
        $this->fpdf->Cell(40, 6, 'Pendapatan Harian : Rp. ' . number_format($dataTotal['total_biaya'], 2, ',', '.'), 0, 1);

        $this->fpdf->Output('D', 'list-transaksi-harian.pdf');
    }
}
