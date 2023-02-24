<!DOCTYPE html>
<html>

<head>
    <title>Gudang Gibran</title>
</head>

<body>
    <style type="text/css">
        body {
            font-family: sans-serif;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #3c3c3c;
            padding: 3px 8px;

        }

        a {
            background: blue;
            color: #fff;
            padding: 8px 10px;
            text-decoration: none;
            border-radius: 2px;
        }
    </style>

    <?php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Transaksi Rental.xls");
    ?>

    <center>
        <h1>List Transaksi Rental <br /> www.rentalmobilgibran.com</h1>
    </center>

    <table width="100%">
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
            </tr>
        </thead>
        <?php $i = 1; ?>
        <?php foreach ($datanya as $d) : ?>
            <tbody>
                <tr>
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
                </tr>
            </tbody>
        <?php endforeach; ?>
    </table>
</body>

</html>