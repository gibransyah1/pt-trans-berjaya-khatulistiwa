<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h1 class="judul-halaman">List Laporan Bulanan</h1>
<form method="post" action="/transaksi/bulanan">
    <!-- <select name="bulan" id="bulan">
        <option value="1">januari</option>
        <option value="2">februari</option>
        <option value="3">maret</option>
        <option value="4">april</option>
        <option value="5">mei</option>
        <option value="6">juni</option>
        <option value="7">juli</option>
        <option value="8">agustus</option>
        <option value="9">september</option>
        <option value="10">oktober</option>
        <option value="11">november</option>
        <option value="12">desember</option>
    </select>
    <select name="tahun" id="tahun">
     
    </select> -->
    <label for="bulan">Dari :</label>
    <input type="date" name="bulan" id="bulan">
    <label for="bulan1">Sampai :</label>
    <input type="date" name="bulan1" id="bulan1">
    <label for="idbayar">Pembayaran :</label>
    <select name="idbayar" id="idbayar">
        <option value="1">Lunas</option>
        <option value="0">Dp</option>
        <option value="3">Batal</option>
    </select>
    <input type="submit" name="submit" value="Cari" class="btn-keluar">
</form>
<br>
<a href="/transaksi/excel"><button type="button" class="btn-keluar">Export Excel</button></a>
<br>
<?php if (!$data) : ?>
    <h3>Data Kosong</h3>
<?php else : ?>
    <div class="wadah-tabel">
        <table class="desain">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Mobil</td>
                    <td>Supir</td>
                    <td>Tanggal Keluar</td>
                    <td>Tanggal Masuk</td>
                    <td>Pembayaran</td>
                    <td>Total Bayar</td>
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
                        <td><?= $d['tgl_masuk']; ?></td>
                        <td><?php if ($d['islunas'] == 0) : ?>
                                <?= 'Dp'; ?>
                            <?php elseif ($d['islunas'] == 1) : ?>
                                <?= 'Lunas'; ?>
                            <?php else : ?>
                                <?= 'Batal'; ?>
                            <?php endif; ?>
                        </td>
                        <td><?= 'Rp. ' . number_format($d['total'], 2, ',', '.'); ?></td>
                    </tr>
                </tbody>
            <?php endforeach; ?>
        </table>
    </div>
    <br>
    <p>Total Pendapatan Bulanan: Rp. <?= number_format($total['total_biaya'], 2, ',', '.'); ?></p>
    <br>
    <div style="width: 800px;margin: 0px auto;">
        <canvas id="myChart"></canvas>
    </div>
    <script>
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
                datasets: [{
                    label: '',
                    data: [
                        <?php
                        echo $januari
                        ?>,
                        <?php
                        echo $februari;
                        ?>,
                        <?php
                        echo $maret;
                        ?>,
                        <?php
                        echo $april;
                        ?>,
                        <?php
                        echo $mei;
                        ?>,
                        <?php
                        echo $juni;
                        ?>,
                        <?php
                        echo $juli;
                        ?>,
                        <?php
                        echo $agustus;
                        ?>,
                        <?php
                        echo $september;
                        ?>,
                        <?php
                        echo $oktober;
                        ?>,
                        <?php
                        echo $november;
                        ?>,
                        <?php
                        echo $desember;
                        ?>,
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Data Transaksi Bulanan Tahun 2023'
                    }
                }
            }
        });
    </script>
<?php endif; ?>

<?= $this->endSection(); ?>