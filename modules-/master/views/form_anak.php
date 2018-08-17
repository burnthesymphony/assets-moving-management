<table class="table table-condensed">
	<thead>
		<tr align="center"><th style="text-align:center">Nama Anak</th> <th style="width:150px;text-align:center">Umur</th> <th style="text-align:center">Pendidikan</th></tr>
	</thead>
	<tbody id="list_data_anak">
		<?php if(!empty($selected_anak)){ 
				foreach($selected_anak as $anak){
			?>
				<script>
				$(function(){
					$.post("<?php echo base_url('master/frm_tambah_anak')?>",{selected:'<?php echo json_encode($anak)?>'},function(data){
					$('#list_data_anak').append(data);
					})	
				})
				
				</script>

		<?php 
				}
			}else{?>
		<tr>
			<td><?php echo form_input($frm_nama_anak)?></td>
			<td><?php echo form_input($frm_umur)?></td>
			<td><?php echo form_dropdown('pendidikan[]',$opt_pendidikan,'','class="form-control"')?></td>
		</tr>
		<?php } ?>
	</tbody>
	
</table>
<a class="btn btn-small btn-primary" id="tambah_data_anak">Tambah Data Anak</a>
<script>
	$(function(){
		$('#tambah_data_anak').click(function(){
			$.post("<?php echo base_url('master/frm_tambah_anak')?>",function(data){
				$('#list_data_anak').append(data);
			})
		})
	})
</script>