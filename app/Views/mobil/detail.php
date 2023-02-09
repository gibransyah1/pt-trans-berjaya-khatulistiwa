<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1>Detail Merek</h1>
<ul>
    <li>
        Nama Mobil : <?= $data['nama_mobil']; ?>
    </li>
    <li>
        Jenis : <?= $data['jenis']; ?>
    </li>
    <li>
        Kapasitas Mesin : <?= $data['kapasitas_mesin']; ?>
    </li>
    <li>
        Harga Sewa : <?= $data['harga_sewa']; ?>
    </li>
    <li>
        Merek : <?= $data['nama']; ?>
    </li>
    <li>
        <a href="/mobil">Kembali</a>
    </li>
</ul>
<?= $this->endSection(); ?>