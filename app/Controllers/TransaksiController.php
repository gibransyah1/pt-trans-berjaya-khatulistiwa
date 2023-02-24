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

        // $query = $this->transaksi->find($id);
        // $pembayaran = $query['islunas'];
        // $dp = $query['nominal'];
        // if ($pembayaran == 0) {
        //     $sisa = $biayaakhir - $dp;
        // }

        $currentPage = $this->request->getVar('page_pinjam') ? $this->request->getVar('page_pinjam') : 1;
        $data = [
            'judul' => 'List Transaksi',
            'data' => $this->transaksi->join('mobil', 'transaksi.mobil_id = mobil.mobil_id')->join('supir', 'transaksi.supir_id = supir.supir_id')->orderBy('tgl_keluar', 'DESC')->paginate(5, 'pinjam'),
            'pager' => $this->transaksi->pager,
            'currentPage' => $currentPage
        ];

        return view('transaksi/index', $data);
    }

    // public function masuk()
    // {
    //     if (!$this->session->get('login')) {
    //         return redirect()->to('/users/login');
    //     }
    //     $currentPage = $this->request->getVar('page_kembali') ? $this->request->getVar('page_kembali') : 1;
    //     $data = [
    //         'judul' => 'List Mobil Sudah dikembalikan',
    //         'data' => $this->transaksi->join('mobil', 'transaksi.mobil_id = mobil.mobil_id')->join('supir', 'transaksi.supir_id = supir.supir_id')->where('total !=', 0)->orderBy('tgl_masuk', 'DESC')->orderBy('jam_masuk', 'DESC')->paginate(2, 'kembali'),
    //         'pager' => $this->transaksi->pager,
    //         'currentPage' => $currentPage
    //     ];

    //     return view('transaksi/masuk', $data);
    // }

    public function show($id)
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }

        $data = [
            'judul' => 'Detail Transaksi',
            'data' => $this->transaksi->join('mobil', 'transaksi.mobil_id = mobil.mobil_id')->join('supir', 'transaksi.supir_id = supir.supir_id')->find($id),
            'id' => $id
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
        $date1 = date_create(date('Y-m-d'));
        $date2 = date_create($this->request->getVar('kembali'));
        $diff = date_diff($date1, $date2);
        $hari = $diff->d;
        $mobil = $this->mobil->find($this->request->getVar('id'));
        $harga = $mobil['harga_sewa'];
        if ($hari > 0) {
            $total = $harga + ($harga * $hari);
        } else {
            $total = $harga;
        }
        // $validation = \Config\Services::validation();

        // if (!$this->validate([
        //     'mobil' => [
        //         'rules' => 'required',
        //         'errors' => [
        //             'required' => '{field} harus diisi.'
        //         ]
        //     ],
        //     'supir' => [
        //         'rules' => 'required',
        //         'errors' => [
        //             'required' => '{field} harus diisi.'
        //         ]
        //     ],
        //     'unit' => [
        //         'rules' => 'required',
        //         'errors' => [
        //             'required' => '{field} harus diisi.'
        //         ]
        //     ]
        // ])) {
        //     $this->session->setFlashdata('mobil', $validation->getError('mobil'));
        //     $this->session->setFlashdata('supir', $validation->getError('supir'));
        //     $this->session->setFlashdata('unit', $validation->getError('unit'));
        //     $this->session->setFlashdata('flash', 'Tambah Transaksi Gagal!');
        //     return redirect()->to('/transaksi/create')->withInput();
        // }



        $cetak = $this->request->getVar('cetak');
        if ($cetak) {
            $mobil = $this->mobil->find($this->request->getVar('id'));
            $supir = $this->supir->find($this->request->getVar('supir'));
            $namamobil = $mobil['nama_mobil'];
            $namasupir = $supir['nama_supir'];
            $penyewa = $this->request->getVar('penyewa');
            $kembali = $this->request->getVar('kembali');
            $pebayaranmentah = $this->request->getVar('pembayaran');
            $nominal = $this->request->getVar('nominal');
            $waktusekarang = date('Y-m-d');
            if ($pebayaranmentah == 1) {
                $pembayaran = 'Lunas';
            } else {
                $pembayaran = 'Dp';
            }

            if ($penyewa == '' && $kembali == '') {
                $this->session->setFlashdata('flash', 'Cetak struk gagal!');
                return redirect()->to('/mobil');
            } else {
                $sisa = $total - $nominal;
                $this->fpdf->AddPage();
                $this->fpdf->SetFont('Times', 'B', 16);
                $this->fpdf->Cell(0, 7, "Struk Pembayaran", 0, 1, 'C');
                $this->fpdf->Cell(0, 7, "", 'B', 1, 'C');
                $this->fpdf->Cell(0, 7, "", 0, 1, 'C');
                $this->fpdf->SetFont('Times', '', 12);
                $this->fpdf->Cell(30, 5, 'Nama Mobil');
                $this->fpdf->Cell(5, 5, ':');
                $this->fpdf->Cell(30, 5, "$namamobil", 0, 1);
                $this->fpdf->Cell(30, 5, 'Nama Supir');
                $this->fpdf->Cell(5, 5, ':');
                $this->fpdf->Cell(30, 5, "$namasupir", 0, 1);
                $this->fpdf->Cell(30, 5, 'Nama Penyewa');
                $this->fpdf->Cell(5, 5, ':');
                $this->fpdf->Cell(30, 5, "$penyewa", 0, 1);
                $this->fpdf->Cell(30, 5, 'Tanggal Pinjam');
                $this->fpdf->Cell(5, 5, ':');
                $this->fpdf->Cell(30, 5, "$waktusekarang", 0, 1);
                $this->fpdf->Cell(30, 5, 'Tanggal Kembali');
                $this->fpdf->Cell(5, 5, ':');
                $this->fpdf->Cell(30, 5, "$kembali", 0, 1);
                $this->fpdf->Cell(30, 5, 'Pembayaran');
                $this->fpdf->Cell(5, 5, ':');
                $this->fpdf->Cell(30, 5, "$pembayaran", 0, 1);
                $this->fpdf->Cell(30, 5, 'Uang Muka');
                $this->fpdf->Cell(5, 5, ':');
                $this->fpdf->Cell(30, 5, "Rp. $nominal,-", 0, 1);
                $this->fpdf->Cell(30, 5, 'Sisa Bayar');
                $this->fpdf->Cell(5, 5, ':');
                $this->fpdf->Cell(30, 5, "Rp. $sisa,-", 0, 1);
                $this->fpdf->Cell(30, 5, 'Total Akhir');
                $this->fpdf->Cell(5, 5, ':');
                $this->fpdf->Cell(30, 5, "Rp. $total,-", 0, 1);
                $this->fpdf->Cell(0, 7, "", 0, 1, 'C');
                // $this->fpdf->Cell(30, 5, '*Parkir lebih dari 1 jam dikenai biaya tambahan Rp. 1000,- berlaku kelipatan jam', 0, 1);
                $this->fpdf->Cell(30, 5, '*Sewa lebih dari 1 hari dikenai biaya sesuai dikali dengan hari,- berlaku kelipatan hari');
                $this->fpdf->Output('D', 'struk-pembayaran-rental.pdf');
            }
        } else {
            date_default_timezone_set('Asia/Jakarta');
            $lunas = $this->request->getVar('pembayaran');
            if ($lunas == 0) {
                $uang = 0;
            } else {
                $uang = $lunas;
            }

            $this->transaksi->save([
                'mobil_id' => $this->request->getVar('id'),
                'supir_id' => $this->request->getVar('supir'),
                'penyewa' => $this->request->getVar('penyewa'),
                'tgl_keluar' => date('Y-m-d'),
                'tgl_masuk' => $this->request->getVar('kembali'),
                'islunas' => $uang,
                'nominal' => $this->request->getVar('nominal'),
                'total' => $total,
                'status_pinjam' => 'dibooking'
            ]);

            $this->mobil->save([
                'mobil_id' => $this->request->getVar('id'),
                'status' => 'dibooking'
            ]);
            return redirect()->to('/mobil');
        }
    }

    public function edit($id)
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }

        $data = [
            'judul' => 'Sewa Mobil',
            'data' => $this->mobil->find($id),
            'mobil' => $this->mobil->findAll(),
            'supir' => $this->supir->findAll()
        ];
        return view('transaksi/ubah', $data);
    }

    public function edited($id = null)
    {
        $query = $this->transaksi->join('mobil', 'transaksi.mobil_id = mobil.mobil_id')->find($id);
        // $harga = $query['harga_sewa'];
        $mobilid = $query['mobil_id'];
        // $db = db_connect();
        // $dataSewa = $db->query("SELECT *, DATEDIFF(tgl_masuk, tgl_keluar) durasi_hari "
        //     . "FROM transaksi WHERE transaksi_id='" . $id . "' AND total=0")->getRowArray();
        // if ($dataSewa['durasi_hari'] > 0) {
        //     // $durasiHari = $dataSewa['durasi_hari'] . ' Hari';
        //     // $durasiJam = '-';
        //     $biayaakhir = $harga + ($harga * $dataSewa['durasi_hari']);
        // } else {
        //     // $durasiHari = '0 hari';
        //     // $durasiJam = $dataSewa['durasi_jam'] . ' jam';
        //     $biayaakhir = $harga;
        // }

        $this->mobil->save([
            'mobil_id' => $mobilid,
            'status' => 'tersedia'
        ]);

        $this->transaksi->save([
            'transaksi_id' => $id,
            'status_pinjam' => 'dikembalikan',
        ]);

        return redirect()->to('/transaksi');
    }

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

        return redirect()->to('/transaksi');
    }

    public function bulanan()
    {
        if (!$this->session->get('login')) {
            return redirect()->to('/users/login');
        }

        $db = db_connect();
        $januari = $db->query('SELECT * FROM transaksi WHERE MONTH(tgl_masuk) = 1 AND YEAR(tgl_masuk) = 2023')->getNumRows();
        $februari = $db->query('SELECT * FROM transaksi WHERE MONTH(tgl_masuk) = 2 AND YEAR(tgl_masuk) = 2023')->getNumRows();
        $maret = $db->query('SELECT * FROM transaksi WHERE MONTH(tgl_masuk) = 3 AND YEAR(tgl_masuk) = 2023')->getNumRows();
        $april = $db->query('SELECT * FROM transaksi WHERE MONTH(tgl_masuk) = 4 AND YEAR(tgl_masuk) = 2023')->getNumRows();
        $mei = $db->query('SELECT * FROM transaksi WHERE MONTH(tgl_masuk) = 5 AND YEAR(tgl_masuk) = 2023')->getNumRows();
        $juni = $db->query('SELECT * FROM transaksi WHERE MONTH(tgl_masuk) = 6 AND YEAR(tgl_masuk) = 2023')->getNumRows();
        $juli = $db->query('SELECT * FROM transaksi WHERE MONTH(tgl_masuk) = 7 AND YEAR(tgl_masuk) = 2023')->getNumRows();
        $agustus = $db->query('SELECT * FROM transaksi WHERE MONTH(tgl_masuk) = 8 AND YEAR(tgl_masuk) = 2023')->getNumRows();
        $september = $db->query('SELECT * FROM transaksi WHERE MONTH(tgl_masuk) = 9 AND YEAR(tgl_masuk) = 2023')->getNumRows();
        $oktober = $db->query('SELECT * FROM transaksi WHERE MONTH(tgl_masuk) = 10 AND YEAR(tgl_masuk) = 2023')->getNumRows();
        $november = $db->query('SELECT * FROM transaksi WHERE MONTH(tgl_masuk) = 11 AND YEAR(tgl_masuk) = 2023')->getNumRows();
        $desember = $db->query('SELECT * FROM transaksi WHERE MONTH(tgl_masuk) = 12 AND YEAR(tgl_masuk) = 2023')->getNumRows();
        // $bubulan = 0;
        // $bubulan1 = 0;

        $selectkan = [];
        $tahun = date('Y');
        for ($i = $tahun; $i > 2000; $i--) {
            $selectkan[] = $i;
        }

        $db = db_connect();
        $submit = $this->request->getVar('submit');
        if ($submit) {
            // $bulan = $this->request->getVar('bulan');
            // $tahun = $this->request->getVar('tahun');

            $bulan = $this->request->getVar('bulan');
            $bulan1 = $this->request->getVar('bulan1');
            $idbayar = $this->request->getVar('idbayar');

            // $bubulan = $db->query("SELECT * FROM transaksi  WHERE tgl_masuk = '" . $bulan . "' AND islunas = " . $idbayar)->getNumRows();
            // $bubulan1 = $db->query("SELECT * FROM transaksi  WHERE tgl_masuk = '" . $bulan1 . "' AND islunas = " . $idbayar)->getNumRows();

            if ($bulan == '' && $bulan1 == '') {
                $bulan = date('Y-m-d');
                $bulan1 = date('Y-m-d');
            }
            $this->session->set('bulan', $bulan);
            $this->session->set('bulan1', $bulan1);
            $this->session->set('idbayar', $idbayar);
            // $datanya = $db->query("SELECT * FROM transaksi INNER JOIN mobil ON transaksi.mobil_id = mobil.mobil_id INNER JOIN supir ON transaksi.supir_id = supir.supir_id WHERE MONTH(tgl_masuk) = " . $bulan . " AND YEAR(tgl_masuk) = " . $tahun . " AND total != 0 ORDER BY tgl_masuk DESC")->getResultArray();
            // $dataTotal = $db->query("SELECT SUM(total) AS total_biaya FROM transaksi WHERE MONTH(tgl_masuk) = " . $bulan . " AND YEAR(tgl_masuk) = " . $tahun . " AND total != 0 ORDER BY tgl_masuk DESC")->getRowArray();
            $datanya = $db->query("SELECT * FROM transaksi INNER JOIN mobil ON transaksi.mobil_id = mobil.mobil_id INNER JOIN supir ON transaksi.supir_id = supir.supir_id WHERE tgl_masuk BETWEEN '" . $bulan . "' AND '" . $bulan1 . "' AND islunas = " . $idbayar . " ORDER BY tgl_masuk ASC")->getResultArray();
            $dataTotal = $db->query("SELECT SUM(total) AS total_biaya FROM transaksi WHERE tgl_masuk BETWEEN '" . $bulan . "' AND '" . $bulan1 . "' AND islunas = " . $idbayar . " ORDER BY tgl_masuk ASC")->getRowArray();
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
            $dataTotal = $db->query("SELECT SUM(total) AS total_biaya FROM transaksi WHERE MONTH(tgl_masuk) = MONTH(CURRENT_DATE()) AND YEAR(tgl_masuk) = YEAR(CURRENT_DATE()) AND total != 0")->getRowArray();
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
            'selectkan' => $selectkan,
            'januari' => $januari,
            'februari' => $februari,
            'maret' => $maret,
            'april' => $april,
            'mei' => $mei,
            'juni' => $juni,
            'juli' => $juli,
            'agustus' => $agustus,
            'september' => $september,
            'oktober' => $oktober,
            'november' => $november,
            'desember' => $desember
            // 'bubulan' => $bubulan,
            // 'bubulan1' => $bubulan1
        ];
        return view('transaksi/bulanan', $data);
    }

    public function excel()
    {
        $db = db_connect();
        $bulan = $this->session->get('bulan');
        $bulan1 = $this->session->get('bulan1');
        $idbayar = $this->session->get('idbayar');
        if ($bulan && $bulan1 && $idbayar) {
            $datanya = $db->query("SELECT * FROM transaksi INNER JOIN mobil ON transaksi.mobil_id = mobil.mobil_id INNER JOIN supir ON transaksi.supir_id = supir.supir_id WHERE tgl_masuk BETWEEN '" . $bulan . "' AND '" . $bulan1 . "' AND islunas = " . $idbayar . " ORDER BY tgl_masuk ASC")->getResultArray();
        } else {
            $datanya =  $datanya = $db->query("SELECT * FROM transaksi INNER JOIN mobil ON transaksi.mobil_id = mobil.mobil_id INNER JOIN supir ON transaksi.supir_id = supir.supir_id WHERE MONTH(tgl_masuk) = MONTH(CURRENT_DATE()) AND YEAR(tgl_masuk) = YEAR(CURRENT_DATE()) ORDER BY tgl_masuk DESC")->getResultArray();
        }
        $data = [
            'datanya' => $datanya
        ];
        return view('transaksi/excel', $data);
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

    // public function cetakharian()
    // {
    //     $db = db_connect();
    //     $datanya = $db->query("SELECT * FROM transaksi INNER JOIN mobil ON transaksi.mobil_id = mobil.mobil_id INNER JOIN supir ON transaksi.supir_id = supir.supir_id WHERE tgl_masuk = CURDATE() ORDER BY jam_masuk DESC")->getResultArray();
    //     $dataTotal = $db->query("SELECT SUM(total) AS total_biaya FROM transaksi WHERE tgl_masuk = CURDATE()")->getRowArray();
    //     $this->fpdf->AddPage();
    //     $this->fpdf->SetFont('Arial', 'B', 16);
    //     $this->fpdf->Cell(0, 7, 'LIST TRANSAKSI HARIAN RENTAL MOBIL GIBRAN', 0, 1, 'C');
    //     $this->fpdf->Cell(10, 7, '', 0, 1);
    //     $this->fpdf->SetFont('Arial', 'B', 10);
    //     $this->fpdf->Cell(10, 6, 'No', 1, 0, 'C');
    //     $this->fpdf->Cell(30, 6, 'Nama Mobil', 1, 0, 'C');
    //     $this->fpdf->Cell(30, 6, 'Nama Supir', 1, 0, 'C');
    //     $this->fpdf->Cell(30, 6, 'Tanggal Keluar', 1, 0, 'C');
    //     $this->fpdf->Cell(30, 6, 'Tanggal Masuk', 1, 0, 'C');
    //     $this->fpdf->Cell(30, 6, 'Jam Keluar', 1, 0, 'C');
    //     $this->fpdf->Cell(30, 6, 'Jam Masuk', 1, 0, 'C');
    //     $this->fpdf->Cell(30, 6, 'Unit', 1, 0, 'C');
    //     $this->fpdf->Cell(40, 6, 'Total Bayar', 1, 1, 'C');
    //     $this->fpdf->SetFont('Arial', '', 10);
    //     $i = 0;
    //     foreach ($datanya as $d) {
    //         $i++;
    //         $this->fpdf->Cell(10, 6, $i, 1, 0, 'C');
    //         $this->fpdf->Cell(30, 6, $d['nama_mobil'], 1, 0);
    //         $this->fpdf->Cell(30, 6, $d['nama_supir'], 1, 0);
    //         $this->fpdf->Cell(30, 6, date('d F Y', strtotime($d['tgl_keluar'])), 1, 0);
    //         $this->fpdf->Cell(30, 6, date('d F Y', strtotime($d['tgl_masuk'])), 1, 0);
    //         $this->fpdf->Cell(30, 6, $d['jam_keluar'], 1, 0);
    //         $this->fpdf->Cell(30, 6, $d['jam_masuk'], 1, 0);
    //         $this->fpdf->Cell(30, 6, $d['unit_total'], 1, 0);
    //         $this->fpdf->Cell(40, 6, 'Rp. ' . number_format($d['total'], 2, ',', '.'), 1, 1);
    //     }

    //     $this->fpdf->Cell(0, 7, "", 0, 1, 'C');
    //     $this->fpdf->Cell(40, 6, 'Pendapatan Harian : Rp. ' . number_format($dataTotal['total_biaya'], 2, ',', '.'), 0, 1);

    //     $this->fpdf->Output('D', 'list-transaksi-harian.pdf');
    // }

    public function ambil($id = null)
    {
        $cek = $this->transaksi->find($id); //lieureun

        $this->mobil->save([
            'mobil_id' => $cek['mobil_id'],
            'status' => 'disewa'
        ]);

        $this->transaksi->save([
            'transaksi_id' => $id,
            'status_pinjam' => 'dipinjam'
        ]);
        return redirect()->to('/mobil');
    }

    public function lunas($id = null)
    {
        $this->transaksi->save([
            'transaksi_id' => $id,
            'islunas' => 1,
            'nominal' => 0
        ]);

        return redirect()->to('/transaksi');
    }

    public function cetaklunas($id = null)
    {

        $transaksi = $this->transaksi->find($id);
        $mobil = $this->mobil->find($transaksi['mobil_id']);
        $supir = $this->supir->find($transaksi['supir_id']);
        $namamobil = $mobil['nama_mobil'];
        $namasupir = $supir['nama_supir'];
        $penyewa = $transaksi['penyewa'];
        $kembali = $transaksi['tgl_masuk'];
        $pebayaranmentah = $transaksi['islunas'];
        $nominal = $transaksi['nominal'];
        $waktusekarang = $transaksi['tgl_keluar'];
        if ($pebayaranmentah == 1) {
            $pembayaran = 'Lunas';
        } else {
            $pembayaran = 'Dp';
        }
        $total = $transaksi['total'];
        $sisa = $total - $nominal;

        $this->fpdf->AddPage();
        $this->fpdf->SetFont('Times', 'B', 16);
        $this->fpdf->Cell(0, 7, "Struk Pembayaran Lunas", 0, 1, 'C');
        $this->fpdf->Cell(0, 7, "", 'B', 1, 'C');
        $this->fpdf->Cell(0, 7, "", 0, 1, 'C');
        $this->fpdf->SetFont('Times', '', 12);
        $this->fpdf->Cell(30, 5, 'Nama Mobil');
        $this->fpdf->Cell(5, 5, ':');
        $this->fpdf->Cell(30, 5, "$namamobil", 0, 1);
        $this->fpdf->Cell(30, 5, 'Nama Supir');
        $this->fpdf->Cell(5, 5, ':');
        $this->fpdf->Cell(30, 5, "$namasupir", 0, 1);
        $this->fpdf->Cell(30, 5, 'Nama Penyewa');
        $this->fpdf->Cell(5, 5, ':');
        $this->fpdf->Cell(30, 5, "$penyewa", 0, 1);
        $this->fpdf->Cell(30, 5, 'Tanggal Pinjam');
        $this->fpdf->Cell(5, 5, ':');
        $this->fpdf->Cell(30, 5, "$waktusekarang", 0, 1);
        $this->fpdf->Cell(30, 5, 'Tanggal Kembali');
        $this->fpdf->Cell(5, 5, ':');
        $this->fpdf->Cell(30, 5, "$kembali", 0, 1);
        $this->fpdf->Cell(30, 5, 'Pembayaran');
        $this->fpdf->Cell(5, 5, ':');
        $this->fpdf->Cell(30, 5, "Lunas", 0, 1);
        $this->fpdf->Cell(30, 5, 'Uang Muka');
        $this->fpdf->Cell(5, 5, ':');
        $this->fpdf->Cell(30, 5, "Rp. 0,-", 0, 1);
        $this->fpdf->Cell(30, 5, 'Sisa Bayar');
        $this->fpdf->Cell(5, 5, ':');
        $this->fpdf->Cell(30, 5, "Rp. 0,-", 0, 1);
        $this->fpdf->Cell(30, 5, 'Total Akhir');
        $this->fpdf->Cell(5, 5, ':');
        $this->fpdf->Cell(30, 5, "Rp. $total,-", 0, 1);
        $this->fpdf->Cell(0, 7, "", 0, 1, 'C');
        // $this->fpdf->Cell(30, 5, '*Parkir lebih dari 1 jam dikenai biaya tambahan Rp. 1000,- berlaku kelipatan jam', 0, 1);
        $this->fpdf->Cell(30, 5, '*Sewa lebih dari 1 hari dikenai biaya sesuai dikali dengan hari,- berlaku kelipatan hari');
        $this->fpdf->Output('D', 'struk-pembayaran-rental.pdf');
    }

    public function batal($id = null)
    {
        $query = $this->transaksi->join('mobil', 'transaksi.mobil_id = mobil.mobil_id')->find($id);
        $mobilid = $query['mobil_id'];

        $this->mobil->save([
            'mobil_id' => $mobilid,
            'status' => 'tersedia'
        ]);

        $this->transaksi->save([
            'transaksi_id' => $id,
            'islunas' => 3,
            'status_pinjam' => 'dibatalkan',
            'nominal' => 0,
            'total' => 0
        ]);

        return redirect()->to('/transaksi');
    }
}
