<form id="form-cari">
<input type="hidden" name="status" value="On-Product">
</form>
<form id="frm-scan" action="javascript:void(0);return false">
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

<div class="alert alert-success" style="margin-left :0px"> Daftar Barcode Sudah Di Tempel</div>
<div id="list_"></div>
<script>
	$(function(){
		get_list(0)
		$('#barcode').focus();
		$('#frm-scan').submit(function(){
			$.post("<?php echo base_url('barcode/change_status_pemasangan/Y')?>",$('#frm-scan').serialize(),function(data){
						var obj=jQuery.parseJSON(data)
						if(data.error_message==0);
						get_list(0)	;
				})
			$('#barcode').val('');		
		})	
	})
	function get_list(offset){
		$('#list_').html('<div align="center"><img src="<?php echo base_url('assets/img/ajax-loader.gif') ?>"></div>');
		$.post('<?php echo base_url('barcode/barcode/list_')?>/offset/'+offset,{status_pemasangan:'Y'},
			function(data){
				$('#list_').html(data);
			}

		)
	}
</script>