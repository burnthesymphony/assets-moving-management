<pre>Dibuat oleh : <?php echo  $result['nama_lengkap'].' | '.date('d-m-Y',strtotime($result['date_create']))?></pre>
<form id="frm-ver">
<input type="hidden" name="id_pickup" value="<?php echo $result['id_pickup']?>" id="id_pickup">
<table class="table table-condensed">
	<tr>
		<td>Loading Point *</td>
		<td><?php echo form_dropdown('loading_point',$opt_loading_point,'','id="loading_point" title="Loading Point" class="required form-control input-sm"')?></td>
		<td>Nomor HP Sopir</td>
		<td><?php echo form_input($form['ho_sopir'])?></td>
		
	</tr>
	<tr>
		
		<td>Gate Tujuan *</td>
		<td><?php echo form_dropdown('id_gate_to',$opt_gate_to,'','id="id_gate_to" title="Gate Tujuan" class="required  form-control input-sm"')?></td>
		<td>Nomor Kendaraan *</td>
		<td><?php echo form_input($form['car_number'])?></td>
		
	
	</tr>
	<tr>
		<td>Nama Sopir *</td>
		<td><?php echo form_dropdown('id_driver',$opt_driver,'','id="id_driver" title="Nama Sopir " class="required  form-control input-sm"')?></td>
		<td colspan="2">&nbsp;</td>
	</tr>
</table>
<pre>Detail Surat Jalan</pre>
<table class="table table-striped  table-condesed table-bordered">
<thead>
	<tr>
	
	<th>Barcode Pindahan</th>
	<th>Barcode BOX</th>
	<th>ID Asset</th>
	<th>Asset Type</th>
	<th>Nama Asset</th>
	<th>PIC Departemen</th>
	<th>Action</th>
	</tr>
</thead>
<tbody>
<?php 
$asset=$this->load->module('master/asset');

foreach ($result_detail as $result_item) {  //echo '<pre>';print_r($result_item);echo '</pre>';?>
<?php 
	$category_name 	= $result_item['category_name'];
	$nama_item		= $result_item['item_name'];
	$pic_departemen	= $result_item['pic_department'];
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
		$isi_box			= $asset->isi_box($result_item['id_item']);
		$barcode_box 		= '';
		$id_asset.='<br><ul>';
		$category_name ='<br><ul>';
		$nama_item.='<ul>';
		$barcode_pindahan.='<ul>';
		$pic_departemen.='<br><ul>';
		foreach($isi_box as $isi){
			echo '<input type ="hidden" name="isi_box_item['.$result_item['id_item'].'][]" value="'.$isi['id_item'].'">';
			$id_asset.='<li>'.$isi['barcode_old'].'</li>';
			$category_name.='<li>'.$isi['category_name'].'</li>';
			$nama_item.='<li>'.$isi['item_name'].'</li>';
			$barcode_pindahan.='<li>'.$isi['barcode'].'</li>';
			$pic_departemen.='<li>'.$isi['pic_department'].'</li>';

		}
		$id_asset.='</ul>';
		$category_name.='</ul>';
		$nama_item.='</ul>';
		$barcode_pindahan.='</ul>';
		$pic_departemen.='<ul>';
		
	}

	?>
<tr id="row_<?php echo $result_item['barcode'] ?>" >

	<td><?php echo $barcode_pindahan?></td>	
	<td><?php echo $barcode_box ?></td>
	<td><?php echo $id_asset?></td>
	<td><?php echo $category_name?></td>
	<td><?php echo $nama_item?></td>
	<td><?php echo $pic_departemen?></td>
	<td><a  class="btn btn-small btn-primary delete_detail" onclick="delete_($(this))" id="<?php echo $result_item['id_pickup_detail']?>" rel="<?php echo $result_item['barcode'] ?>">Delete</a></td>
	
</tr>
<?php } ?>
<tr><td colspan="7"><a class=" btn btn-primary" id="verifikasi_benar">VERIFIKASI SURAT JALAN BENAR</a></td></tr>
</tbody>
</table>
</form>
<script>
		$(function(){
			$('#id_driver').change(function(){
				$.post('<?php echo base_url('pickup/pickup/driver_detail')?>/'+$(this).val(),function(data){
					var obj= jQuery.parseJSON(data);
					$('#no_hp').val(obj.no_hp);

				})
			})
			$('#verifikasi_benar').click(function(){
				var alert_='';
				$('.required').each(function(){
					if($(this).val()=='')
					{
						alert_.concat($(this).attr('title') + ' Harus Di isi',alert_);
						
					}
					
				})
				if(alert_!=''){
					alert(alert_);
					return false;
				}
			
				$.post('<?php echo base_url('pickup/pickup/verifikasi_benar_surat_jalan/')?>',$('#frm-ver').serialize(),function(data){

					if(data==''){
					
						window.open('<?php echo base_url('pickup/pickup/cetak_surat_jalan')?>/'+$('#id_pickup').val(),'_BLANK');
					}
					else{
						return false;
					}
				})
			})
		})
		function delete_(ni){

		var r= confirm("Anda Yakin Hapus Data? ");
			if(r==true){
				barcode_=ni.attr('rel');
				$.post("<?php echo base_url('pickup/delete_detail_pickup_pickup/')?>",{id_pickup_detail:ni.attr('id')},function(data){
					var obj=jQuery.parseJSON(data);
					if(obj.error_message==''){	
						$('#row_'+barcode_).fadeOut();
					}
				})
			}
			else{
				return false;
			}
			
	}

</script>