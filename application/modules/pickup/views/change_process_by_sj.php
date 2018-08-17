<form id="frm-sj"  method="post" onsubmit="void(0);return false;">

<input type="hidden" name="process_name" id="next_process_name" value="<?php echo $proses?>">
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
		$('#permit_number').focus();
		$('#frm-sj').submit(function(data){
			$.post('<?php echo base_url('pickup/set_proses/change_status')?>',$(this).serialize(),function(data){
				$('#detail_surat_jalan').html(data);	
				
				return false

			});
			
		})
	})

</script>

