<section class="content">
<div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3><?php echo $total_published_artikel ?></h3>
                                    <p>Published Artikel</p>
                                   
                                </div>
                                <div class="icon">
                                    <i class="ion ion-document "></i>
                                </div>
                                <a href="<?php echo ($total_published_artikel>0)?base_url('admin/news/news_list/published/1'):'javascript:;'  ?>" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->

                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                   <h3><?php echo $total_draft_artikel?></h3>
                                    <p>Draft Artikel</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-document"></i>
                                </div>
                                <a href="<?php echo ($total_draft_artikel>0)?base_url('admin/news/news_list/draft/1'):'javascript:;'  ?>" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->

                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                   <h3><?php echo $total_blocked_artikel?></h3>
                                    <p>Blocked Artikel</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-document"></i>
                                </div>
                                <a href="javascript:;" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->

                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3><?php echo $total_reported_artikel ?></h3>
                                    <p>Reported Artikel</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-document"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
        
                    </div><!-- /.row -->
<div class="row">
<div class="col-md-6">
                            <div class="box">
                                <div style="padding-left:10px">

                                    <h3 class="box-title ion ion-ios7-star text-light-blue "><i class=""></i>&nbsp;5 Artikel Terbaik</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-condensed">
                                        <tbody><tr>
                                            <th style="width: 10px">#</th>
                                            <th>Judul</th>
                                            <th>Penulis</th>
                                            <th style="width: 40px">View</th>
                                        </tr>
                                        <?php 
                                        $i=1;

                                        foreach($top_news as $top){
                                        	echo '<tr>
                                            		<td>'.$i.'.</td>
                                            		<td>'.$top['title'].'</td>
                                            		<td>'.$top['fullname'].'</td>
                                            		<td align="center">'.$top['views'].'</td>
                                        		 </tr>';
                                        $i++;
                                        }
                                        ?>
                                    </tbody></table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>

   <div class="col-md-6">                         
   	        
	</div>
</section>