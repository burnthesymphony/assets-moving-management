<div class="box-body table-responsive no-padding">
<form id="frm-asset" action="<?php echo base_url('master/asset/submit')?>" method="post" onsubmit="javascript:void(0); return false;">
<table class="table table-condesed">
	
	<tr>
		<td>Barcode</td>
		<td><?php echo form_input($barcode)?></td>
	</tr>
	<tr>
		<td>Barcode Lama</td>
		<td><?php echo form_input($barcode_old)?></td>
	</tr>
	
	<tr>
		<td>Nama Item<input type="hidden" name="id_item" value="<?php echo $selected['id_item']?>"></td>
		<td><?php echo form_input($item_name)?></td>
	</tr>
	
	<tr>
		<td>Kategori Item</td>
		<td><?php echo form_dropdown('id_item_categori',$opt_item_category,$selected['id_item_category'],'class="form-control" id ="id_item_categori"')?></td>
	</tr>
	<tr>
		<td>Deskripsi</td>
		<td><?php echo form_input($description)?></td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" class="btn btn-primary" id="btn-simpan" value="Simpan"></td>
		
	</tr>
	
</table>
</form>
</div>
<script >
	$(function(){
		$('#btn-simpan').click(function(){
			
			$.post($('#frm-asset').attr('action'),$('#frm-asset').serialize(),function(data){
				location.href="<?php echo base_url('master/asset/index/'.$jenis)?>";

			})
			
		})
	})

</script>

