<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1 class="judul-halaman">Form Tambah Mobil</h1>
<form action="/mobil/store" method="post" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <ul class="merubah-ul">
        <li>
            <label for="gambar">Gambar: </label>
            <input type="file" name="gambar" id="gambar">
            <?php if (session()->getFlashdata('gambar')) : ?>
                <p style="color: red; font-style: italic;"><?= session()->getFlashdata('gambar') ?></p>
            <?php endif; ?>
        </li>
        <li>
            <label for="namamobil">Nama Mobil: </label>
            <input type="text" name="namamobil" id="namamobil">
            <?php if (session()->getFlashdata('namamobil')) : ?>
                <p style="color: red; font-style: italic;"><?= session()->getFlashdata('namamobil') ?></p>
            <?php endif; ?>
        </li>
        <li>
            <label for="jenis">Jenis: </label>
            <input type="text" name="jenis" id="jenis">
            <?php if (session()->getFlashdata('jenis')) : ?>
                <p style="color: red; font-style: italic;"><?= session()->getFlashdata('jenis') ?></p>
            <?php endif; ?>
        </li>
        <li>
            <label for="kapasitas">Kapasitas Mesin: </label>
            <input type="text" name="kapasitas" id="kapasitas">
            <?php if (session()->getFlashdata('kapasitas')) : ?>
                <p style="color: red; font-style: italic;"><?= session()->getFlashdata('kapasitas') ?></p>
            <?php endif; ?>
        </li>
        <li>
            <label for="harga">Harga Sewa: </label>
            <input type="text" name="harga" id="harga">
            <?php if (session()->getFlashdata('harga')) : ?>
                <p style="color: red; font-style: italic;"><?= session()->getFlashdata('harga') ?></p>
            <?php endif; ?>
        </li>
        <li>
            <label for="merek">Merek: </label>
            <select name="merek" id="merek">
                <?php foreach ($data as $d) : ?>
                    <option value="<?= $d['merek_id']; ?>"><?= $d['nama']; ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (session()->getFlashdata('merek')) : ?>
                <p style="color: red; font-style: italic;"><?= session()->getFlashdata('merek') ?></p>
            <?php endif; ?>
        </li>
        <li>
            <label for="unit">Unit: </label>
            <input type="number" name="unit" id="unit">
            <?php if (session()->getFlashdata('unit')) : ?>
                <p style="color: red; font-style: italic;"><?= session()->getFlashdata('unit') ?></p>
            <?php endif; ?>
        </li>
    </ul>
    <button type="submit" class="btn-keluar">Simpan</button>

    <a href="/mobil"><button type="button" class="btn-keluar kanan-test">Kembali</button></a>
</form>
<?= $this->endSection(); ?>