<form id="frm-sj"  method="post">
<input type="hidden" name="next_process_id" id="next_process_id" value="<?php echo $next_process_id ?>">
<input type="hidden" name="next_process_name" id="next_process_name" value="<?php echo $next_process_name ?>">
<table class="table table-condensed table-striped">
<tbody>
	<tr>
		<td >Masukan Nomor Surat Jalan</td>
		<td><?php echo form_input($frm_permit_numbers)?></td>
		<td><input type="submit" name="submit" class="btn btn-primary" value="cari surat jalan"></td>
	</tr>
</tbody>
</table>
</form>
<div id="detail_surat_jalan"><?php echo $subcontent?></div>
<script>
	$(function(){
		$('#frm-sj').submit(function(data){
			$.post('<?php echo base_url('demopickup/detail_all_sj')?>',$(this).serialize(),function(data){
				$('#detail_surat_jalan').html(data);	
				$('#barcode').focus();

			});
			
		})
	})

</script>

