<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1>Detail Supir</h1>
<ul>
    <li>
        Supir : <?= $data['nama_supir']; ?>
    </li>
    <li>
        Alamat : <?= $data['alamat']; ?>
    </li>
    <li>
        No Telp : <?= $data['no_telp']; ?>
    </li>
    <li>
        <a href="/supir">Kembali</a>
    </li>
</ul>
<?= $this->endSection(); ?>