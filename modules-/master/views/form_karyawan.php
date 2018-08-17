	<ul class="nav nav-tabs">
	  <li class="active" ><a href="#personal" data-toggle="tab">Data Personal</a></li>
	  <li><a href="#anak" data-toggle="tab">Data Anak</a></li>
	  <li><a href="#pendidikan" data-toggle="tab">Pendidikan</a></li>
	  <li><a href="#pengalaman_kerja" data-toggle="tab">Pengalaman Kerja</a></li>
	</ul>

	<!-- Tab panes -->
	<form action="<?php echo base_url('master/insert_data_karyawan')?>" id="frm_karyawan" method="POST">
	<div class="tab-content highlight">
	  <div class="tab-pane fade active in highlight" id="personal"><?php echo $form_personal?></div>
	  <div class="tab-pane fade highlight" id="anak"><?php echo $form_anak ?></div> 
	  <div class="tab-pane fade highlight" id="pendidikan"><?php echo $form_pendidikan?></div>   
	  <div class="tab-pane fade highlight" id="pengalaman_kerja"><?php echo $form_pengalaman?></div>   
	</div>
	<?php if($action<>'view'){?>
	<hr>
	<div style="margin-top:20px;width:100%"><input type="submit" style="width:100%" name="btn-submit" class="btn  btn-success" value="Simpan"></div>
	<?php } ?>
</form>