<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1>Form Ubah Mobil</h1>
<form action="/mobil/edited" method="post">
    <input type="hidden" name="id" value="<?= $data['mobil_id']; ?>">
    <ul>
        <li>
            <label for="namamobil">Nama Mobil: </label>
            <input type="text" name="namamobil" id="namamobil" value="<?= $data['nama_mobil']; ?>">
        </li>
        <li>
            <label for="jenis">Jenis: </label>
            <input type="text" name="jenis" id="jenis" value="<?= $data['jenis']; ?>">
        </li>
        <li>
            <label for="kapasitas">Kapasitas Mesin: </label>
            <input type="text" name="kapasitas" id="kapasitas" value="<?= $data['kapasitas_mesin']; ?>">
        </li>
        <li>
            <label for="harga">Harga Sewa: </label>
            <input type="text" name="harga" id="harga" value="<?= $data['harga_sewa']; ?>">
        </li>
        <li>
            <label for="merek">Merek: </label>
            <select name="merek" id="merek">
                <?php foreach ($mobil as $m) : ?>
                    <?php if ($m['nama'] == $data['nama']) : ?>
                        <option value="<?= $m['merek_id']; ?>" selected><?= $m['nama']; ?></option>
                    <?php else : ?>
                        <option value="<?= $m['merek_id']; ?>"><?= $m['nama']; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </li>
        <li>
            <label for="unit">Unit: </label>
            <input type="number" name="unit" id="unit" value="<?= $data['unit']; ?>">
        </li>
        <li>
            <button type="submit">Ubah</button>
        </li>
        <li>
            <a href="/mobil">Kembali</a>
        </li>
    </ul>
</form>
<?= $this->endSection(); ?>