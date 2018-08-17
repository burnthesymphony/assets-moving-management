<form id="frm-scan-item" action="javascript:void(0);">
<input type="hidden" name="parent" id="parent" value="<?php echo $parent?>">
<table class="table table-condensed table-striped">
<tbody>
	<tr>
		<td>
			<h1 style="text-align:center">Scan Barcode Here:</h1>
			<?php echo form_input(array('name'=>'barcode','class'=>'form-control','id'=>'barcode_item','value'=>''))?><br><br>			
		</td>
	</tr>

</tbody>
</table>
</form>
<table class="table table-responsive table-striped">
	<thead>
		<tr>
			
			<th>Nama Asset</th>
			<th>Kategori</th>
			<th>Barcode</th>
			<th>barcode Lama</th>
		</tr>

	</thead>
	<tbody id="items">
		<?php 
		$no= 1 + $offset;
		foreach($result as $rec):	//print_r($rec)?>
		<tr>
			
			<td><?php echo $rec['item_name'] ?></td>
			<td><?php echo $rec['category_name'] ?></td>
			<td><?php echo $rec['barcode'] ?></td>
			<td><?php echo $rec['barcode_old'] ?></td>
		</tr>
		<?php $no++; endforeach;	?>

	</tbody>
</table>
<script>
	$(function(){
		$('#frm-scan-item').submit(function(){
				$.post('<?php echo base_url('master/asset/insert_item')?>',$('#frm-scan-item').serialize(),function(data){
					$('#item_'+$('#barcode_item').val()).remove();
					$('#items').html(data);
				})
		})
	})

</script>