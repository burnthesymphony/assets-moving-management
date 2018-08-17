<form id="frm_cari_salary">
<table class="table table table-condensed">
	<tr>
		<td>Periode Gaji</td>
		<td class="form-inline"><?php echo form_dropdown('bulan',$opt_bulan_payroll,'',' id="bulan" class="form-control" style="width:200px" ')?>&nbsp;&nbsp; Tahun &nbsp;<?php echo form_input($tahun) ?></td>
	</tr>
	<tr>
		<td>Departemen</td>
		<td><?php echo form_dropdown('id_departemen',$opt_departemen,'','id="id_departemen" class="form-control" style="width:200px" ')?></td>
	</tr>
	<tr>
		<td>Status Karyawan</td>
		<td><?php echo form_dropdown('id_tipe_karyawan',$opt_tipe_karyawan,'','id="id_tipe_karyawan" class="form-control" style="width:200px" ')?></td>
	</tr>
	<tr>
		<td>Nama  Karyawan</td>
		<td id="karyawan_place"><?php echo form_dropdown('id_karyawan',array('all'=>'Semua Karyawan'),'','id="id_karyawan" class="form-control" style="width:200px" ')?></td>
	</tr>
	<tr>
		<td colspan=2><input type="submit" name="submit_" value="Search" class="btn btn-default"></td>
	</tr>
</table>
</form>
<div id="list_salary">&nbsp;</div>
<script>
	$(function(){
		$('#frm_cari_salary').submit(function(){
			submit_sallary("<?php echo base_url('payroll/salary/list_')?>")
			return false;
		})
		$('#id_departemen').change(function(){
			get_cbo_karyawan();
		})
		$('#id_tipe_karyawan').change(function(){
			get_cbo_karyawan();
		})
	})
	function get_cbo_karyawan(){
			$.post('../get_cbo_karyawan/',{id_departemen:$('#id_departemen').val(),id_tipe_karyawan:$('#id_tipe_karyawan').val()},function(data){
					$('#karyawan_place').html(data);
			})
	}
	function submit_sallary(url){
		$.post(url,$('#frm_cari_salary').serialize(),function(data){
					$('#list_salary').html(data);
			})
	}
</script>