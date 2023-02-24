<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1 class="judul-halaman">List Mobil</h1>

<a href="/mobil/create"><button class="btn-keluar" type="button">Tambah Mobil</button></a>

<div class="wadah-tabel">
    <table class="desain">
        <thead>
            <tr>
                <td>No</td>
                <td>Gambar</td>
                <td>Nama Mobil</td>
                <td>Jenis</td>
                <td>Kapasitas Mesin</td>
                <td>Harga Sewa Per Hari</td>
                <td>Merek</td>
                <td>Status</td>
                <td>Aksi</td>
            </tr>
        </thead>
        <?php $i = 1 + (2 * ($currentPage - 1)); ?>
        <?php foreach ($data as $d) : ?>
            <?php $warna = ($i % 2 == 1) ? "putih" : "abu"; ?>
            <tbody>
                <tr class="<?= $warna; ?>">
                    <td><?= $i++; ?></td>
                    <td>
                        <img src="/assets/gambar/<?= $d['gambar']; ?>" alt="<?= $d['gambar']; ?>" width="50">
                    </td>
                    <td><?= $d['nama_mobil']; ?></td>
                    <td><?= $d['jenis']; ?></td>
                    <td><?= $d['kapasitas_mesin']; ?> CC</td>
                    <td>Rp. <?= number_format($d['harga_sewa'], 2, ',', '.'); ?></td>
                    <td><?= $d['nama']; ?></td>
                    <td><?= $d['status']; ?></td>
                    <td>
                        <?php if ($d['status'] == 'tersedia') : ?>
                            <a href="/transaksi/edit/<?= $d['mobil_id']; ?>">Sewa</a>
                        <?php else : ?>
                            <p>-</p>
                        <?php endif; ?>
                        <!-- <a href="/mobil/detail/<?= $d['mobil_id']; ?>">detail</a> | <a href="/mobil/edit/<?= $d['mobil_id']; ?>">Sewa</a> | <a href="/mobil/delete/<?= $d['mobil_id']; ?>" onclick="return confirm('yakin?');">hapus</a> -->
                    </td>
                </tr>
            </tbody>
        <?php endforeach; ?>
    </table>
</div>
<?= $pager->links('mobil', 'semua_pagination'); ?>
<?= $this->endSection(); ?>