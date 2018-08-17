
<table class="table table-condensed">
	<tr>
		<td>Nik<input type="hidden" name="id_karyawan" id="id_karyawan" value="<?php echo $selected['id_karyawan']?>"></td>
		<td><?php echo form_input($frm_nik)?></td>
	</tr>
	<tr>
		<td>Nama</td>
		<td><?php echo form_input($frm_nama_karyawan)?></td>
	</tr>	
	<tr>
		<td>Tempat Tanggal Lahir</td>
		<td>
			<div style="width:220px;float:left">
			<?php echo form_dropdown('id_propinsi_lahir',$opt_propinsi_lahir,$selected['id_propinsi_lahir'],'class="form-control" style="width:200px" id="id_propinsi_lahir"')?>
			</div>
			<div style="width:220px;float:left" id="kota_lahir"></div>
			<div style="width:220px;float:left" id="kota_lahir"><?php echo form_input($frm_tanggal_lahir)?></div>
		</td>
	<tr>
		<td>Jenis Kelamin</td>
		<td><?php echo form_dropdown('jenis_kelamin',$opt_jenis_kelamin,'','class="form-control" style="width:200px" id="jenis_kelamin"')?></td>
	</tr>
	<tr>
		<td>Agama</td>
		<td><?php echo form_dropdown('agama',$opt_agama,'','class="form-control" style="width:200px" id="agama"')?></td>
	</tr>
	<tr>
		<td>Golongan Darah</td>
		<td><?php echo form_dropdown('golongan_darah',$opt_golongan_darah,'','class="form-control" style="width:200px" id="golongan_darah"')?></td>
	</tr>
	<tr>
		<td>Alamat</td>
		<td><div style="width:220px;float:left">
			<?php echo form_dropdown('id_propinsi',$opt_propinsi,$selected['id_propinsi'],'class="form-control" style="width:200px" id="id_propinsi"')?>
			</div>
			<div style="width:220px;float:left" id="kota_"></div><br>
			<div><br>
			<?php echo form_textarea($frm_alamat)?>
			</div>
		</td>
	</tr>
	<tr>
		<td>Status Pernikahan</td>
		<td><?php echo form_dropdown('status',$opt_status,$selected['status'],'class="form-control" style="width:200px" id="status"')?></td>
	</tr>
	<tr>
		<td>Nama Pasangan</td>
		<td><?php echo form_input($frm_nama_pasangan)?></td>
	</tr>
	<tr>
		<td>Telepon Pasangan</td>
		<td><?php echo form_input($frm_telepon_pasangan)?></td>
	</tr>
	<tr>
		<td>Nama Ayah</td>
		<td><?php echo form_input($frm_nama_ayah)?></td>
	</tr>
	<tr>
		<td>Nama Ibu</td>
		<td><?php echo form_input($frm_nama_ibu)?></td>

	</tr>
	<tr>
		<td>Telepon Emergency</td>
		<td><?php echo form_input($frm_telepon_emergency)?></td>
	</tr>
	<tr>
		<td>Bahasa Asing dikuasai </td>
		<td><?php 
				$arr_asing= explode(',', $selected['bahasa_asing']) ;
				foreach($opt_bahasa_asing as $bahasa){
					if(in_array($bahasa, $arr_asing)) 
						echo form_checkbox(array('name'=>'bahasa_asing[]','class'=>'form-control','value'=>$bahasa,'checked'=>'checked')).' &nbsp;'.$bahasa .'&nbsp;';
					else
					echo form_checkbox(array('name'=>'bahasa_asing[]','class'=>'form-control','value'=>$bahasa)).' &nbsp;'.$bahasa .'&nbsp;';
				  }?></td>
	</tr>
	<tr>
		<td>Pendidikan Terakhir</td>
		<td><?php echo form_dropdown('pendidikan_terakhir',$opt_pendidikan_terakhir,$selected['pendidikan_terakhir'],'class="form-control" style="width:200px" id="pendidikan_terakhir"')?></td>
	</tr>
	<tr>
		<td>Pengalaman  Berorganisasi</td>
		<td><?php echo form_textarea($frm_pengalaman_berorganisasi)?></td>
	</tr>
	<tr>
		<td>Nomor telepon</td>
		<td><?php echo form_input($frm_nomor_telepon)?></td>
	</tr>
	<tr>
		<td>HP</td>
		<td><?php echo form_input($frm_hp)?></td>
	</tr>
	<tr>
		<td>Departemen</td>
		<td><?php echo form_dropdown('id_departemen',$opt_departemen,$selected['id_departemen'],'class="form-control" style="width:200px" id="id_departemen"')?></td>
	</tr>
	<tr>
		<td>Jabatan</td>
		<td ><span id="place_jabatan"><?php echo form_dropdown()?></span></td>
	</tr>
	<tr>
		<td>Level Karyawan</td>
		<td ><?php echo form_dropdown('id_level_karyawan',$opt_level_karyawan,$selected['id_level_karyawan'],'class="form-control" style="width:200px" id="id_level_karyawan"')?></td>
	</tr>
	<tr>
		<td>Tipe Karyawan</td>
		<td><?php echo form_dropdown('id_tipe_karyawan',$opt_tipe_karyawan,$selected['id_tipe_karyawan'],'class="form-control" style="width:200px" id="id_tipe_karyawan"')?></td>
	</tr>
	<tr>
		<td>Hobi</td>
		<td><?php echo form_textarea($frm_hobi)?></td>
	</tr>  
	<tr>
		<td>Nama Bank</td>
		<td><?php echo form_dropdown('id_bank',$opt_bank,$selected['id_bank'],'class="form-control" style="width:200px" id="id_bank"')?></td>
	</tr>
	<tr>
		<td>Cabang Bank</td>
		<td><?php echo form_input($frm_cabang_bank)?></td>
	</tr>
	<tr>
		<td>Nomor Rekening</td>
		<td><?php echo form_input($frm_nomor_rekening)?></td>
	</tr>
	<tr>
		<td>Gaji Pokok</td>
		<td><?php echo form_input($frm_gaji_pokok)?></td>
	</tr>
	<tr>
		<td>Tanggal Join</td>
		<td><?php echo form_input($frm_tanggal_join)?></td>
	</tr>


