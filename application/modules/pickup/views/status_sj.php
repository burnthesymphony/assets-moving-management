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
<table class="table table-condensed table-bordered">
	<thead>
	<tr>
		<th style="text-align:center">ITEM LIST</th>
		
	</tr>
	</thead>
	<tbody>
		<tr>
			<td >
			<table class="table table-condensed table-striped table-bordered">
				<tr>
					<td>Barcode</td>
					<td>Nama Barang</td>
					<td>Deskripsi</td>
					<td>Jumlah di surat jalan</td>
					

				</tr>
			
			
				<?php 
				  $demo      = $this->load->module('demopickup/demopickup');
				foreach($result_detail as $rec_detail):?>

					<tr id="row-last-proccess-<?php echo $rec_detail['barcode'] ?>">
					<td><?php echo $rec_detail['barcode']?> </td>
					<td><?php echo $rec_detail['item_name']?></td>
					<td><?php echo $rec_detail['description']?></td>
					<td><span id="qty-last-<?php echo $rec_detail['barcode'] ?>"><?php echo $rec_detail['qty']?></span>
					<input type="hidden" name="qty[<?php echo $rec_detail['id_item']?>]" value="<?php echo $rec_detail['qty']?>">
					
					</td>
					<tr><td colspan="4">
						<div class="proses_sts">Item On Delivering<br>
								<img src="<?php echo base_url('assets/images/delivery.png')?>" width="50px">
								<?php  $demo::get_process($rec_detail['id_pickup_detail'],$rec_detail['id_item'],2)?>
						</div>
						<div class="proses_sts2"><img src="<?php echo base_url('assets/images/1rightarrow.png')?>" width="40px"></div>
						<div class="proses_sts">Item On Deliverd <br>
							<img src="<?php echo base_url('assets/images/item-delivered.png')?>" width="50px">
							<?php  $demo::get_process($rec_detail['id_pickup_detail'],$rec_detail['id_item'],3)?>
						</div>
							<div class="proses_sts2"><img src="<?php echo base_url('assets/images/1rightarrow.png')?>" width="40px"></div>
						<div class="proses_sts">1st Verification<br>
							<img src="<?php echo base_url('assets/images/1st-verification.png')?>" width="50px">	
							<?php  $demo::get_process($rec_detail['id_pickup_detail'],$rec_detail['id_item'],4)?>
						</div>
						<div class="proses_sts2"><img src="<?php echo base_url('assets/images/1rightarrow.png')?>" width="40px"></div>
						<div class="proses_sts">2st Verification<br>
						<img src="<?php echo base_url('assets/images/2nd-verification.png')?>" width="50px">
						<?php  $demo::get_process($rec_detail['id_pickup_detail'],$rec_detail['id_item'],5)?>	
						</div>
						<br><br><br>
						</td>
					</tr>
					

				</tr>
				<?php endforeach; ?>
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
<style>
	.proses_sts{
		display: inline;
		width:225px;
		float:left;
		text-align: center;
		font-weight: bold;
	
	}
	.proses_sts2{
		display: inline;
		width:45px;
		float:left;
		padding-top:20px;
	}

</style>