<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1 class="judul-halaman">Form Tambah Supir</h1>
<form action="/supir/store" method="post">
    <ul class="merubah-ul">
        <li>
            <label for="supir">Nama Supir: </label>
            <input type="text" name="supir" id="supir">
        </li>
        <li>
            <label for="alamat">Alamat: </label>
            <br>
            <textarea name="alamat" id="alamat" cols="30" rows="10"></textarea>
        </li>
        <li>
            <label for="telp">No Telp: </label>
            <input type="number" name="telp" id="telp">
        </li>
        <li>
            <button type="submit" class="btn-keluar">Simpan</button>
        </li>
        <li>
            <br>
            <a href="/supir"><button type="button" class="btn-keluar">Simpan</button></a>
        </li>
    </ul>
</form>
<?= $this->endSection(); ?>