<?php if(!empty($result_item)):?>
<tr id="row_<?php echo $result_item['barcode'] ?>" >
	<td>
		<input type="hidden" name="barcode_list[]" id="barcode_list_<?php echo $result_item['barcode'] ?>" value="<?php echo $result_item['barcode'] ?>" class="barcode_list" >
		<?php echo $result_item['item_name']?>
	</td>
	<td><?php echo $result_item['description']?></td>
	<td><input type="text" id="qty_<?php echo $result_item['barcode'] ?>" readonly="readonly" name="quantity[<?php echo $result_item['id_item'] ?>]" value="1" ></td>
	<td><a  class="btn btn-small btn-primary">Delete</a></td>
</tr>
<?php endif;?>
