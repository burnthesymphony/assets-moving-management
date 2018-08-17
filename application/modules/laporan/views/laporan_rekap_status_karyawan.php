<?php if($is_xls=='YA'){
	echo '<table>
			<tr><td><h1>Laporan Rekapitulasi Berdasarkan Status Karyawan Periode '.bulan(str_pad($bulan,2, "0", STR_PAD_LEFT)).' '.$tahun.'</h1></td></tr>

		 </table>';
} ?>
<div  style="padding:0px 18px 2px 18px">
<h2>Total Earnings</h2>
<table class="table table-striped table-condensed table-bordered" border=1>

		<thead>
		<tr>
			<th rowspan="2" style="vertical-align:middle;text-align:center">No</th>
			<th rowspan="2" style="vertical-align:middle;text-align:center">Status Karyawan</th>
			<th colspan="<?php echo count($rekap_tunjangan['fields'] )?>" style="vertical-align:middle;text-align:center"><h4>Earnings</h4></th></tr>
		<tr>

			
			<?php 	$i=1;
					foreach($rekap_tunjangan['fields'] as $f) {
					if($i>1)
						echo '<th align="center" style="text-align:center">'.ucwords(str_replace('_', ' ', $f)).'</th>';
					$i++;
					}?>
		</tr>
		</thead>
		<tbody>
<?php 
$no=1 + $offset;
				foreach($rekap_tunjangan['result'] as $rec_){

					echo '<tr><td>'.$no.'</td>';
						foreach($rekap_tunjangan['fields'] as $f) {
							if(is_numeric($rec_[trim($f)]))
								echo '<td align="right">'.number_format($rec_[trim($f)]).'</td>'				;
							else
							echo '<td>'.$rec_[trim($f)].'</td>'				;
						}
					echo '</tr>'	;	
				$no++;
				}
?>
</tbody>
	</table>
	</div>
<div style="padding:0px 18px 2px 18px">
<h2>Total Deduction</h2>
<table class="table table-striped table-condensed table-bordered" border=1>

		<thead>
		<tr>
			<th rowspan="2" style="vertical-align:middle;text-align:center">No</th>
			<th rowspan="2" style="vertical-align:middle;text-align:center">Nama Departemen</th>
			<th colspan="<?php echo count($rekap_potongan['fields'] )?>" style="vertical-align:middle;text-align:center"><h4>Deduction</h4></th></tr>
		<tr>

			
			<?php 	$i=1;
					foreach($rekap_potongan['fields'] as $f) {
					if($i>1)
						echo '<th align="center" style="text-align:center">'.ucwords(str_replace('_', ' ', $f)).'</th>';
					$i++;
					}?>
		</tr>
		</thead>
		<tbody>
<?php 
$no=1 + $offset;
				foreach($rekap_potongan['result'] as $rec_){

					echo '<tr><td>'.$no.'</td>';
						foreach($rekap_potongan['fields'] as $f) {
							if(is_numeric($rec_[trim($f)]))
								echo '<td align="right">'.number_format($rec_[trim($f)]).'</td>'				;
							else
							echo '<td>'.$rec_[trim($f)].'</td>'				;
						}
					echo '</tr>'	;	
				$no++;
				}
?>
</tbody>
	</table>
	</div>
	

<?php 
	if($is_xls=='YA'){
		$file="REKAP-STATUS-KARYAWAN-".bulan(str_pad($bulan,2, "0", STR_PAD_LEFT)).' '.$tahun.".xls";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
	}
	else{ ?>
		<a value="export xls" class="btn btn-primary" href="<?php echo base_url('laporan/rekap_status_karyawan_xls/'.$bulan.'/'.$tahun.'/'.$nama_komponen_gaji) ?>" target="_blank" >Eksport XLS</a>		
	<?php } ?>