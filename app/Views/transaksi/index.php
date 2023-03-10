<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1 class="judul-halaman">List Transaksi</h1>

<!-- <a href="/transaksi/create"><button class="btn-keluar" type="button">Tambah Mobil Keluar</button></a> -->

<div class="wadah-tabel">
    <table class="desain">
        <thead>
            <tr>
                <td>No</td>
                <td>Mobil</td>
                <td>Supir</td>
                <td>Penyewa</td>
                <td>Tanggal Pinjam</td>
                <td>Tanggal Kembali</td>
                <td>Pembayaran</td>
                <td>Uang Muka</td>
                <td>Sisa Bayar</td>
                <td>Total</td>
                <td>Status</td>
                <td>Aksi</td>
            </tr>
        </thead>

        <?php $i = 1 + (2 * ($currentPage - 1)); ?>
        <?php foreach ($data as $d) : ?>
            <?php $sisa = $d['total'] - $d['nominal']; ?>
            <?php $warna = ($i % 2 == 1) ? "putih" : "abu"; ?>
            <tbody>
                <tr class="<?= $warna; ?>">
                    <td><?= $i++; ?></td>
                    <td><?= $d['nama_mobil']; ?></td>
                    <td><?= $d['nama_supir']; ?></td>
                    <td><?= $d['penyewa']; ?></td>
                    <td><?= $d['tgl_keluar']; ?></td>
                    <td><?= $d['tgl_masuk']; ?></td>
                    <td><?php if ($d['islunas'] == 0) : ?>
                            <?= 'Dp'; ?>
                        <?php elseif ($d['islunas'] == 1) : ?>
                            <?= 'Lunas'; ?>
                        <?php else : ?>
                            <?= 'Batal'; ?>
                        <?php endif; ?>
                    </td>
                    <td><?= 'Rp. ' . number_format($d['nominal'], 2, ',', '.'); ?></td>
                    <?php if ($d['islunas'] != 0) : ?>
                        <td><?= 'Rp. ' . number_format(0, 2, ',', '.'); ?></td>
                    <?php else : ?>
                        <td><?= 'Rp. ' . number_format($sisa, 2, ',', '.'); ?></td>
                    <?php endif; ?>
                    <td><?= 'Rp. ' . number_format($d['total'], 2, ',', '.'); ?></td>
                    <td><?= $d['status_pinjam']; ?></td>
                    <td>
                        <a href="/transaksi/detail/<?= $d['transaksi_id']; ?>">detail</a>
                        <!-- <a href="/transaksi/detail/<?= $d['transaksi_id']; ?>">detail</a> | <a href="/transaksi/edit/<?= $d['transaksi_id']; ?>">selesai</a> | <a href="/transaksi/delete/<?= $d['transaksi_id']; ?>" onclick="return confirm('yakin?');">hapus</a> -->
                    </td>
                </tr>
            </tbody>
        <?php endforeach; ?>
    </table>
</div>
<?= $pager->links('pinjam', 'semua_pagination'); ?>
<?= $this->endSection(); ?>