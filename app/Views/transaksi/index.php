<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1 class="judul-halaman">List Mobil Sedang dipinjam</h1>

<a href="/transaksi/create"><button class="btn-keluar" type="button">Tambah Mobil Keluar</button></a>

<div class="wadah-tabel">
    <table class="desain">
        <thead>
            <tr>
                <td>No</td>
                <td>Mobil</td>
                <td>Supir</td>
                <td>Tanggal Keluar</td>
                <td>Jam Keluar</td>
                <td>Unit Keluar</td>
                <td>Aksi</td>
            </tr>
        </thead>
        <?php $no = 1; ?>
        <?php foreach ($data as $d) : ?>
            <?php $warna = ($no % 2 == 1) ? "putih" : "abu"; ?>
            <tbody>
                <tr class="<?= $warna; ?>">
                    <td><?= $no++; ?></td>
                    <td><?= $d['nama_mobil']; ?></td>
                    <td><?= $d['nama_supir']; ?></td>
                    <td><?= $d['tgl_keluar']; ?></td>
                    <td><?= $d['jam_keluar']; ?></td>
                    <td><?= $d['unit_total']; ?></td>
                    <td>
                        <a href="/transaksi/detail/<?= $d['transaksi_id']; ?>">detail</a> | <a href="/transaksi/edit/<?= $d['transaksi_id']; ?>">selesai</a> | <a href="/transaksi/delete/<?= $d['transaksi_id']; ?>" onclick="return confirm('yakin?');">hapus</a>
                    </td>
                </tr>
            </tbody>
        <?php endforeach; ?>
    </table>
</div>
<?= $this->endSection(); ?>