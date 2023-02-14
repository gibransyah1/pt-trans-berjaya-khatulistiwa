<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1 class="judul-halaman">Form Ubah Supir</h1>
<form action="/supir/edited" method="post">
    <input type="hidden" name="id" value="<?= $data['supir_id']; ?>">
    <ul class="merubah-ul">
        <li>
            <label for="supir">Nama Supir: </label>
            <input type="text" name="supir" id="supir" value="<?= $data['nama_supir']; ?>">
            <?php if (session()->getFlashdata('supir')) : ?>
                <p style="color: red; font-style: italic;"><?= session()->getFlashdata('supir') ?></p>
            <?php endif; ?>
        </li>
        <li>
            <label for="alamat">Alamat: </label>
            <br>
            <textarea name="alamat" id="alamat" cols="30" rows="10"><?= $data['alamat']; ?></textarea>
            <?php if (session()->getFlashdata('alamat')) : ?>
                <p style="color: red; font-style: italic;"><?= session()->getFlashdata('alamat') ?></p>
            <?php endif; ?>
        </li>
        <li>
            <label for="telp">No Telp: </label>
            <input type="number" name="telp" id="telp" value="<?= $data['no_telp']; ?>">
            <?php if (session()->getFlashdata('telp')) : ?>
                <p style="color: red; font-style: italic;"><?= session()->getFlashdata('telp') ?></p>
            <?php endif; ?>
        </li>
        <li>
            <button type="submit" class="btn-keluar">Ubah</button>
        </li>
        <li>
            <br>
            <a href="/supir"><button type="button" class="btn-keluar">Kembali</button></a>
        </li>
    </ul>
</form>
<?= $this->endSection(); ?>