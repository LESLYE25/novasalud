<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<title>Invoice Print</title>

	<style>
		.invoice-box {
			max-width: 800px;
			margin: auto;
			padding: 30px;
			border: 1px solid #eee;
			box-shadow: 0 0 10px rgba(244, 203, 228, 0.85);
			font-size: 16px;
			line-height: 24px;
			font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			color: #555;
		}

		.invoice-box table {
			width: 100%;
			line-height: inherit;
			text-align: left;
			border-collapse: collapse;
		}

		.invoice-box table td {
			padding: 5px;
			vertical-align: top;
		}

		.invoice-box table tr td:nth-child(2) {
			text-align: right;
		}

		.invoice-box table tr.top table td {
			padding-bottom: 20px;
		}

		.invoice-box table tr.top table td.title {
			font-size: 45px;
			line-height: 45px;
			color: #333;
		}

		.invoice-box table tr.information table td {
			padding-bottom: 40px;
		}

		.invoice-box table tr.heading td {
			background: #eee;
			border-bottom: 1px solid #ddd;
			font-weight: bold;
		}

		.invoice-box table tr.details td {
			padding-bottom: 20px;
		}

		.invoice-box table tr.item td {
			/*border-bottom: 1px solid #eee;*/
		}

		.invoice-box table tr.item.last td {
			border-bottom: none;
		}

		.invoice-box table tr.total td:nth-child(2) {
			/*border-top: 2px solid #eee;*/
			font-weight: bold;
		}

		@media only screen and (max-width: 600px) {
			.invoice-box table tr.top table td {
				width: 100%;
				display: block;
				text-align: center;
			}

			.invoice-box table tr.information table td {
				width: 100%;
				display: block;
				text-align: center;
			}
		}

		/** RTL **/
		.invoice-box.rtl {
			direction: rtl;
			font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
		}

		.invoice-box.rtl table {
			text-align: right;
		}

		.invoice-box.rtl table tr td:nth-child(2) {
			text-align: left;
		}
	</style>
</head>
<?php

require_once('constant/connect.php');
$sql = "SELECT * FROM orders WHERE delete_status = 0 and id='" . $_GET['id'] . "' ";
$result = $connect->query($sql);
foreach ($result as $row) {

?>

	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="6">
						<table>
							<tr>
								<td class="title">
									<img src="./assets/uploadImage/Logo/logo.jpg" style="width: 100%; max-width: 300px" />
								</td>

								<td>
									<h1 style="margin:0 0 11px;">Factura</h1> #:<?php echo $row['uno'] ?><br />
									Fecha:<?php echo $row['orderDate'] ?><br />
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="2">
						<table>
							<tr>
								<td>
									<strong>Cliente:</strong> <?php echo $row['clientName'] ?><br />
									<strong>Contacto:</strong> <?php echo $row['clientContact'] ?><br />
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td>Medicamento</td>
					<td>Lote</td>
					<td>Exp.</td>
					<td>Qty</td>
					<td>MRP</td>
					<td>CxP</td>
					<td>Total</td>
				</tr>

				<?php
				$sql2 = "SELECT productName,total,rate,quantity FROM order_item WHERE lastid='" . $_GET['id'] . "' ";
				$result2 = $connect->query($sql2);
				foreach ($result2 as $row2) {
				?>
					<tr class="item">
						<td>
							<?php
							$stmt1 = "SELECT * FROM product WHERE product_id='" . $row2['productName'] . "'";
							$result2 = $connect->query($stmt1);
							foreach ($result2 as $key1) {
							?>
								<?php echo $key1['product_name']; ?>
							<?php } ?>
						</td>
						<td><?php echo $key1['bno'] ?></td>
						<td><?php echo $key1['expdate'] ?></td>
						<td><?php echo $row2['quantity'] ?></td>
						<td><?php echo $key1['mrp'] ?></td>
						<td><?php echo $row2['rate'] ?></td>
						<td><?php echo $row2['total']; ?></td>
					</tr>
				<?php } ?>

				<tr>
					<td rowspan="3" colspan="3" style="border: 1px solid #555">A/C NO:0064867230047 <br>SWIFT:DTDA1320
						<br>Nova Salud
					</td>
					<td colspan="3" style="border: 1px solid;text-align: left;">Descuentos</td>
					<td style="border: 1px solid"><?php echo $row['discount'] ?></td>
				</tr>
				<tr>
					<td colspan="3" style="border: 1px solid">Impuestos</td>
					<td style="border: 1px solid;text-align: left;"><?php echo $row['gstn'] ?></td>
				</tr>
				<tr>
					<td colspan="3" style="border: 1px solid">Total</td>
					<td style="border: 1px solid;text-align: left;"><?php echo $row['grandTotalValue'] ?></td>
				</tr>

				

			</table>

		</div>
	</body>
<?php } ?>

</html>
