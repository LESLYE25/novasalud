    <?php //error_reporting(1); 
    ?>
    <?php include('./constant/layout/head.php'); ?>
    <?php include('./constant/layout/header.php'); ?>

    <?php include('./constant/layout/sidebar.php'); ?>

    <?php


    $lowStockSql = "SELECT * FROM product WHERE status = 1";
    $lowStockQuery = $connect->query($lowStockSql);
    $countLowStock = $lowStockQuery->num_rows;

    $lowStockSql1 = "SELECT * FROM brands WHERE brand_status = 1";
    $lowStockQuery1 = $connect->query($lowStockSql1);
    $countLowStock1 = $lowStockQuery1->num_rows;

    $date = date('Y-m-d');
    $lowStockSql3 = "SELECT * FROM product WHERE  expdate<'" . $date . "' AND status = 1";
    //echo "SELECT * FROM product WHERE  expdate<='".$date."' AND status = 1" ;exit;
    $lowStockQuery3 = $connect->query($lowStockSql3);
    $countLowStock3 = $lowStockQuery3->num_rows;

    $lowStockSql2 = "SELECT * FROM orders WHERE delete_status =0";
    $lowStockQuery2 = $connect->query($lowStockSql2);
    $countLowStock2 = $lowStockQuery2->num_rows;

    //$connect->close();

    ?>

    <style type="text/css">
        .ui-datepicker-calendar {
            display: none;
        }
    </style>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <div class="page-wrapper">

        <!--<div class="row page-titles">
                <div class="col-md-12 align-self-center">
                    <div class="float-right"><h3 style="color:black;"><p style="color:black;"><?php echo date('l') . ' ' . date('d') . '- ' . date('m') . '- ' . date('Y'); ?></p></h3></div>
                </div>
            </div> -->

            <div class="row">
                <div class="col-md-3 dashboard">
                    <div class="card" style="background:rgb(113, 109, 220)">
                        <div class="media widget-ten">
                            <div class="media-left meida media-middle">
                                <span><i class="ti-support"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2 class="color-white"><?php echo $countLowStock; ?></h2>
                                <a href="product.php">
                                    <p class="m-b-0">Medicinas</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] == 1) { ?>
                <div class="col-md-3 dashboard">
                    <div class="card" style="background-color:rgb(255, 190, 85)">
                        <div class="media widget-ten">
                            <div class="media-left meida media-middle">
                                <span><i class="ti-agenda"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2 class="color-white"><?php echo $countLowStock3; ?></h2>
                                    <a href="Order.php">
                                     <p class="m-b-0">Medicinas Vencidas</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] == 1) { ?>
                    <div class="col-md-3 dashboard">
                        <div class="card" style="background-color:rgb(236, 169, 245)">
                            <div class="media widget-ten">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-notepad"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2 class="color-white"><?php echo $countLowStock2; ?></h2>
                                    <a href="Order.php">
                                        <p class="m-b-0">Facturas</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] == 1) { ?>
                    <div class="col-md-3 dashboard">
                        <div class="card" style="background:#65c8db">
                            <div class="media widget-ten">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-rss"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2 class="color-white"><?php echo $countLowStock1; ?></h2>
                                    <a href="brand.php">
                                        <p class="m-b-0">Usuarios</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Tabla de Ventas</strong>
                            <div class="table-responsive m-t-40">
                                <table id="myTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Fecha</th>
                                            <th>Nombre Cliente</th>
                                            <th>Contacto</th>
                                            <th>Estado del Pago</th>
                                            <th>Total de Compra</th> <!-- Nueva columna de Total -->
                                        </tr>
                                    </thead>
                                <tbody>
                                    <?php
                                    $sql = "
                                        SELECT 
                                            o.uno, 
                                            o.orderDate, 
                                            o.clientName, 
                                            o.clientContact, 
                                            o.paymentStatus, 
                                            o.id,
                                            SUM(oi.total) AS totalCompra
                                            FROM orders o
                                            LEFT JOIN order_item oi ON o.id = oi.lastid
                                            WHERE o.delete_status = 0
                                            GROUP BY o.id
                                        ";
                                    $result = $connect->query($sql);
                                    foreach ($result as $row) {
                                        $no += 1;
                                    ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?php echo $row['orderDate']; ?></td>
                                        <td><?php echo $row['clientName']; ?></td>
                                        <td><?php echo $row['clientContact']; ?></td>
                                        <td>
                                            <?php 
                                            if ($row['paymentStatus'] == 1) {
                                                echo "<label class='label label-info'><h4>Pago Completo</h4></label>";
                                            } else if ($row['paymentStatus'] == 2) {
                                                echo "<label class='label label-warning'><h4>Pago Parcial</h4></label>";
                                            } else {
                                                echo "<label class='label label-danger'><h4>Pago Pendiente</h4></label>";
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo "$" . number_format($row['totalCompra'], 2); ?> </td> <!-- Mostrar Total de Compra -->
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        // Obtener el total de ventas por estado de pago
        $totalVentasSql = "
            SELECT 
                paymentStatus, 
                SUM(oi.total) AS totalVentas
            FROM orders o
            LEFT JOIN order_item oi ON o.id = oi.lastid
            WHERE o.delete_status = 0
            GROUP BY paymentStatus
        ";

        $resultVentas = $connect->query($totalVentasSql);

        // Crear un array de datos para Google Charts
        $chartData = '';
        while ($row = $resultVentas->fetch_assoc()) {
            $status = $row['paymentStatus'];
            $totalVentas = $row['totalVentas'];
            
            // Añadir datos al array en el formato adecuado para Google Charts
            $statusLabel = ($status == 1) ? 'Pago Completo' : (($status == 2) ? 'Pago Parcial' : 'Pago Pendiente');
            $chartData .= "['$statusLabel', $totalVentas],";
        }

        $chartData = rtrim($chartData, ','); // Eliminar la última coma
        ?>

        <!-- Gráfico de torta -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Total de Ventas por Estado de Pago</strong>
                </div>
                <div class="card-body">
                    <div id="ventasChart" style="width: 100%; height: 400px;"></div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Estado de Pago', 'Total de Ventas'],
                    <?php echo $chartData; ?>
                ]);

                var options = {
                    title: 'Distribución de Ventas por Estado de Pago',
                    is3D: true,
                    slices: {
                        0: { offset: 0.1 },
                        1: { offset: 0.1 },
                        2: { offset: 0.1 }
                    },
                    legend: { position: 'top' }
                };

                var chart = new google.visualization.PieChart(document.getElementById('ventasChart'));
                chart.draw(data, options);
            }
        </script>

    </div>

    <?php include('./constant/layout/footer.php'); ?>

    <script>
        $(function() {
            $(".preloader").fadeOut();
        })
    </script>
    <script>
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Country', 'Mhl'], <?php echo $datavalue1; ?>
            ]);

            var options = {
                title: 'World Wide Wine Production',
                is3D: true
            };

            var chart = new google.visualization.PieChart(document.getElementById('myChart'));
            chart.draw(data, options);

            var chart = new google.visualization.BarChart(document.getElementById('myChart1'));
            chart.draw(data, options);
        }
    </script>
</div>


            <?php
            //error_reporting(0);
            //require_once('../constant/connect.php');
            $qqq = "SELECT * FROM product WHERE  status ='1' ";
            $result = $connect->query($qqq);
            //print_r($result);exit;
            foreach ($result as $row) {

                //print_r($row);
                $a .= $row["product_name"] . ',';
                $b .= $row["quantity"] . ',';
            }
            $am = explode(",", $a, -1);
            $amm = explode(",", $b, -1);
            //print_r($a);
            //print_r($b);

            $cnt = count($am);

            $datavalue1 = '';
            for ($i = 0; $i < $cnt; $i++) {
                $datavalue1 .= "['" . $am[$i] . "'," . $amm[$i] . "],";
            }
            //echo 

            $datavalue1; //used this $data variable in js
            ?>



        </div>
    </div>
    </div>
    </div>