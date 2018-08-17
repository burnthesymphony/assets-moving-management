<table class="table table-condensed table-striped">
	<tr>
		<td><b>Nomor Surat Jalan</b></td>
		<td>: <?php  echo $result['permit_number']?></td>
		<td><b>Nomor Kendaraan</b></td>
		<td>: <?php  echo $result['car_number']?></td></tr>
	<tr>
		<td><b>Gudang Asal</b></td>
		<td>: <?php  echo $result['inventory_from']?></td>
		<td><b>Nama Sopir</b></td>
		<td>: <?php  echo $result['drivername']?></td>
	</tr>
	<tr>
		<td><b>Gudang Tujuan</b></td>
		<td>: <?php  echo $result['inventory_to']?></td>
		<td></td><td></td>
	</tr>
</table>
<form id="frm-scan-sj" action="javascript:void(0);">
<input type="hidden" name="next_process_id" id="next_process_id" value="<?php echo $next_process_id ?>">
<input type="hidden" name="next_process_name" id="next_process_name" value="<?php echo $next_process_name ?>">
<input type="hidden" name="id_pickup" id="id_pickup" value="<?php echo $id_pickup ?>">
<input type="hidden" name="id_inventory_to" id="id_inventory_to" value="<?php echo $result['id_inventory_to'] ?>">
<div class="pad margin no-print">
	<div class="alert alert-info">Scan barcode <?php echo form_input($frm_barcode)?></div>
</div>
</form>
<table class="table table-condensed table-bordered">
	<thead>
	<tr>
		<th style="text-align:center">ITEM LIST</th>
		<th style="text-align:center">SET <?php echo strtoupper($next_process_name) ?></th>
	</tr>
	</thead>
	<tbody>
		<tr>
			<td style="width:50%">
			<table class="table table-condensed table-striped table-bordered">
				<tr>
					<td>Barcode</td>
					<td>Nama Barang</td>
					<td>Deskripsi</td>
					<td>Jumlah di surat jalan</td>
					<!--<td>Status Proses</td>
					<td>Jumlah Item <br> dalam Status Proses</td>-->

				</tr>
			
			
				<?php foreach($result_detail as $rec_detail):?>

					<tr id="row-last-proccess-<?php echo $rec_detail['barcode'] ?>">
					<td><?php echo $rec_detail['barcode']?> </td>
					<td><?php echo $rec_detail['item_name']?></td>
					<td><?php echo $rec_detail['description']?></td>
					<td><span id="qty-last-<?php echo $rec_detail['barcode'] ?>"><?php echo $rec_detail['qty']?></span>
					<input type="hidden" name="qty[<?php echo $rec_detail['id_item']?>]" value="<?php echo $rec_detail['qty']?>">
					
					</td>
					<!--<td><?php echo $rec_detail['process_name']?></td>
					<td><?php echo $rec_detail['qty_per_status']?></td>-->

				</tr>
				<?php endforeach; ?>
				</table>
				
			</td>
			<td style="width:50%">
				<table class="table table-condensed table-striped table-bordered">
				<tr>
					<td>Barcode</td>
					<td>Nama Barang</td>
					<td>Deskripsi</td>
					<td>Jumlah</td>

				</tr>
				<tbody id="set_item">
				<?php if(!empty($next_result)){
					foreach($next_result as $rec_detail):
				?>
					<tr id="row-next-proccess-<?php echo $rec_detail['barcode'] ?>">
					<td><?php echo $rec_detail['barcode']?> </td>
					<td><?php echo $rec_detail['item_name']?></td>
					<td><?php echo $rec_detail['description']?></td>
					<td><span id="qty-next-<?php echo $rec_detail['barcode'] ?>"><?php echo $rec_detail['qty']?></span>
					<input type="hidden" name="id_log[]" id="log-item-<?php  echo $rec_detail['barcode'] ?>" value="<?php echo $rec_detail['id_log_item_process']?>">
					</td>

				</tr>
				<?php 
					endforeach;
				}?>
				</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
<script type="text/javascript">
	$(function(){
		$('#frm-scan-sj').submit(function(){
			/*if($('#set_item').html()==''){
				$.post('<?php echo base_url('demopickup/set_progress_by_sj/')?>',$(this).serialize(),function(data){
					$('#set_item').append(data);
				})
			}*/
			//else{
				//JIKA SUDAH ADA DATA NEXT PROCCESSNYA
				if($('#row-next-proccess-'+$('#barcode').val()).size()>0){
					last_qty 		= parseInt($('#qty-last-'+$('#barcode').val()).html());
					curent_qty 		= parseInt($('#qty-next-'+$('#barcode').val()).html());
					progress_qty 	= curent_qty +1;
					
					//CEK JIKA SEMUA BARANG SUDAH DI VERIFIKASI MAKA ABAIKAN
					if(progress_qty>last_qty){
						alert('DATA UNTUK BARCODE '+$('#barcode').val()+' SUDAH DI VERIFIKASI');
						$('#barcode').val('');	
						return false;
					}
					else{
						$.post('<?php echo base_url('demopickup/update_progress/')?>',{qty_update:progress_qty,log_id:$('#log-item-'+$('#barcode').val()).val()},function(data){
								
								if(data==''){
							
									$('#qty-next-'+$('#barcode').val()).html(progress_qty);
									$('#barcode').val('');	
								}
								else{
									alert(data); 
									return false;
								}
							})
					}
					
					
				}
				else{
					$.post('<?php echo base_url('demopickup/set_progress_by_sj/')?>',$(this).serialize(),function(data){
						$('#set_item').append(data);
							$('#barcode').val('');		
					})
				}
				
			//}
			
		
		})		
	})
</script>