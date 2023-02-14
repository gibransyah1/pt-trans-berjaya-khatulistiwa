<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1 class="judul-halaman">List Mobil Sudah dikembalikan</h1>

<!-- <a href="/transaksi/create">Tambah Mobil Masuk</a> -->

<div class="wadah-tabel">
    <table class="desain">
        <thead>
            <tr>
                <td>No</td>
                <td>Mobil</td>
                <td>Supir</td>
                <td>Tanggal Keluar</td>
                <td>Tanggal Masuk</td>
                <td>Jam Keluar</td>
                <td>Jam Masuk</td>
                <td>Unit Masuk</td>
                <td>Total Bayar</td>
            </tr>
        </thead>
        <?php $i = 1 + (2 * ($currentPage - 1)); ?>
        <?php foreach ($data as $d) : ?>
            <?php $warna = ($i % 2 == 1) ? "putih" : "abu"; ?>
            <tbody>
                <tr class="<?= $warna; ?>">
                    <td><?= $i++; ?></td>
                    <td><?= $d['nama_mobil']; ?></td>
                    <td><?= $d['nama_supir']; ?></td>
                    <td><?= $d['tgl_keluar']; ?></td>
                    <td><?= $d['tgl_masuk']; ?></td>
                    <td><?= $d['jam_keluar']; ?></td>
                    <td><?= $d['jam_masuk']; ?></td>
                    <td><?= $d['unit_total']; ?></td>
                    <td>Rp. <?= number_format($d['total'], 2, ',', '.'); ?></td>
                </tr>
            </tbody>
        <?php endforeach; ?>
    </table>
</div>
<?= $pager->links('kembali', 'semua_pagination'); ?>
<?= $this->endSection(); ?>