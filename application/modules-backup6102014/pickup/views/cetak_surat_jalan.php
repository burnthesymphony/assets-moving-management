<?php $ass=$this->load->module('master/asset');?>
<html>
	<head>
		 <!-- bootstrap 3.0.2 -->
            <link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
            <!-- font Awesome -->
            <link href="<?php echo base_url('assets/css/font-awesome.min.css')?>" rel="stylesheet" type="text/css" />
            <!-- Ionicons -->
            <link href="<?php echo base_url('assets/css/ionicons.min.css')?>" rel="stylesheet" type="text/css" />
           
           
            <!-- Theme style -->
            
            <title>Cetak Surat Jalan</title>
            <script src="<?php echo base_url('assets/js/jquery.js')?>"></script>
	</head>
	<body>
			<table class="table table-condensed">
	<tr class="header">
		<td colspan="2" align="left">PT. ISUZU ASTRA MOTOR INDONESIA</td>
		<td colspan="2" align="right"><div  style="display:block !important" align="right"><?php $ass::generate_barcode($result['permit_number']) ?></div></td>
	</tr>
	<tr><td colspan="4">DELIVERY NOTE</td></tr>	
	<tr>
		<td>DL No. <input type="hidden" name="id_pickup" id="id_pickup" value="<?php  echo $result['id_pickup'] ?>"></td>
		<td>: <?php echo $result['permit_number']?></td>
		<td>Phone No</td>
		<td>: <?php echo $result['no_hp']?></td>
		
	</tr>
	<tr>
		
		<td>Date</td>
		<td>: <?php echo  date('d-m-Y', strtotime($result['date_create']) )?></td>
		<td>Driver Name</td>
		<td>: <?php echo $result['driver_name']?></td>
	</tr>
	<tr>
		<td>Source</td>
		<td>: <?php echo $result['gate_from']?></td>
		<td></td>
		<td></td>
		
	</tr>
	<tr>
		<td>Destination</td>
		<td>:<?php echo $result['gate_destination']?></td>
		<td></td>
		<td></td>
		
	</tr>
</table>

<table class="table table-striped  table-condesed table-bordered">
<thead>
	<tr>
		<th style="width:12px">Item No</th>
		<th>Barcode</th>
		<th>Item Name</th>
		<th>Description</th>
	</tr>
</thead>
<tbody>
<?php 
$i=1;
foreach ($result_detail as $result_item) {?>
<tr id="row_<?php echo $result_item['barcode'] ?>" >
	<td><?php echo $i?></td>
	<td><?php echo $result_item['barcode']?></td>
	<td><?php echo $result_item['item_name']?></td>
	<td><?php echo $result_item['description']?></td>
	
</tr>
<?php $i++;
} ?>
</tbody>
</table>
<table class="" width="100%" cellpadding="3" cellspacing="2">
		<tr>
			<td colspan="4">Delivered By,</td>
			<td></td>
			<td colspan="4">Received By,</td>
			
		</tr>
		<tr>
			<td ><div style="margin:3px; border-bottom:1px dotted #000;height:50px">&nbsp;</div></td>
			<td ><div style="margin:3px; border-bottom:1px dotted #000;height:50px">&nbsp;</div></td>
			<td ><div style="margin:3px; border-bottom:1px dotted #000;height:50px">&nbsp;</div></td>
			<td ><div style="margin:3px; border-bottom:1px dotted #000;height:50px">&nbsp;</div></td>
			<td>&nbsp;</td>
			<td ><div style="margin:3px; border-bottom:1px dotted #000;height:50px">&nbsp;</div></td>
			<td ><div style="margin:3px; border-bottom:1px dotted #000;height:50px">&nbsp;</div></td>
			<td ><div style="margin:3px; border-bottom:1px dotted #000;height:50px">&nbsp;</div></td>
			<td ><div style="margin:3px; border-bottom:1px dotted #000;height:50px">&nbsp;</div></td>
		</tr>
		<tr>
			<td>PT. PTA</td>
			<td>IAMI</td>
			<td>SECURITY</td>
			<td>DRIVER</td>
			<td>&nbsp;</td>
			<td>PT. PTA</td>
			<td>IAMI</td>
			<td>SECURITY</td>
			<td>DRIVER</td>
		</tr>

	</table>	
	</body>
</html>
<form id="frm-ver">

</form>
<script>
		$(function(){
			window.print();
		})

</script>