
<div class="row">
    <div class="col-6">
        <h1>WELCOME</h1>
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-5" id="pie-chart" style="height: 400px; width: 100%; display: none"></div>
            </div>

            <div class="mb-5 mt-5">
                <div id="GoogleLineChart" style="height: 400px; width: 100%"></div>
            </div>
            <div class="mb-5">
                <div id="GoogleBarChart" style="height: 400px; width: 100%"></div>
            </div>
        </div>
    </div>
    <div class="col-6">
        
    </div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    const init = () => {
        pieChart.chart = new google.visualization.PieChart(
            document.querySelector(pieChart.element)
        );
        pieChart.chart.draw(
            google.visualization.arrayToDataTable(pieChart.data),
            pieChart.options
        );

        google.charts.setOnLoadCallback(drawLineChart);
        google.charts.setOnLoadCallback(drawBarChart);

    };

    google.charts.load('current', {
        packages: ['corechart'],
        callback: init
    });


    //Pie Chart
    const pieChart = {
        chart: null,
        data: [
            ['Kategori', 'Jumlah Pembelian'],
            ['Snack Bouquet', <?= $pie_snack; ?>],
            ['Rajutan', <?= $pie_rajutan; ?>]
        ],
        element: '#pie-chart',
        options: {
            title: 'Total Transaksi per Kategori',

        }
    };

    // google.charts.setOnLoadCallback(drawLineChart);
    // Line Chart
    function drawLineChart() {
        var data = google.visualization.arrayToDataTable([
            ['Year', 'Total Transaksi '],
            <?php
            foreach ($years as $row) {
                echo "['" . $row['year'] . "'," . $row['id_transaksi'] . "],";
            } ?>
        ]);
        var options = {
            title: 'Total Transaksi Per Tahun',
            curveType: 'function',
            legend: {
                position: 'top'
            }
        };
        var chart = new google.visualization.LineChart(document.getElementById('GoogleLineChart'));
        chart.draw(data, options);
    }


    // Bar Chart
    // google.charts.setOnLoadCallback(showBarChart);

    function drawBarChart() {
        var data = google.visualization.arrayToDataTable([
            ['Month', 'Total Transaksi  '],
            <?php
            foreach ($months as $row) {
                echo "['" . $row['month'] . "'," . $row['id_transaksi'] . "],";
            }
            ?>
        ]);
        var options = {
            title: ' Total transaksi per bulan di tahun <?= date('Y'); ?>',
            is3D: true,
        };
        var chart = new google.visualization.BarChart(document.getElementById('GoogleBarChart'));
        chart.draw(data, options);
    }
</script>


                        
