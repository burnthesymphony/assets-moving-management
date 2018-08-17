<style>
	@page {
  size: A4;
  margin: 0px !important;
}
@media print {
  html, body {
    width: 210mm;
    height: 297mm;
     
     margin: 0px !important;
  }
  td{
  	font-size: 11pt ;
  }
  table{
  	 margin: 0px !important;
  }
  .break_ {page-break-before: always}
}

</style>
<?php $ass=$this->load->module('master/asset');
	$data_per_page=3;
?>
<html>
	<head>
		 <!-- bootstrap 3.0.2 -->
            <link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />      
            <title>Cetak Surat Jalan</title>
            <script src="<?php echo base_url('assets/js/jquery.js')?>"></script>
	</head>
	<body>
<table width="100%">
		<tr>
			<td align="right"><div  style="display:block !important" align="right"><?php   $ass::generate_barcode($result['permit_number']) ?></div></td>
		</tr>
</table>
<?php header_lap($result)?>
<?php 
$i=1;
$baris=1;
foreach ($result_detail as $result_item) {
	$category_name 	= $result_item['category_name'];
	$nama_item		= $result_item['item_name'];
	
	if($result_item['id_item_category']==1) { ## jika asset
		$barcode_pindahan 	= $result_item['barcode'];
		$id_asset 			= $result_item['barcode_old'];
		$barcode_box 		= '';
	}
	if($result_item['id_item_category']==2){ ## Stock
		$barcode_pindahan 	= '';
		$id_asset 			= '';//$result_item['barcode_old'];
		$barcode_box 		= $result_item['barcode'];
	}
	if($result_item['id_item_category']==3){ ## Others
		$barcode_pindahan 	= '';
		$id_asset 			= '';//$result_item['barcode_old'];
		$barcode_box 		= $result_item['barcode'];
	}
	if($result_item['id_item_category']==4){ ## BOX ASSETS
		$barcode_pindahan 	= $result_item['barcode'];
		$id_asset 			= '';//$result_item['barcode_old'];
		$isi_box			= $ass->isi_box($result_item['id_item']);
		$barcode_box 		= '';
		$id_asset.='<br><ul>';
		$category_name ='<br><ul>';
		$nama_item.='<ul>';
		$barcode_pindahan.='<ul>';
		$baris= $baris + count($isi_box);
		foreach($isi_box as $isi){
			echo '<input type ="hidden" name="isi_box_item['.$result_item['id_item'].'][]" value="'.$isi['id_item'].'">';
			$id_asset.='<li>'.$isi['barcode_old'].'</li>';
			$category_name.='<li>'.$isi['category_name'].'</li>';
			$nama_item.='<li>'.$isi['item_name'].'</li>';
			$barcode_pindahan.='<li>'.$isi['barcode'].'</li>';
			$baris++;

		}
		$id_asset.='</ul>';
		$category_name.='</ul>';
		$nama_item.='</ul>';
		$barcode_pindahan.='</ul>';
		
		
	}

?>
<tr id="row_<?php echo $result_item['barcode'] ?>" >
	<td><?php echo $i?></td>
	<td><?php echo $barcode_pindahan?></td>	
	<td><?php echo $barcode_box ?></td>
	<td><?php echo $id_asset?></td>
	<td><?php echo $category_name?></td>
	<td><?php echo $nama_item?></td>
</tr>

<?php 
	if($baris%$data_per_page==0)
	{
		echo '</table><div class="break_">&nbsp;</div>';
		header_lap($result);
	}
$i++;
$baris++;
} ?>
</table>
<br>
<table class="" width="100%" cellpadding="3" cellspacing="2" border="1">
		<tr>
			<td colspan="2" align="center">Pondok Ungu</td>
			<td colspan="2" align="center">Surya Cipta</td>
			
		</tr>
		<tr>
			<td>TANGGAL KEBERANGKATAN/PUKUL</td>
			<td>:</td>
			<td>TANGGAL KEDATANGAN/PUKUL</td>
			<td>:</td>
		</tr>
		<tr>
			<td align="center" >PIC POS</td>
			<td align="center" >KEAMANAN</td>
			<td align="center" >KEAMANAN</td>
			<td align="center" >PIC POS</td>
			
		</tr>
		<tr>
			<td align="center"><br><br><br>(Nama Lengkap)</td>
			<td align="center"><br><br><br>(Nama Lengkap)</td>
			<td align="center"><br><br><br>(Nama Lengkap)</td>
			<td align="center"><br><br><br>(Nama Lengkap)</td>
		</tr>

	</table>	
	</body>
</html>

<?php function header_lap($result){?>
	
	<table class="" cellpadding="2" width="100%" style="border:1px #000 solid;">
	<tr >
		<td colspan="2" align="left">
		<img src="<?php echo base_url('assets/images/logo.png')?>" width="200px"></td>
		<td colspan="2" align="center"><p style="font-size:">Jl Danau Sunter Utara Blok O-3 Kav 30 Sunter<br>Jakarta 14330, Indonesia<br>Telp +62-21-650 1000 Fax  +62-21-651 777</p>
</td>
	</tr>
	<tr style="border:1px #000 solid"><td colspan="4" align="center">SURAT JALAN <br> PEMINDAHAN ASSET KE NEW PLANT</td></tr>	
	<tr style="border:1px #000 solid">
		<td colspan="2" align="center">PONDOK UNGU</td>
		<td colspan="2" align="center" style="border-left:1px #000 solid">SURYA CIPTA</td>

	</tr>
	<tr>
		<td>No</td>
		<td>: <?php echo $result['permit_number']?></td>
		<td style="border-left:1px #000 solid">POS</td>
		<td>: <?php echo $result['gate_from']?></td>
		
	</tr>
	<tr>
		
		<td>No Polisi Kendaraan</td>
		<td>: <?php echo $result['car_number']?></td>
		<td style="border-left:1px #000 solid">Gate</td>
		<td>: <?php echo $result['gate_destination']?></td>
	</tr>
	<tr>
		<td>Nama Pengemudi</td>
		<td>: <?php echo $result['driver_name']?></td>
		<td style="border-left:1px #000 solid"></td>
		<td></td>
		
	</tr>
</table><br>
<table width="100%" border="1" cellpadding="4">
<thead>
	<tr>
		<th>No</th>
		<th>Barcode Pindahan</th>
		<th>Barcode Box</th>
		<th>ID Asset</th>
		<th>Asset Type</th>
		<th>Nama Asset</th>
	</tr>
</thead>
<?php } ?>

<script>
		$(function(){
			window.print();
		})

</script>