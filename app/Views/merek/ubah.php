<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1 class="judul-halaman">Form Ubah Merek</h1>
<form action="/merek/edited" method="post">
    <input type="hidden" name="id" value="<?= $data['merek_id']; ?>">
    <ul class="merubah-ul">
        <li>
            <label for="nama">Nama: </label>
            <input type="text" name="nama" id="nama" value="<?= $data['nama']; ?>">
        </li>
        <li>
            <label for="negara">Negara: </label>
            <input type="text" name="negara" id="negara" value="<?= $data['negara']; ?>">
        </li>
        <li>
            <button type="submit" class="btn-keluar">Ubah</button>
        </li>
        <li>
            <br>
            <a href="/merek"><button type="button" class="btn-keluar">Kembali</button></a>
        </li>
    </ul>
</form>
<?= $this->endSection(); ?>