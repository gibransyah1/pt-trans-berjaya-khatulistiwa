<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1 class="judul-halaman">Sewa Mobil</h1>
<form action="/transaksi/store" method="post">
    <input type="hidden" name="id" value="<?= $data['mobil_id']; ?>">
    <ul class="merubah-ul">
        <li>
            <label for="mobil">Nama Mobil: </label>
            <input type="text" name="mobil" id="mobil" value="<?= $data['nama_mobil']; ?>" readonly="readonly">
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
            <label for="penyewa">Nama Penyewa: </label>
            <input type="text" name="penyewa" id="penyewa">
        </li>
        <li>
            <label for="kembali">Tanggal Kembali: </label>
            <input type="date" name="kembali" id="kembali">
        </li>
        <li>
            <label for="pembayaran">Pilih Pembayaran: </label>
            <select name="pembayaran" id="pembayaran">
                <option value="1">Lunas</option>
                <option value="0">Dp</option>
            </select>
        </li>
        <li>
            <label for="nominal">Nominal: </label>
            <input type="number" name="nominal" id="nominal" placeholder="Abaikan Jika Pembayaran Lunas" value="0">
        </li>

        <button type="submit" class="btn-keluar">Bayar</button>

        <a href="/mobil"><button type="button" class="btn-keluar kanan-test">Kembali</button></a>
        <input type="submit" name="cetak" value="cetak" class="btn-keluar">
    </ul>
</form>
<?= $this->endSection(); ?>