<div class="box-body table-responsive no-padding">
<form id="form-cari">
<input type="hidden" name="status" value="<?php echo $status?>">
<table class="table table-condesed">
	<tr>
		<td>Nama Asset</td>
		<td><?php echo form_input($item_name)?></td>
	</tr>
	<tr>
		<td>Kategori Asset</td>
		<td><?php echo form_dropdown('id_item_categori',$opt_item_category,'','class="form-control" id ="id_item_categori"')?></td>
	</tr>
	<tr>
		<td>Barcode</td>
		<td><?php echo form_input($barcode)?></td>
	</tr>
	<tr>
		<td colspan="2"><a class="btn btn-primary" id="btn-cari">Cari Asset</a></td>
		
	</tr>
</table>
</form>
<form id='barcode-list-frm'>
<div class="alert alert-success" style="margin-left :0px"> Daftar Barcode </div>
<div id="list_"></div>
</form>
</div>

<script>
	$(function(){
		get_list(0)	;
	})

	function get_list(offset){
		$.post('<?php echo base_url('barcode/barcode/list_')?>/offset/'+offset,{filter:$('#form-cari').serializeArray()},
			function(data){
				$('#list_').html(data);
			}

		)
	}


</script>