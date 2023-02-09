<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul; ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="sidebar">
        <div class="nyambung-backend">
            <!-- <a href="/admin/artikel"><img src="/assets/img/logo.png" alt="logo" width="95"></a> -->
            <p style="font-size: 12pt; font-weight:bold;">Rental Mobil Gibran</p>
        </div>
        <a href="#">
            <div class="kotak-akun">
                <div class="wadahan-foto">
                    <img src="/assets/gambar/test.jpg" alt="foto">
                </div>
                <p>Gibran</p>
            </div>
        </a>
        <ul>
            <li><a href="/">Dashboard</a></li>
            <li><a href="/merek">Merek</a></li>
            <li><a href="/mobil">Mobil</a></li>
            <li><a href="/supir">Supir</a></li>
            <li><a href="/transaksi/keluar">Mobil Sedang dipinjam</a></li>
            <li><a href="/transaksi/masuk">Mobil Sudah dikembalikan</a></li>
            <li><a href="/transaksi/bulanan">Laporan Bulanan</a></li>
            <li><a href="/transaksi/harian">Laporan Harian</a></li>
        </ul>
    </div>
    <div class="judul-backend">
        <p><a href="/users/logout">Logout</a></p>
    </div>
    <div class="main-utama">
        <?= $this->renderSection('content'); ?>
    </div>
    <div class="footer">
        <p>Copyright &copy; 2022 Gibrannews | Visit gibransyahportfolio.com for more information.</p>
    </div>
</body>

</html>