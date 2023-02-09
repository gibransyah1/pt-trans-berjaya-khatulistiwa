<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1 class="judul-halaman">Form Tambah Mobil</h1>
<form action="/mobil/store" method="post" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <ul class="merubah-ul">
        <li>
            <label for="gambar">Gambar: </label>
            <input type="file" name="gambar" id="gambar">
        </li>
        <li>
            <label for="namamobil">Nama Mobil: </label>
            <input type="text" name="namamobil" id="namamobil">
        </li>
        <li>
            <label for="jenis">Jenis: </label>
            <input type="text" name="jenis" id="jenis">
        </li>
        <li>
            <label for="kapasitas">Kapasitas Mesin: </label>
            <input type="text" name="kapasitas" id="kapasitas">
        </li>
        <li>
            <label for="harga">Harga Sewa: </label>
            <input type="text" name="harga" id="harga">
        </li>
        <li>
            <label for="merek">Merek: </label>
            <select name="merek" id="merek">
                <?php foreach ($data as $d) : ?>
                    <option value="<?= $d['merek_id']; ?>"><?= $d['nama']; ?></option>
                <?php endforeach; ?>
            </select>
        </li>
        <li>
            <label for="unit">Unit: </label>
            <input type="number" name="unit" id="unit">
        </li>
        <li>
            <br>
            <button type="submit" class="btn-keluar">Simpan</button>
        </li>
        <li>
            <br>
            <a href="/mobil"><button type="button" class="btn-keluar">Kembali</button></a>
        </li>
    </ul>
</form>
<?= $this->endSection(); ?>