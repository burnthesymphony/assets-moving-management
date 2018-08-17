<div class="col-md-6">
	<div class="box box-solid profil_saya">
 		<img src="<?php echo  base_url('files/images/user/'.$profile['foto'])?>" width="100%">
 	</div>
</div>
<div class="col-md-6">
	<div class="box box-solid profil_saya">
		<h1 class="page-header">Profil Lengkap</h1>
 		<dl class="dl-horizontal">
            <dt>Nama Lengkap</dt>
            	<dd><?php echo $profile['fullname'] ?></dd>
            <dt>Email</dt>
            	<dd><?php echo $profile['email'] ?></dd>
            	
            <dt>Username</dt>
            	<dd><?php echo $profile['username'] ?></dd>
            <dt>Biographical Info </dt>
            	<dd><?php echo $profile['biographical']?></dd>
        </dl>
 	</div>
 	
</div>
<div class="col-md-6 box box-solid">

<div align="right"><h1 class="page-header" >Artikel</h1></div>
	<div>
		<ul class="timeline">
			<?php foreach ($result_artikel as $rec_artikel){?>
		    <!-- timeline time label -->
		    <li class="time-label">
		        <span class="bg-red">
		           <?php echo hari_tanggalindo($rec_artikel['date']) ?>
		        </span>
		    </li>
		    <!-- /.timeline-label -->
		    <!-- timeline item -->
		    <li>
		        <i class="fa fa-envelope bg-blue"></i>
		        <div class="timeline-item">
		            <span class="time"><i class="fa fa-eye"></i> <?php echo $rec_artikel['views']?></span>
		            <h3 class="timeline-header"><a href="#"><?php echo $rec_artikel['title']?></a> </h3>
		            <div class="timeline-body">
		                <?php echo excerpt($rec_artikel['content'],60) ?>
		            </div>
		            <div class="timeline-footer">
		                <a class="btn btn-primary btn-xs" target="_blank">Read more</a>
		            </div>
		        </div>
		    </li>
		    <?php } ?>
		    <!-- END timeline item -->
		    <li>
		        <i class="fa fa-clock-o"></i>
		    </li>
		</ul>
    </div>
</div>