<?php 	$ass=$this->load->module('master/asset'); ?>

<table class="table table-responsive table-striped">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Asset</th>
			<th>Kategori</th>
			<th>Barcode</th>
			<th>barcode Lama</th>
			<th>Barcode BAR</th>
			<th>Status</th>
			<td align="center"><input type="checkbox" id="checkall"></td>
		</tr>

	</thead>
	
	<tbody>
				
		<?php 
		$no= 1 + $offset;

		foreach($result as $rec):	//print_r($rec)?>
		<tr id="list_<?php echo $rec['id_item']?>">
			<td><?php echo $no ?></td>
			<td><?php echo $rec['item_name'] ?></td>
			<td><?php echo $rec['category_name'] ?></td>
			<td><?php echo $rec['barcode'] ?></td>
			<td><?php echo $rec['barcode_old'] ?></td>
			<td><?php $ass::generate_barcode($rec['barcode']); ?></td>
			<td><?php echo $rec['status_print'] ?></td>
			<td align="center">
				<?php if($status<>'on-product') :?>
					<input type="checkbox" class="selected_item" name="selected_item[]" value="<?php echo $rec['id_item']?>">
				<?php endif;?>
			</td>
		</tr>
		<?php $no++; endforeach;	?>
		
	</tbody>

</table>
<div align="right">
<?php if($status=='none') :
			$label_action		= 'PRINT BARCODE';
			$next_action 		= base_url('barcode/print_');
			$next_status 		= 'printed'; 
		endif;
		if($status=='printed') :
			$label_action		= 'PRINT ULANG BARCODE';
			$next_action 		= base_url('barcode/print_');
			$next_status 		= 'printed'; 
		endif;
?>
<a id="change_status_btn" class="btn btn-sm btn-primary"><?php echo $label_action?></a> 

</div>
<script>
	$(function(){
		$('#checkall').change(function(){
			 if(this.checked) {
        		$('.selected_item').attr('checked',true);
    		}
    		else{
    			$('.selected_item').removeAttr('checked');
    		}
		})
		$('#change_status_btn').click(function(){
			var status='<?php echo $status?>';
			$.post("<?php echo base_url('barcode/change_status/'.$next_status)?>",$('#barcode-list-frm').serialize(),function(data){
				if(status=='none'){
					$('.selected_item:checked').each(function(i){
          					$('#list_'+$(this).val()).hide();
       				 });
					
				}
				window.open("<?php echo base_url('barcode/print_barcode').'?'?>"+$('#barcode-list-frm').serialize(),'_blank');
				
				
			});
		})
	})

</script>