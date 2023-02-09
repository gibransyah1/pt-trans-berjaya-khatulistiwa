<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<?php if (session()->getFlashdata('flash')) : ?>
    <script>
        alert('<?= session()->getFlashdata('flash'); ?>');
    </script>
<?php endif; ?>
<h1 class="judul-halaman">Dashboard</h1>
<div style="width: 800px;margin: 0px auto;">
    <canvas id="myChart"></canvas>
</div>

<script>
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["januari", "februari", "maret", "april"],
            datasets: [{
                label: '',
                data: [
                    <?php
                    echo $januari;
                    ?>,
                    <?php
                    echo $februari;
                    ?>,
                    <?php
                    echo $maret;
                    ?>,
                    <?php
                    echo $april;
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
</script>
<?= $this->endSection(); ?>