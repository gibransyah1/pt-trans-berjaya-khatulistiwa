<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1 class="judul-halaman">Form Tambah Merek</h1>
<form action="/merek/store" method="post">
    <ul class="merubah-ul">
        <li>
            <label for="nama">Nama: </label>
            <input type="text" name="nama" id="nama">
        </li>
        <li>
            <label for="negara">Negara: </label>
            <input type="text" name="negara" id="negara">
        </li>
        <li>
            <button type="submit" class="btn-keluar">Simpan</button>
        </li>
        <li>
            <br>
            <a href="/merek"><button type="button" class="btn-keluar">Kembali</button></a>
        </li>
    </ul>
</form>
<?= $this->endSection(); ?>