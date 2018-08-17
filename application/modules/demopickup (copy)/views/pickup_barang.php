<form id="frm-header-pickup">
<table class="table table-condensed table-striped">
	<tr><td>Gudang Asal</td><td><?php  echo form_dropdown('id_inventory_from',$opt_inventory,'','class="form-control"')?></td></tr>
	<tr><td>Gudang Tujuan</td><td><?php  echo form_dropdown('id_inventory_to',$opt_inventory,'','class="form-control"')?></td></tr>
	<tr><td>Nomor Kendaraan</td><td><?php  echo form_input($frm_nomor_kendaraan)?></td></tr>
	<tr><td>Nama Sopir</td><td><?php  echo form_input($frm_nama_supir)?></td></tr>
</table>
</form>
<form id="frm-scan" action="javascript:void(0);return false">
<table class="table table-condensed table-striped">
<tbody>
	<tr>
		<td>
			<h1 style="text-align:center">Scan Barcode Here:</h1>
			<?php echo form_input($frm_barcode)?><br><br>
		</td>
	</tr>

</tbody>
</table>
</form>
<div style="clear:both">&nbsp;</div>

<form id="frm-detail-pickup">
<table class="table table-condensed table-striped">
	<thead>
		<tr>
			<th>Nama Barang</th>
			<th>Deskripsi</th>
			<th>Jumlah</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody id="detail_pickup"></tbody>
</table>
</form>
<div><input type="button" name="btn_surat_jalan" id="btn_surat_jalan" class="btn btn-primary" value="SELESAI DAN CETAK SURAT JALAN"></div>


<script>
	$(function(){
		$('#barcode').focus();
		$('#frm-scan').submit(function(){
			
			if($('#barcode_list_'+$('#barcode').val()).size()> 0){
				current_qty 	= parseInt($('#qty_'+$('#barcode').val()).val());
				new_qty 		= current_qty + 1;
				$('#qty_'+$('#barcode').val()).val(new_qty);


			}
			else{
				$.post("<?php echo base_url('demopickup/detail_pickup/')?>",$('#frm-scan').serialize(),function(data){
					$('#detail_pickup').prepend(data);
					
				})
			}
			$('#barcode').val('');		
		})
		
		$('#btn_surat_jalan').click(function(){
			parm_= $('#frm-header-pickup').serialize()+'&'+$('#frm-detail-pickup').serialize();
			
			$.post("<?php echo base_url('demopickup/submit_pickup/')?>",parm_,function(data){
					alert('SURAT JALAN BERHASIL DI BUAT \n UNTUK VERSI DEMO ANDA TIDAK DIPERKENENAKAN MENCETAK SURAT JALAN');
					
			})
			
		})
	})
</script>