<table class="table table-condensed table-striped">
	<thead>
		<tr>
			<th>Nomor Surat Jalan</th>
			<th>Tempat asal</th>
			<th>Tempat Tujuan</th>
			<th>Nomor Kendaraan</th>
			<th>Nama Supir</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($result as $rec):?>
		<tr>
			<td><?php echo $rec['permit_number']?></td>
			<td><?php echo $rec['inventory_from']?></td>
			<td><?php echo $rec['inventory_to']?></td>
			<td><?php echo $rec['car_number']?></td>
			<td><?php echo $rec['drivername']?></td>
			<td><a class="btn btn-small btn-primary" onclick="detail_sj(<?php echo $rec['id_pickup']?>)">Lihat Detail</a></td>
		</tr>
		<tr><td colspan=6  id="pickup-detail-<?php echo $rec['id_pickup']?>" style="display:none;padding:20px"></td></tr>
		<?php endforeach;?>
	</tbody>
</table>
<script>
	
	function detail_sj(id_pickup){
		if($('#pickup-detail-'+id_pickup).html()==''){
			$.post('<?php echo base_url('demopickup/detail_surat_jalan')?>',{id_pickup:id_pickup},function(data){
				$('#pickup-detail-'+id_pickup).html(data).slideToggle();
				

			})
		}
		else
			$('#pickup-detail-'+id_pickup).slideToggle();
	}
</script>