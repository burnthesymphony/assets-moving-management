 <form id="frm_payroll">
 <table class="table ">
	<tbody>
		<tr><td>Tahun</td><td><?php echo form_input($tahun)?></td></tr>
		<tr><td>Bulan</td><td><?php echo form_dropdown('bulan',$opt_bulan_payroll,'','class="form-control" style="width:200px" ')?></td></tr>
		<tr><td>Service (Rp)</td><td><?php echo form_input($frm_service)?></td></tr>
	</tbody>
</table>
<div class="absensi-tunjangan">
	<ul class="nav nav-tabs">
	  <li class="active" ><a href="#absensi_dw" data-toggle="tab">Absensi DW and Casual</a></li>
	  <li><a href="#tunjangan" data-toggle="tab">Tunjangan</a></li>
	  <li><a href="#potongan" data-toggle="tab">Potongan</a></li>
	</ul>

	<!-- Tab panes -->
	
	<div class="tab-content highlight">
	  <div class="tab-pane fade active in highlight" id="absensi_dw"> <?php echo  $view_absensi_dw?></div>
	  <div class="tab-pane fade highlight" id="tunjangan">            <?php echo  $view_tunjangan?> </div> 
	  <div class="tab-pane fade highlight" id="potongan">             <?php echo  $view_potongan?>	</div>   
	</div>
	</form>
</div>

<div><input type="button" name="btn_proses_payroll" value="Proses Payroll" class="btn btn-large btn-primary" onclick="proses_payroll()"> </div>
<div id="hasil_penggajian"></div>
<script>
	function proses_payroll(){
		$('#hasil_penggajian').html('<img  src="<?php echo base_url('assets/img/ajax-loader.gif')?>">');
		$.post('payroll/proses_penggajian',$('#frm_payroll').serialize(),function(data){
			$('#hasil_penggajian').html(data);
			location.href="<?php echo base_url('payroll/salary/list_salary')?>";
		});
	}

</script>