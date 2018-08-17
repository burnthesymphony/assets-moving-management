<div class="box-body table-responsive no-padding">
<form id="frm-cari" method="post">
<table class="table table-condesed">
	
	<tr>
		<td>Kategori Item</td>
		<td><?php echo form_dropdown('a.id_item_category',$opt_item_category,'','class="form-control" id ="id_item_categori"')?></td>
	</tr>
	<tr>
		<td>Barcode</td>
		<td><?php echo form_input($barcode)?></td>
	</tr>
	<tr>
		<td colspan="2"><a class="btn btn-primary" id="btn-cari">Cari Item</a></td>
		
	</tr>
</table>
</form>
<div id="list_"></div>
</div>

<script>
	$(function(){
		get_list(0)	;
		$('#btn-cari').click(function(){
			get_list(0)	;
		})
		$('#frm-cari').submit(function(){
			get_list(0)	;
			return false;
		})
	})


	function get_list(offset){
		$('#list_').html('<div align="center"><img src="<?php  echo base_url('assets/img/ajax-loader1.gif')?>"></div>');
		$.post('<?php echo base_url('master/asset/list_')?>/offset/'+offset,{filter:$('#frm-cari').serializeArray(),jenis:'<?php echo $jenis?>'},
			function(data){
				$('#list_').html(data);
			}

		)
	}
</script>