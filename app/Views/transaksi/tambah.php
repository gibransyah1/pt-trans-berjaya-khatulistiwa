<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1 class="judul-halaman">Form Tambah Transaksi</h1>
<form action="/transaksi/wadaw" method="post">
    <ul class="merubah-ul">
        <li>
            <label for="mobil">Nama Mobil: </label>
            <select name="mobil" id="mobil">
                <?php foreach ($mobil as $m) : ?>
                    <option value="<?= $m['mobil_id']; ?>"><?= $m['nama_mobil']; ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (session()->getFlashdata('mobil')) : ?>
                <p style="color: red; font-style: italic;"><?= session()->getFlashdata('mobil') ?></p>
            <?php endif; ?>
        </li>
        <li>
            <label for="supir">Nama Supir: </label>
            <select name="supir" id="supir">
                <?php foreach ($supir as $s) : ?>
                    <option value="<?= $s['supir_id']; ?>"><?= $s['nama_supir']; ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (session()->getFlashdata('supir')) : ?>
                <p style="color: red; font-style: italic;"><?= session()->getFlashdata('supir') ?></p>
            <?php endif; ?>
        </li>
        <li>
            <label for="unit">Berapa Unit: </label>
            <input type="number" name="unit" id="unit">
            <?php if (session()->getFlashdata('unit')) : ?>
                <p style="color: red; font-style: italic;"><?= session()->getFlashdata('unit') ?></p>
            <?php endif; ?>
        </li>
    </ul>
    <button type="submit" class="btn-keluar">Simpan</button>

    <a href="/transaksi/keluar"><button type="button" class="btn-keluar kanan-test">Kembali</button></a>
</form>
<?= $this->endSection(); ?>