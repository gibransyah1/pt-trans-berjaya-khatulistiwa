<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1 class="judul-halaman">Form Tambah Merek</h1>
<form action="/merek/store" method="post">
    <ul class="merubah-ul">
        <li>
            <label for="nama">Nama: </label>
            <input type="text" name="nama" id="nama">
            <?php if (session()->getFlashdata('nama')) : ?>
                <p style="color: red; font-style: italic;"><?= session()->getFlashdata('nama') ?></p>
            <?php endif; ?>
        </li>
        <li>
            <label for="negara">Negara: </label>
            <input type="text" name="negara" id="negara">
            <?php if (session()->getFlashdata('negara')) : ?>
                <p style="color: red; font-style: italic;"><?= session()->getFlashdata('negara') ?></p>
            <?php endif; ?>
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