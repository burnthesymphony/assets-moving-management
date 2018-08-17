<table class="table table-striped">
	<thead>
		<tr>
			<th>No</th>
			<th>NIK</th>
			<th>Nama Karyawan</th>
			<th>Status Karyawan</th>
			<th>Departemen</th>
			<th>Jumlah Hari Kerja</th>
			<th>Jumlah Lembur</th>
		</tr>
	</thead>
	<tbody>
		
		<?php $i=1;foreach($result_dw_casual as $rec_dw){?>
		<tr>
			<td><?php echo $i ?></td>
			<td><?php echo $rec_dw['nik']?></td>
			<td><?php echo $rec_dw['nama_karyawan']?></td>
			<td><?php echo $rec_dw['nama_tipe_karyawan']?></td>
			<td><?php echo $rec_dw['nama_departemen'] ?></td>
			<td align="center"><input type="text" class="form-control" style="width:50px" name="jumlah_hari_masuk[<?php echo $rec_dw['id_karyawan'] ?>]" value=""></td>
			<td align="center"> <input type="text" class="form-control" style="width:50px" name="jumlah_lembur[<?php echo $rec_dw['id_karyawan'] ?>]" value=""></td>
		</tr>
		<?php $i++;} ?>
	</tbody>

</table>