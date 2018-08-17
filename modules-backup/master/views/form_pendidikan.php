<table class="table table-condensed">
	<thead>
		<tr align="center"><th style="text-align:center">Nama Instansi Pendidikan</th> <th style="text-align:center">Tingkat</th> <th style="text-align:center">Tahun</th><th style="text-align:center">Jenis</th></tr>
	</thead>
	<tbody id="list_data_pendidikan">
		<?php if(!empty($selected_pendidikan)){ 
				foreach($selected_pendidikan as $pendidikan){
			?>
				<script>
				$(function(){
					$.post("<?php echo base_url('master/frm_tambah_pendidikan')?>",{selected:'<?php echo json_encode($pendidikan)?>'},function(data){
					$('#list_data_pendidikan').append(data);
					})	
				})
				
				</script>

		<?php 
				}
			}else{?>
		<tr>
		<tr>
			<td><?php echo form_input($frm_nama_instansi_pendidikan)?></td>
			<td><?php echo form_dropdown('tingkat[]',$opt_tingkat,'','class="form-control"')?></td>
			<td><?php echo form_input($frm_tahun)?></td>
			<td><?php echo form_dropdown('jenis[]',$opt_jenis,'','class="form-control"')?></td>
		</tr>
		<?php }?>
	</tbody>
	
</table>
<a class="btn btn-small btn-primary" id="tambah_pendidikan">Tambah Riwayat Pendidikan</a>
<script>
	$(function(){
		$('#tambah_pendidikan').click(function(){
			$.post("<?php echo base_url('master/frm_tambah_pendidikan')?>",function(data){
				$('#list_data_pendidikan').append(data);
			})
		})
	})
</script>