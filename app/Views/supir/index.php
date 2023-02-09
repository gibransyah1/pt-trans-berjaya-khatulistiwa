<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1 class="judul-halaman">List Supir</h1>

<a href="/supir/create"><button class="btn-keluar" type="button">Tambah Supir</button></a>

<div class="wadah-tabel">
    <table class="desain">
        <thead>
            <tr>
                <td>No</td>
                <td>Nama Supir</td>
                <td>alamat</td>
                <td>No Telp</td>
                <td>Aksi</td>
            </tr>
        </thead>
        <?php $no = 1; ?>
        <?php foreach ($data as $d) : ?>
            <?php $warna = ($no % 2 == 1) ? "putih" : "abu"; ?>
            <tbody>
                <tr class="<?= $warna; ?>">
                    <td><?= $no++; ?></td>
                    <td><?= $d['nama_supir']; ?></td>
                    <td><?= $d['alamat']; ?></td>
                    <td><?= $d['no_telp']; ?></td>
                    <td>
                        <a href="/supir/detail/<?= $d['supir_id']; ?>">detail</a> | <a href="/supir/edit/<?= $d['supir_id']; ?>">ubah</a> | <a href="/supir/delete/<?= $d['supir_id']; ?>" onclick="return confirm('yakin?');">hapus</a>
                    </td>
                </tr>
            </tbody>
        <?php endforeach; ?>
    </table>
</div>
<?= $this->endSection(); ?>