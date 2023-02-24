<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1 class="judul-halaman">Detail Transaksi</h1>
<ul class="merubah-ul">
    <li>
        Nama Mobil : <?= $data['nama_mobil']; ?>
    </li>
    <li>
        Supir : <?= $data['nama_supir']; ?>
    </li>
    <li>
        Tanggal Pinjam : <?= $data['tgl_keluar']; ?>
    </li>
    <li>
        Taggal Kembali : <?= $data['tgl_masuk']; ?>
    </li>
    <li>
        Harga Sewa Per Hari : <?= 'Rp. ' . number_format($data['harga_sewa'], 2, ',', '.'); ?>
    </li>
    <br>

    <?php if ($data['islunas'] == 0) : ?>

        <a href="/transaksi/lunas/<?= $id; ?>"><button type="button" class="btn-keluar">Lunas</button></a>
        <a href="/transaksi/cetaklunas/<?= $id; ?>"><button type="button" class="btn-keluar">Cetak</button></a>

        <a href="/transaksi/batal/<?= $id; ?>"><button type="button" class="btn-keluar kanan-test">Batal</button></a>

    <?php elseif ($data['status_pinjam'] == 'dipinjam' && $data['islunas'] != 3) : ?>
        <li>
            <a href="/transaksi/edited/<?= $id; ?>"><button type="button" class="btn-keluar">Kembalikan Mobil</button></a>
        </li>
    <?php elseif ($data['status_pinjam'] == 'dibooking') : ?>
        <a href="/transaksi/ambil/<?= $id; ?>"><button type="button" class="btn-keluar">Ambil</button></a>
    <?php endif; ?>
    <li>
        <br>
        <a href="/transaksi"><button type="button" class="btn-keluar">Kembali</button></a>
    </li>
</ul>
<?= $this->endSection(); ?>