<?php $laporan= $this->load->module('laporan')?>
<form id="frm_laporan" onsubmit="javascript:return false"> 
<table class="">
	<tr>
		<td colspan=4><h3>Periode Gaji</h3></td>
	</tr>
	<tr>
		
		<td><?php echo form_dropdown('bulan',$opt_bulan_payroll,$bulan_payroll,'id="bulan_payroll" class="form-control" style="width:200px" ')?></td>
		<td><?php echo form_input($tahun)?></td>
		<td><a href="javascript:;" id="btn_rekap_tahun" class="btn btn-primary">Submit</a></td>
		
	</tr>
</table>
</form>
<br>
<!-- NANTI DIBUKA <table width="100%"><tr><td align="right" colspan=6><a class="btn btn-primary" href=""> Export to excel</a></td></tr></table><br> -->

<div id="detail_sallary" class="box box-danger" style="padding:10px"><i>No data</i></div>
<script src="<?php echo base_url('assets/js/jquery.js')?>"></script>
<script>
	$(function(){
		$('#btn_rekap_tahun').click(function(){
			if($('#bulan_payroll').val()==''){
				alert('SILAHKAN  PILIH BULAN PAYROLL');
				return false;
			}
			else if($('#tahun').val()==''){
				alert('SILAHKAN  MASUKAN TAHUN');
				return false;
			}
			else{
				$.post('<?php echo base_url($url_cari)?>',$('#frm_laporan').serialize(),function(data){
					$('#detail_sallary').html(data);
				})
			}
		})
	})
	function lihat_detail(id_departemen,judul){
		$.post('<?php echo base_url("payroll/salary/list_") ?>',
				{id_departemen:id_departemen,tahun:'<?php echo $tahun_payroll ?>',bulan:'<?php echo $bulan_payroll ?>',judul:judul,is_laporan:'YA'},
			function(data){
				$('#detail_sallary').html(data);
			})
	}
	function submit_sallary(url,id_departemen,judul){
		
		$.post(url,{id_departemen:id_departemen,tahun:'<?php echo $tahun_payroll ?>',bulan:'<?php echo $bulan_payroll ?>',judul:judul,is_laporan:'YA'},function(data){
					$('#detail_sallary').html(data);
			})
	}
</script>