<?php $laporan= $this->load->module('laporan')?>
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
<br>
<!-- NANTI DIBUKA <table width="100%"><tr><td align="right" colspan=6><a class="btn btn-primary" href=""> Export to excel</a></td></tr></table><br> -->
<table class="table table-striped table-bordered table-condensed">
	<thead>
		
	<tr>
		<th>#</th>
		<th>Nama Departemen</th>
		<th>Jumlah Penerimaan (Rp)</th>
		<th>Jumlah Potongan (Rp)</th>
		<th>Take Home Pay (Rp)</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
		<?php
		$i=1;
		foreach($result as $rec){
			$tunjangan 			= $laporan::get_salary(array('jenis'=>'TUNJANGAN','c.id_departemen'=>$rec['id_departemen'],'b.bulan'=>$bulan_payroll,'b.tahun'=>$tahun_payroll));
			$potongan 			= $laporan::get_salary(array('jenis'=>'POTONGAN','c.id_departemen'=>$rec['id_departemen'],'b.bulan'=>$bulan_payroll,'b.tahun'=>$tahun_payroll));
			$thp 				= $tunjangan- $potongan;
			$total_tunjangan 	= $total_tunjangan + $tunjangan;
			$total_potongan 	= $total_potongan + $potongan;
			$total_thp 			= $total_thp + $thp;
		?>
		<tr>
			<td><?php echo $i ?></td>
			<td><?php echo $rec['nama_departemen']?></td>
			<td align="right"><?php echo number_format($tunjangan)?></td>
			<td align="right"><?php echo number_format($potongan)?></td>
			<td align="right"><?php echo number_format($thp)?></td>
			<td align="center"><a class="btn btn-default" onclick="lihat_detail(<?php echo $rec['id_departemen']?>,'Detail Salary Departemen <?php echo $rec['nama_departemen']?>')">Detail</a></td>


		</tr>
		<?php $i++; }?>
		<tr>
			<td colspan=2><h4>Jumlah</h4></td>
			<td align="right"><?php echo number_format($total_tunjangan) ?></td>
			<td align="right"><?php echo number_format($total_potongan) ?></td>
			<td align="right"><?php echo number_format($total_thp) ?></td>
			<td></td>
		</tr>

	</tbody>
</table>
<div id="detail_sallary" class="box box-danger"></div>
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
				location.href="<?php echo base_url('dashboard/index')?>/"+$('#bulan_payroll').val()+'/'+$('#tahun').val()
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