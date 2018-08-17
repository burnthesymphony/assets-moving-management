<form id="frm-scan" action="javascript:void(0);">

<table class="table table-condensed table-striped">
<tbody>
	<tr>
		<td>
			<h1 style="text-align:center">Scan Barcode Here:</h1>
			<?php echo form_input($frm_barcode)?><br><br>			
		</td>
	</tr>

</tbody>
</table>

</form>
<div style="clear:both">&nbsp;</div>

<form id="frm-detail-pickup">
<table class="table table-condensed table-striped">
	<thead>
		<tr>
			<th>Nama Barang</th>
			<th>Barcode</th>
			<th>Barcode Lama</th>
			<th>PIC Departemen</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody id="detail_pickup"></tbody>
</table>
</form>
<div><input type="button" name="btn_surat_jalan" id="btn_surat_jalan" class="btn btn-primary" value="SELESAI DAN SIAP CETAK"></div>


<script>
	$(function(){
		
		$('#barcode').focus();
		$('#frm-scan').submit(function(){
			
			
			if($('#barcode_list_'+$('#barcode').val()).size()> 0){
				current_qty 	= parseInt($('#qty_'+$('#barcode').val()).val());
				new_qty 		= current_qty + 1;
				$('#qty_'+$('#barcode').val()).val(new_qty);


			}
			else{
				$.post("<?php echo base_url('pickup/insert_detail_pickup/'.$draft_id_pickup)?>",$('#frm-scan').serialize(),function(data){
					$('#detail_pickup').prepend(data);
					
				})
			}
			
			$('#barcode').val('');		
		})
		
		$('#btn_surat_jalan').click(function(){
			parm_= $('#frm-header-pickup').serialize()+'&'+$('#frm-detail-pickup').serialize();
			
			$.post("<?php echo base_url('pickup/set_siap_cetak/')?>",{draft_id_pickup : '<?php echo$draft_id_pickup?>'},function(data){
					var obj=jQuery.parseJSON(data);
					if(obj.error_message==''){
						alert('Data Berhasil di update Surat Jalan menunggu Proses Verifikasi');
						location.href="<?php echo base_url('pickup/surat_jalan/SIAPCETAK')?>";
					}
					else{
						alert(obj.error_message);
						return false
					}
					
			})
			
		})
	})

	
	$(function(){

/*$('.delete_detail').click(function(){
			var r= confirm("Yakin Hapus Data ");
			if(r==true){
				barcode_=$(this).attr('rel');
				$.post("<?php echo base_url('pickup/delete_detail_pickup_pickup/')?>",{id_pickup_detail:$(this).attr('id')},function(data){
					var obj=jQuery.parseJSON(data);
					if(obj.error_message==''){	
						$('#row_'+barcode_).hide('slow');
					}
				})
			}
			else{
				return false;
			}
			
		})*/

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