</table>
<?php 
	if(!empty($selected['id_propinsi_lahir'])):
	?>
		<script>
			$(function(){
				$.post("<?php echo base_url('master/get_kabupaten_kota_dropdown/id_kota_lahir/'.$selected['id_kota_lahir']) ?>",
					{id_propinsi:"<?php echo $selected['id_propinsi_lahir']?>"},function(data){
					$('#kota_lahir').html(data);
				})	
			})
		</script>
	<?php
	endif;
	if(!empty($selected['id_propinsi'])):
	?>
		<script>
			$(function(){
				$.post("<?php echo base_url('master/get_kabupaten_kota_dropdown/id_kabupaten/'.$selected['id_kabupaten_kota']) ?>",
					{id_propinsi:"<?php echo $selected['id_propinsi']?>"},function(data){
					$('#kota_').html(data);
				})	
			})
		</script>
	<?php
	endif;
if(!empty($selected['id_jabatan'])):
	?>
		<script>
			$(function(){
				$.post("<?php echo base_url('master/get_jabatan_dropdown/'.$selected['id_jabatan']) ?>",
					{id_departemen:"<?php echo $selected['id_departemen']?>"},function(data){
					$('#place_jabatan').html(data);
				})	
			})
		</script>
	<?php
	endif;		
?>
<script>
	$(function(){
		$('#id_propinsi_lahir').change(function(){
			$.post("<?php echo base_url('master/get_kabupaten_kota_dropdown/id_kota_lahir') ?>",{id_propinsi:$(this).val()},function(data){
				$('#kota_lahir').html(data);
			})
		})
		$('#id_propinsi').change(function(){
			$.post("<?php echo base_url('master/get_kabupaten_kota_dropdown/id_kabupaten') ?>",{id_propinsi:$(this).val()},function(data){
				
				$('#kota_').html(data);
			})
		})
		$('#id_departemen').change(function(){
			$.post("<?php echo base_url('master/get_jabatan_dropdown/') ?>",{id_departemen:$(this).val()},function(data){
				
				$('#place_jabatan').html(data);
			})
		})
	})
</script>