<table class="table table-condensed">
	<thead>
		<tr align="center">
			<th style="text-align:center">Nama Perusahaan</th> 
			<th style="text-align:center">Alamat Perusahaan</th> 
			<th style="text-align:center">Posisi</th>
			<th style="text-align:center">Masa Kerja</th>
			<th style="text-align:center">Alasan Berhenti</th>
			<th style="text-align:center">No telepon Referensi </th>
		</tr>
	</thead>
	<tbody id="list_pengalaman">
		<?php if(!empty($selected_pengalaman_kerja)){ 
				foreach($selected_pengalaman_kerja as $pengalaman){
			?>
				<script>
				$(function(){
					$.post("<?php echo base_url('master/frm_tambah_pengalaman')?>",{selected:'<?php echo json_encode($pengalaman)?>'},function(data){
					$('#list_pengalaman').append(data);
					$( ".datepicker" ).datepicker({
            			changeMonth: true,
            			changeYear: true,
            			dateFormat: 'yy-mm-dd' 
        			});
				$( ".datepicker" ).datepicker();
					})	
				})
				
				</script>

		<?php 
				}
			}else{?>
			<tr>
				<td><?php echo form_input($frm_nama_perusahaan)?></td>
				<td><?php echo form_textarea($frm_alamat_kerja)?></td>
				<td><?php echo form_input($frm_position)?></td>
				<td><?php echo form_input($frm_mulai_kerja)?> - <?php echo form_input($frm_akhir_kerja)?>  </td>
				<td><?php echo form_textarea($frm_reason_to_leave)?></td>
				<td><?php echo form_input($frm_contact_number)?> </td>
			</tr>
			<?php } ?>
	</tbody>
</table>
<a class="btn btn-small btn-primary" id="tambah_pengalaman">Tambah Riwayat Pendidikan</a>
<script>
	$(function(){
		$('#tambah_pengalaman').click(function(){
			$.post("<?php echo base_url('master/frm_tambah_pengalaman')?>",function(data){
				$('#list_pengalaman').append(data);
				  $( ".datepicker" ).datepicker({
            			changeMonth: true,
            			changeYear: true,
            			dateFormat: 'yy-mm-dd' 
        			});
				$( ".datepicker" ).datepicker();
			})
		})
	})
</script>