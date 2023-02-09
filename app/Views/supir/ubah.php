<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1>Form Ubah Supir</h1>
<form action="/supir/edited" method="post">
    <input type="hidden" name="id" value="<?= $data['supir_id']; ?>">
    <ul>
        <li>
            <label for="supir">Nama Supir: </label>
            <input type="text" name="supir" id="supir" value="<?= $data['nama_supir']; ?>">
        </li>
        <li>
            <label for="alamat">Alamat: </label>
            <br>
            <textarea name="alamat" id="alamat" cols="30" rows="10"><?= $data['alamat']; ?></textarea>
        </li>
        <li>
            <label for="telp">No Telp: </label>
            <input type="number" name="telp" id="telp" value="<?= $data['no_telp']; ?>">
        </li>
        <li>
            <button type="submit">Ubah</button>
        </li>
        <li>
            <a href="/supir">Kembali</a>
        </li>
    </ul>
</form>
<?= $this->endSection(); ?>