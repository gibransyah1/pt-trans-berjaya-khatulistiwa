<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1 class="judul-halaman">List Merek</h1>

<a href="/merek/create"><button class="btn-keluar" type="button">Tambah Merek</button></a>

<div class="wadah-tabel">
    <table class="desain">
        <thead>
            <tr>
                <td>No</td>
                <td>Merek</td>
                <td>Negara</td>
                <td>Aksi</td>
            </tr>
        </thead>
        <?php $no = 1; ?>
        <?php foreach ($data as $d) : ?>
            <?php $warna = ($no % 2 == 1) ? "putih" : "abu"; ?>
            <tbody>
                <tr class="<?= $warna; ?>">
                    <td><?= $no++; ?></td>
                    <td><?= $d['nama']; ?></td>
                    <td><?= $d['negara']; ?></td>
                    <td>
                        <a href="/merek/detail/<?= $d['merek_id']; ?>">detail</a> | <a href="/merek/edit/<?= $d['merek_id']; ?>">ubah</a> | <a href="/merek/delete/<?= $d['merek_id']; ?>" onclick="return confirm('yakin?');">hapus</a>
                    </td>
                </tr>
            </tbody>
        <?php endforeach; ?>
    </table>
</div>
<?= $this->endSection(); ?>