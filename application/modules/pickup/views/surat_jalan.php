<table class="table table-condensed table-striped">
	<thead>
		<tr>
			<th>Nomor Surat Jalan</th>
			<th>Tempat asal</th>
			<th>Tempat Tujuan</th>
			<th>Nomor Kendaraan</th>
			<th>Nama Supir</th>
			<th>User Create</th>
			<th>Action</th>
			
		</tr>
	</thead>
	<tbody>
		<?php foreach($result as $rec):?>
		<tr>
			<td><?php echo $rec['permit_number']?></td>
			<td><?php echo $rec['gate_from']?></td>
			<td><?php echo $rec['gate_destination']?></td>
			<td><?php echo $rec['car_number']?></td>
			<td><?php echo $rec['driver_name']?></td>
			<td><?php echo $rec['nama_lengkap']?><br>
			<?php echo '('.date('d-m-Y H:i',strtotime($rec['date_create'])).')'?></td>
			<td><a class="btn btn-sm btn-primary" onclick="detail_sj(<?php echo $rec['id_pickup']?>)">Lihat Detail</a> 
				<?php  if($rec['status']=='SIAPCETAK') {?>
				<a title="Verifikasi Surat jalan" data-toggle="modal" class="btn  btn-sm btn-primary action_popup" data-target="#myModal" page="<?php echo base_url('/pickup/verifikasi_cetak_sj/'.$rec['id_pickup']) ?>">Verifikasi Dan Cetak</a>
				<?php } ?>
				<?php  if($rec['status']=='TERBIT') {?>
				<a title="Cetak Surat Jalan"  class="btn  btn-sm btn-primary action_popup" target="_blank" href="<?php echo base_url('/pickup/cetak_surat_jalan/'.$rec['id_pickup']) ?>">Cetak</a>
				<?php } ?>								
			</td>
		</tr>
		<tr><td colspan=7  id="pickup-detail-<?php echo $rec['id_pickup']?>" style="display:none;padding:20px"></td></tr>
		<?php endforeach;?>
	</tbody>
</table>
<script>
	
	function detail_sj(id_pickup){
		if($('#pickup-detail-'+id_pickup).html()==''){
			$.post('<?php echo base_url('pickup/detail_surat_jalan')?>',{id_pickup:id_pickup},function(data){
				$('#pickup-detail-'+id_pickup).html(data).slideToggle('fast');
				

			})
		}
		else
			$('#pickup-detail-'+id_pickup).slideToggle('fast');
	}
	$(function(){
		$('.action_popup').click(function(){
			$.post($(this).attr('page'),function(data){
				$('.modal-dialog').css('width','1185px');
				$('.modal-title').html('Verifikasi Surat Jalan Dan cetak');
				$('.te').html(data)
			})
		})

	})
</script>