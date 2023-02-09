<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1>Form Tambah Transaksi</h1>
<form action="/transaksi/edited" method="post">
    <input type="hidden" name="id" value="<?= $data['transaksi_id']; ?>">
    <ul>
        <li>
            <label for="mobil">Nama Mobil: </label>
            <select name="mobil" id="mobil">
                <?php foreach ($mobil as $m) : ?>
                    <?php if ($m['nama_mobil'] == $data['nama_mobil']) : ?>
                        <option value="<?= $m['mobil_id']; ?>" selected><?= $m['nama_mobil']; ?></option>
                    <?php else : ?>
                        <option value="<?= $m['mobil_id']; ?>"><?= $m['nama_mobil']; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </li>
        <li>
            <label for="supir">Nama Supir: </label>
            <select name="supir" id="supir">
                <?php foreach ($supir as $s) : ?>
                    <?php if ($s['nama_supir'] == $data['nama_supir']) : ?>
                        <option value="<?= $s['supir_id']; ?>" selected><?= $s['nama_supir']; ?></option>
                    <?php else : ?>
                        <option value="<?= $s['supir_id']; ?>"><?= $s['nama_supir']; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </li>
        <li>
            <label for="unit">Berapa Unit: </label>
            <input type="number" name="unit" id="unit" value="<?= $data['unit_total']; ?>">
        </li>
        <li>
            <button type="submit">Ubah</button>
        </li>
        <li>
            <a href="/transaksi/keluar">Kembali</a>
        </li>
    </ul>
</form>
<?= $this->endSection(); ?>