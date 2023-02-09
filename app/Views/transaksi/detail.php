<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1>Detail Transaksi</h1>
<ul>
    <li>
        Nama Mobil : <?= $data['nama_mobil']; ?>
    </li>
    <li>
        Supir : <?= $data['nama_supir']; ?>
    </li>
    <li>
        Tanggal Keluar : <?= $data['tgl_keluar']; ?>
    </li>
    <li>
        Jam keluar : <?= $data['jam_keluar']; ?>
    </li>
    <li>
        <a href="/transaksi/keluar">Kembali</a>
    </li>
</ul>
<?= $this->endSection(); ?>