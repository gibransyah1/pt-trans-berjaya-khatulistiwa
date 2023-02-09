<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1>Form Tambah Transaksi</h1>
<form action="/transaksi/store" method="post">
    <ul>
        <li>
            <label for="mobil">Nama Mobil: </label>
            <select name="mobil" id="mobil">
                <?php foreach ($mobil as $m) : ?>
                    <option value="<?= $m['mobil_id']; ?>"><?= $m['nama_mobil']; ?></option>
                <?php endforeach; ?>
            </select>
        </li>
        <li>
            <label for="supir">Nama Supir: </label>
            <select name="supir" id="supir">
                <?php foreach ($supir as $s) : ?>
                    <option value="<?= $s['supir_id']; ?>"><?= $s['nama_supir']; ?></option>
                <?php endforeach; ?>
            </select>
        </li>
        <li>
            <label for="unit">Berapa Unit: </label>
            <input type="number" name="unit" id="unit">
        </li>
        <li>
            <button type="submit">Simpan</button>
        </li>
        <li>
            <a href="/transaksi/keluar">Kembali</a>
        </li>
    </ul>
</form>
<?= $this->endSection(); ?>