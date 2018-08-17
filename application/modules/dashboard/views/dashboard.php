<!-- DASHBOARD -->
<div class="col-md-12">
<div class="box box-success">
    <?php $laporan= $this->load->module('laporan');
    		if(empty($bulan)) $bulan=date('m');
    		if(empty($tahun)) $tahun=date('Y');
    		$this->laporan->rekapitulasi_dashboard($bulan,$tahun);
    ?>
                            </div>
                            </div>
<!-- DASHBOARD KARYAWAN-->
<div class="col-md-12">
<h3 class="box-title"><i class="fa fa-user">&nbsp;</i>Jumlah Karyawan Berdasarkan Status</h3>
<div class="box box-success" style="float: left;padding: 5px;">&nbsp;

<?php foreach($result_karyawan_per_tipe as $karyawan){ ?>
<div class="col-lg-3 col-xs-6">

    <!-- small box -->
    <div class="small-box bg-green">
        <div class="inner">
            <h3>
                <?php echo $karyawan['jumlah']?>
            </h3>
            <p>&nbsp;</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="#" class="small-box-footer">
          <?php echo $karyawan['nama_tipe_karyawan']?>
        </a>
    </div>
    </div>
<!-- ./col -->
<?php } ?>
</div>
</div>
<div class="col-md-12">
<h3 class="box-title"><i class="fa fa-user">&nbsp;</i>Jumlah Karyawan Berdasarkan Departemen</h3>
<div class="box box-success" style="float: left;padding: 5px;">&nbsp;

<?php foreach($result_karyawan_per_departemen as $karyawan){ 

	?>
<div class="col-lg-3 col-xs-6">

    <!-- small box -->
    <div class="small-box bg-green">
        <div class="inner">
            <h3>
                <?php echo $karyawan['jumlah']?>
            </h3>
            <p>&nbsp;</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="#" class="small-box-footer">
          <?php echo $karyawan['nama_departemen']?>
        </a>
    </div>
    </div>
<!-- ./col -->
<?php } ?>
</div>
 </div>                   