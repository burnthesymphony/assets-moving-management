
<table class="table table-condensed ">
	<tr>
		<td>Departemen</td>
		<td><?php echo form_dropdown('id_departemen',$opt_departemen,'','class="form-control input'.$jenis.'" id="id_departemen_'.strtolower($jenis).'" style="width:250px"')?></td>
	</tr>
	<tr>
		<td>Status Karyawan</td>
		<td><?php echo form_dropdown('id_status_karyawan',$opt_tipe_karyawan,'','class="form-control input'.$jenis.'" id="id_status_karyawan_'.strtolower($jenis).'" style="width:250px"')?></td>
	</tr>
	<tr>
		<td>Nama Karyawan</td>
		<td id="karyawan_<?php echo strtolower($jenis) ?>"><?php echo form_dropdown('',array(),'','class="form-control input'.$jenis.'" id="nama_karyawan_'.strtolower($jenis).'" style="width:250px"')?></td>
	</tr>
	<tr>
		<td>Jenis <?php echo ucwords(strtolower($jenis))?></td>
		<td><?php echo form_dropdown('id_'.strtolower($jenis),$opt_komponen_gaji,'','id="id_'.strtolower($jenis).'" class="form-control input'.$jenis.'" style="width:250px"')?></td>
	</tr>
		<tr>
		<td>Jumlah <?php echo ucwords(strtolower($jenis))?></td>
		<td><?php echo ($jenis=='POTONGAN')?form_input($nominal_potongan):form_input($nominal_tunjangan)?></td>
	</tr>

		<tr>
		<td colspan=2>
			<input type="button" value="Masukan <?php echo ucwords(strtolower($jenis))?>"  class="btn  btn-success" onclick="masukan_<?php echo $jenis?>()"></td>
	</tr>
</table>
<div style="margin:20px 0px 20px 0px;" class="alert alert-success">
	<table class="table table-striped table-condensed " id="list_karyawan_<?php echo $jenis?>" style="display:none">
		<thead>
			<tr>
				<th>Nama Karyawan</th>
				<th>Departemen</th>
				<th>Jenis <?php echo strtolower($jenis) ?></th>
				<th>Jumlah</th>
				<th>action</th>
			</tr>
		</thead>
		<tbody id="isi_<?php echo strtolower($jenis)?>">
		</tbody>
	</table>
</div>

<script>
	$(function(){
		$('#id_departemen_<?php echo strtolower($jenis)?>').change(function(){
			get_cbo_karyawan_<?php echo $jenis?>();
		})

		$('#id_status_karyawan_<?php echo strtolower($jenis)?>').change(function(){
			get_cbo_karyawan_<?php echo $jenis?>();
		})

		
		function get_cbo_karyawan_<?php echo $jenis?>(){
			
			$.post('payroll/get_cbo_karyawan/',{id_departemen:$('#id_departemen_<?php echo strtolower($jenis)?>').val(),id_tipe_karyawan:$('#id_status_karyawan_<?php echo strtolower($jenis)?>').val(),jenis:'<?php echo $jenis ?>'},function(data){
				
					$('#karyawan_<?php echo strtolower($jenis)?>').html(data);
			})
		}
	})

	function masukan_<?php echo $jenis?>(){
	
		$('#list_karyawan_<?php echo $jenis?>').fadeIn();
		id_row= 'row_<?php echo $jenis.rand()?>';
		var isi_<?php echo $jenis?>='<tr id="'+id_row+'">'+
									 '<td><input type="hidden" name="id_karyawan_<?php echo strtolower($jenis)?>['+$('#id_karyawan_<?php echo strtolower($jenis)?>').val()+'][]" value="'+$('#id_karyawan_<?php echo strtolower($jenis)?>').val()+'">'+$('#id_karyawan_<?php echo strtolower($jenis)?> option:selected').text()+'</td>'+
									 '<td><input type="hidden" name="id_departemen_<?php echo strtolower($jenis)?>['+$('#id_karyawan_<?php echo strtolower($jenis)?>').val()+'][]" value="'+$('#id_departemen_<?php echo strtolower($jenis)?>').val()+'">'+$('#id_departemen_<?php echo strtolower($jenis)?> option:selected').text()+'</td>'+
									 '<td><input type="hidden" name="id_<?php echo strtolower($jenis)?>['+$('#id_karyawan_<?php echo strtolower($jenis)?>').val()+'][]" value="'+$('#id_<?php echo strtolower($jenis)?>').val()+'">'+$('#id_<?php echo strtolower($jenis)?> option:selected').text()+'</td>'+
									 '<td><input type="hidden" name="nominal<?php echo strtolower($jenis)?>['+$('#id_karyawan_<?php echo strtolower($jenis)?>').val()+'][]" value="'+$('#nominal_<?php echo strtolower($jenis)?>').val()+'">'+$('#nominal_<?php echo strtolower($jenis)?>').val()+'</td>'+
									 '<td><a href="javascript:;" onclick="$(\'#'+id_row+'\').remove()">hapus</a></td>'+
									 '</tr>';
		
		$('#isi_<?php echo strtolower($jenis)?>').append(isi_<?php echo $jenis?>);
		//$('.input<?php echo $jenis ?>').val('');
	}
</script>