<pre>Dibuat oleh : <?php echo  $result['nama_lengkap'].' | '.date('d-m-Y',strtotime($result['date_create']))?></pre>
<form id="frm-ver">
<table class="table table-condensed">
	<tr>
		<td>Loading Point</td>
		<td><?php echo form_dropdown('loading_point',$opt_loading_point,'','id="loading_point" class="form-control input-sm"')?></td>
		
		<td>Nomor HP Sopir</td>
		<td><?php echo form_input($form['ho_sopir'])?></td>
		
	</tr>
	<tr>
		
		<td>Gate Tujuan</td>
		<td><?php echo form_dropdown('id_gate_to',$opt_gate_to,'','id="id_gate_to" class="form-control input-sm"')?></td>
		<td>Nomor Kendaraan</td>
		<td><?php echo form_input($form['car_number'])?></td>
		
	
	</tr>
	<tr>
		<td>Nama Sopir</td>
		<td><?php echo form_dropdown('id_driver',$opt_driver,'','id="id_driver" class="form-control input-sm"')?></td>
		<td colspan="2">&nbsp;</td>
	</tr>
</table>
<pre>Detail Surat Jalan</pre>
<table class="table table-striped  table-condesed table-bordered">
<thead>
	<tr>
	<th>Nama Barang</th>
	<th>Barcode</th>
	<th>Barcode Lama</th>
	<th>PIC Departemen</th>
	<th>Action</th>
	</tr>
</thead>
<tbody>
<?php foreach ($result_detail as $result_item) { ?>
<tr id="row_<?php echo $result_item['barcode'] ?>" >
	<td><?php echo $result_item['item_name']?></td>
	<td><?php echo $result_item['barcode']?></td>
	<td><?php echo $result_item['barcode_old']?></td>
	<td><?php echo $result_item['pic_department']?></td>
	<td><a  class="btn btn-small btn-primary delete_detail" onclick="delete_($(this))" id="<?php echo $result_item['id_pickup_detail']?>" rel="<?php echo $result_item['barcode'] ?>">Delete</a></td>
	
</tr>
<?php } ?>
<tr><td colspan="5"><a class=" btn btn-primary" id="verifikasi_benar">VERIFIKASI SURAT JALAN BENAR</a></td></tr>
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
				// VALIDASI DULU NANTINYA
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