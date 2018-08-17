<?php 
	$ass=$this->load->module('master/asset');

?>
<div align="right"><a href="<?php echo base_url('master/asset/insert/'.$jenis)?>" class="btn btn-sm btn-primary">Tambah Item</a> </div>
<label><?php echo 'Total   : '.$total_row .' Item'?></label>
<table class="table table-responsive table-striped">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Asset</th>
			<th>Kategori</th>
			<th>Barcode</th>
			<th>barcode Lama</th>
			<th>Barcode BAR</th>
			<?php if($jenis=='item') echo '<th>Barcode BOX</th>'?>
			<th style="text-align:center">Action</th>
		</tr>

	</thead>
	<tbody>
		<?php 
		$no= 1 + $offset;
		foreach($result as $rec):	//print_r($rec)?>
		<tr id="item_<?php echo $rec['barcode']?>">
			<td><?php echo $no ?></td>
			<td><?php echo $rec['item_name'] ?></td>
			<td><?php echo $rec['category_name'] ?></td>
			<td><?php echo $rec['barcode'] ?></td>
			<td><?php echo $rec['barcode_old'] ?></td>
			<td><?php $ass::generate_barcode($rec['barcode']); ?></td>
			<?php if($jenis=='item') {$detail_item=$ass->detail_item($rec['parent']); echo '<th>'.$detail_item['barcode'].'</th>'; }?>
			<td align="center"><?php if($rec['id_item_category']==4) 
									echo '<a title="item list dalam box" data-toggle="modal" class="btn btn-warning btn-sm action_popup" data-target="#myModal" page="'.base_url('master/asset/list_item/'.$rec['id_item']).'" ><i class="fa fa-th-list"></i></a>'; 
					//if($jenis=='item') echo '<a>box penyimpanan</a>';?>&nbsp;
					<a title="edit" href="<?php echo base_url('master/asset/insert/'.$jenis.'/'.$rec['id_item'])?>" class="btn btn-success btn-sm"><i class="fa  fa-pencil"></i></a>&nbsp; 
					<a title="hapus" class="hapus btn btn-danger btn-sm" index_item="<?php echo $rec['id_item']?>"><i class="fa fa-times"></i></a> </td>
		</tr>
		<?php $no++; endforeach;	?>

	</tbody>
</table>
		<?php echo $this->pagination->create_links(); ?>
<script>
$(document).ready(function() {
		$('.action_popup').click(function(){
			$.post($(this).attr('page'),function(data){
				$('.modal-dialog').css('width','985px');
				$('.modal-title').html('Asset Dalam Box');
				$('.te').html(data)
			})
		})
  		
  		$('.hapus').click(function(){
  			var r=confirm('Yakin Hapus Data');
  			if(r==true){
  				$.post('<?php echo base_url('master/asset/hapus')?>',{id_item:$(this).attr('index_item')},function(data){
  					if(data==0){
  						get_list('<?php echo $offset?>');
  					}
  					else{
  						alert(data);
  						return false;
  					}
  				})
  			}
  			else
  				return false;
  		})
	
});

</script>
<script>
	/*PAGINATION MENJADI AJAX*/
	
	$(function(){
		 $.each($('.pagination li a'), function() { 
					if($(this).attr('href')){
						href_ 	 = $(this).attr('href');
						href_arr = href_.split('/');
						length_	 = href_arr.length;
						index_ofset= parseInt(length_) -1;
						offset	 = href_arr[index_ofset];
						$(this).attr('href','javascript:;');
						$(this).attr('onclick','get_list('+offset+')');
					}
					
					//$(this).hide()	;
		});
		 $('#favourites_btn').click(function(){
		 	
		 	$('#favourites_').slideToggle('fast')
		 })
	})
	/*PAGINATION MENJADI AJAX*/