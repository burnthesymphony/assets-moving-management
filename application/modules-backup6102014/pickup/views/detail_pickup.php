<?php if(!empty($result_item)):?>
<tr id="row_<?php echo $result_item['barcode'] ?>" >
	<td>
		<input type="hidden" name="barcode_list[]" id="barcode_list_<?php echo $result_item['barcode'] ?>" value="<?php echo $result_item['barcode'] ?>" class="barcode_list" >
		<?php echo $result_item['item_name']?>
	</td>
	
	<td><?php echo $result_item['barcode']?></td>
	<td><?php echo $result_item['barcode_old']?></td>
	<td><?php echo $result_item['pic_department']?></td>
	<td><a  class="btn btn-small btn-primary delete_detail" onclick="delete_($(this))" id="<?php echo $last_id_pickup_detail?>" rel="<?php echo $result_item['barcode'] ?>">Delete</a></td>
</tr>
<?php endif;?>
