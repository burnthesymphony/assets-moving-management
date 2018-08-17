  <?php  if(!(empty($parm['judul']))) echo '<h3 class="box-title">'.$parm['judul'].'</h3>'; ?>
  <?php if($parm['is_laporan']=='YA') 
  //  echo '<div align="right"><a  target="_blank" class="btn btn-primary" onclick="cetak_all_slip_gaji()">Export to excel</a></div>' ## nanti dibuka?>
  <table class="table table-condensed table-striped">
  	<thead>
  		<tr>
  			<th>No</th>
  			<th>NIK</th>
  			<th>Periode Gaji</th>
  			<th>Nama Karyawan</th>
  			<th>Departemen</th>
  			<th>Status Karyawan</th>
  			<th>Penerimaan (Rp)</th>
  			<th>Potongan (Rp)</th>
  			<th>Take Home Pay (Rp)</th>
			<th>Transfer</th>
  			<th>Action</th>
  		</tr>
  	</thead>
	<tbody>
		<?php 
		$i=1+$offset;
		foreach ($result as $rec) {  ?>
		<tr>
  			<td><?php echo $i?></td>
  			<td><?php echo $rec['nik']?></td>
  			<td><?php echo bulan(str_pad($rec['bulan'],2, "0", STR_PAD_LEFT)).'&nbsp; '.$rec['tahun'];?></td>
  			<td><?php echo $rec['nama_karyawan']?></td>
  			<td><?php echo $rec['nama_departemen']?></td>
  			<td><?php echo $rec['nama_tipe_karyawan']?></td>
  			<td><?php echo number_format($rec['tunjangan'])?></td>
  			<td><?php echo number_format($rec['potongan'])?></td>
  			<td><?php echo number_format($rec['tunjangan'] - $rec['potongan'] )?></td>
			<td><?php if($rec['jenis_pengiriman']=='TRANSFER')$checked="checked='checcked'"; else $checked=""?>
				<input type="checkbox" payroll_id=<?php echo $rec['id_payroll']?> class="jenis_pengiriman" name="jenis_pengiriman[]" value="<?php echo $rec['jenis_pengiriman']?>" id="" <?php echo $checked?>>
			
			</td>
  			<td><a data-toggle="modal" thp="<?php echo $rec['tunjangan'] - $rec['potongan'] ?>" bulan_payroll="<?php echo $rec['bulan']?>" tahun_payroll="<?php echo $rec['tahun']?>" id_karyawan="<?php echo $rec['id_karyawan'] ?>" data-target="#myModal" page="/psh/payroll/salary/detail_payroll/"   class="detail-payroll btn btn-default btn-sm">Detail</a></td>
  		</tr>
  		<?php $i++;} ?>
	</tbody>
</table>
<?php 
  
  if($parm['is_laporan']<>'YA') 
    echo '<a  target="_blank" class="btn btn-primary" onclick="cetak_all_slip_gaji()">Cetak Slip Gaji</a>';
?>


<?php echo $this->pagination->create_links(); ?>
<script src="<?php echo base_url('assets/js/jquery.js')?>"></script>
<script>
	$(document).ready(function() {
    
		$('.detail-payroll').click(function(){
			$.post('<?php echo base_url('payroll/salary/detail_payroll')?>',{id_karyawan:$(this).attr('id_karyawan'),bulan:$(this).attr('bulan_payroll'),tahun:$(this).attr('tahun_payroll'),thp:$(this).attr('thp')},function(data){
				$('.modal-title').html('Salary Detail');
				$('.te').html(data)
			})
		})	
		
});
	$(function(){
		$('.jenis_pengiriman').click(function(){
			if($(this).is(":checked")==true)
				jenis_pengiriman='TRANSFER';
			else
				jenis_pengiriman='CASH';
			$.post('<?php echo base_url('payroll/salary/change_pengiriman')?>',{jenis_pengiriman:jenis_pengiriman,payroll_id:$(this).attr('payroll_id')},
				function(data){
				}
					
				)
			})
	})

  function cetak_all_slip_gaji(){
    if(($('#tahun').val()=='') ||($('#bulan').val()=='')){
        alert('Tahun dan bulan tidak boleh kosong');
        return false;
    }
    else{
      if($('#id_departemen').val()=='')
        id_departemen='all';
      else
        id_departemen=$('#id_departemen').val();
      if($('#id_tipe_karyawan').val()=='')
        id_tipe_karyawan='all';
      else
        id_tipe_karyawan=$('#id_tipe_karyawan').val();
      if($('#id_karyawan').val()=='')
        id_karyawan='all';
      else
        id_karyawan=$('#id_karyawan').val();
      var url_="<?php echo base_url('payroll/salary/cetak_slip_gaji/')?>/tahun/"+$('#tahun').val()+"/bulan/"+$('#bulan').val()+'/id_departemen/'+id_departemen+'/id_tipe_karyawan/'+id_tipe_karyawan+'/id_karyawan/'+id_karyawan;
      window.open(url_,"width=800, height=600 _blank");
    }
  }
	</script>
  <script>
  /*PAGINATION MENJADI AJAX*/
  
  $(function(){
     id_departemen="<?php echo $parm['id_departemen'] ?>";
     judul="<?php echo $parm['judul'] ?>";
     $.each($('.pagination li a'), function() { 
          if($(this).attr('href')){
            href_    = $(this).attr('href')
            href_arr = href_.split('/');
            length_  = href_arr.length;
            index_ofset= parseInt(length_) -1;
            offset   = href_arr[index_ofset];
            $(this).attr('href','javascript:;');
            $(this).attr('onclick',"submit_sallary('"+href_+"','"+id_departemen+"','"+judul+"')");
          }
          
          //$(this).hide()  ;
    });
     $('#favourites_btn').click(function(){
      
      $('#favourites_').slideToggle('fast')
     })
  })
  /*PAGINATION MENJADI AJAX*/
  </script>