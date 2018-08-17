<style type="text/css">
	@media print {
    	footer {page-break-after: always;}
    	  body {
        margin: 10px;
        padding: 10px;
        background-color: #FAFAFA;
        font: 12pt "Tahoma";
    }
    .label{
    	width:200px;
    }
     .breakhere {page-break-before: always}
      @page {
        size: A4;
        margin: 10;
    }
		
	}	
	 
</style>
<?php 
$salary = $this->load->module('payroll/salary');
foreach($result_karyawan as $rec){
if(empty($thp)){
		$id_kar=$rec['id_karyawan'];
		$thp='';
		$thp= $this->global_model->get_thp($id_kar,$bulan_payroll,$tahun_payroll);
	}
	?>
<table width="100%" class="table table-condensed">
	<thead>
		<tr class="danger"><th align="left">PADJADJARAN SUITE HOTEL</th><th align="right" style="text-align:right" class="alert">SLIP GAJI</th></tr>
	</thead>
	<tbody>
		<tr>
			<td class="label_">Kepada Yth</td>
			<td>: <b><?php echo $rec['nama_karyawan']?>(<?php echo $rec['nik']?>)</b></td>
		</tr>
		<tr>
			<td class="label_">Departemen</td>
			<td>: <b><?php echo $rec['nama_departemen']?></b></td>
		</tr>
		<tr>
			<td class="label_">Status Karyawan</td>
			<td>: <b><?php echo $rec['nama_tipe_karyawan']?></b></td>
		</tr>
		<tr>
			<td class="label_">Periode </td>
			<td>: <b><?php echo bulan(str_pad($bulan_payroll,2, "0", STR_PAD_LEFT)).'&nbsp; '.$tahun_payroll?></b></td>
		</tr>
	</tbody>
</table>
<hr>
<table class="table table-condensed">
	<tr>
		<td>PEMASUKAN
			<?php $salary::get_salary('TUNJANGAN',$rec['id_karyawan'],$bulan_payroll,$tahun_payroll);?>
		</td>
		<td>POTONGAN
			<?php $salary::get_salary('POTONGAN',$rec['id_karyawan'],$bulan_payroll,$tahun_payroll);?>
		</td>
	</tr>
	<?php $absensi= $salary::get_absensi($bulan_payroll,$tahun_payroll,$rec['id_karyawan'])?>
	<tr><td>Jumlah Hari Kerja (hari) : <?php echo $absensi['jumlah_hari_masuk'] ?> </td><td>Jumlah Lembur (hari): <?php echo $absensi['jumlah_lembur'] ?></td></tr>
	<tr class="danger"><td>Total Take Home Pay</td><td style="text-align:right" colspan="2"><b><?php echo number_format($thp) ?></b></td></tr>
	<tr><td colspan=4 text-align="center" class="danger"><b><i>(<?php echo  ucwords(terbilang($thp)).' Rupiah'?> )</i></b></td></tr>
	<tr><td colspan=2 class="danger">Catatan : Service sudah diterima pada tanggal</td></tr>
	<?php if((!isset($_GET['is_printed']))&&(!isset($all_print))) {?>
	<tr><td colspan="4"><a href="<?php echo base_url('payroll/salary/detail_payroll/?id_karyawan='.$rec['id_karyawan'].'&bulan='.$bulan_payroll.'&tahun='.$tahun_payroll.'&thp='.$thp.'&is_printed=yes') ?>" target="_blank" class="btn btn-primary">Cetak Slip Gaji</a></td></tr>
	<?php } 
	else{
	?>
	<script>
		window.print();
	</script>
	<?php }?>
</table>
<hr>
<div class="breakhere">&nbsp;</div>
<?php 
	unset($thp);
}
?>