<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1>Detail Merek</h1>
<ul>
    <li>
        Merek : <?= $data['nama']; ?>
    </li>
    <li>
        Negara : <?= $data['negara']; ?>
    </li>
    <li>
        <a href="/merek">Kembali</a>
    </li>
</ul>
<?= $this->endSection(); ?>