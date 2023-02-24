<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- <h1 class="judul-halaman">Dashboard</h1>
<div style="width: 800px;margin: 0px auto;">
    <canvas id="myChart"></canvas>
</div> -->

<h1 class="judul-halaman">Dashboard</h1>
<div class="container-dashboard">
    <a href="/" class="kotak-masuk">
        <div class="kotak biru">
            <i class="fa fa-newspaper-o" style="color: white; font-size:60pt;"></i>
            <p style="color: white; font-size:15pt;">Dashboard</p>
        </div>
    </a>
    <a href="/merek" class="kotak-keluar">
        <div class="kotak biru">
            <i class="fa fa-tags" style="color: white; font-size:60pt"></i>
            <p style="color: white; font-size:15pt;">Merek</p>
        </div>
    </a>
    <a href="/mobil" class="kotak-harian">
        <div class="kotak biru">
            <i class="fa fa-globe" style="color: white; font-size:60pt"></i>
            <p style="color: white; font-size:15pt;">Mobil</p>
        </div>
    </a>
    <a href="/transaksi" class="kotak-bulanan">
        <div class="kotak biru">
            <i class="fa fa-comments" style="color: white; font-size:60pt"></i>
            <p style="color: white; font-size:15pt;">Transaksi</p>
        </div>
    </a>
    <a href="/transaksi/bulanan">
        <div class="kotak-kanan biru kotak-dashboard">
            <i class="fa fa-user" style="color: white; font-size:60pt"></i>
            <p style="color: white; font-size:15pt;">Laporan Transaksi Rental</p>
        </div>
    </a>
    <div class="clear"></div>
</div>

<!-- <script>
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["januari", "februari", "maret", "april"],
            datasets: [{
                label: '',
                data: [
                    <?php
                    //echo $januari;
                    ?>,
                    <?php
                    //echo $februari;
                    ?>,
                    <?php
                    //echo $maret;
                    ?>,
                    <?php
                    //echo $april;
                    ?>
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
            }
        }
    });
</script> -->
<?= $this->endSection(); ?>