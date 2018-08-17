    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>PSH-backoffice</title>
            <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>


            <!-- bootstrap 3.0.2 -->
            <link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
            <!-- font Awesome -->
            <link href="<?php echo base_url('assets/css/font-awesome.min.css')?>" rel="stylesheet" type="text/css" />
            <!-- Ionicons -->
            <link href="<?php echo base_url('assets/css/ionicons.min.css')?>" rel="stylesheet" type="text/css" />
            <!-- bootstrap wysihtml5 - text editor -->
           <!-- <link href="<?php echo base_url('assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')?>" rel="stylesheet" type="text/css" />
            <!-- Theme style -->
            <link href="<?php echo base_url('assets/css/AdminLTE.css')?>" rel="stylesheet" type="text/css" />
            <script src="<?php echo base_url('assets/js/jquery.js')?>"></script>
            <link rel="stylesheet" href="<?php echo base_url('assets/ui/themes/base/jquery.ui.all.css') ?>">
        <script src="<?php echo base_url('assets/ui/jquery.ui.core.js')?>"></script>
        <script src="<?php echo base_url('assets/ui/jquery.ui.widget.js')?>"></script>
        <script src="<?php echo base_url('assets/ui/jquery.ui.datepicker.js')?>"></script>
            <style>.right-side{overflow-x:auto }</style>
            <script>
                 $(function() {
        $( ".datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd' 
        });
    });
            </script>
        </head>
        <body class="skin-blue">
            <!-- header logo: style can be found in header.less -->
            <header class="header">
                <a href="<?php echo base_url('')?>" class="logo"><?php  //get_menu(); ?>
                    <!-- Add the class icon to your logo image or logo icon to add the margining -->
                   <img width="120px" src="<?php echo base_url('assets/images/psh-logo.png')?>">
                   
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="navbar-right">
                        <ul class="nav navbar-nav">
                            <!-- Messages: style can be found in dropdown.less-->
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="user user-menu" style="width:285px">
                                <a href="#" class="" style="float:left" >
                                    <i class="glyphicon glyphicon-user"></i>
                                    <span><?php echo $this->session->userdata('fullname').' | <a href="'.base_url('login/logout').'" class="">Sign out</a>' ?></span>
                                </a>
                                
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <div class="wrapper row-offcanvas row-offcanvas-left">
                <!-- Left side column. contains the logo and sidebar -->
                <aside class="left-side sidebar-offcanvas">
                    <!-- sidebar: style can be found in sidebar.less -->
                    <section class="sidebar">
                        <!-- Sidebar user panel -->
                        <div class="user-panel">
                           <!-- <div class="pull-left image">
                                <img src="<?php //echo base_url('files/images/user/'.$this->session->userdata('foto')) ?>" class="img-circle" alt="User Image" />
                            </div>-->
                            <div class="pull-left info">
                                <p>Hello, <?php echo $this->session->userdata('fullname')?></p>

                                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                            </div>
                        </div>
                        <!-- sidebar menu: : style can be found in sidebar.less -->
                        <ul class="sidebar-menu">
                            <?php
                             
                            $current_menu= base_url($this->uri->uri_string());
                            $menu_parents=get_parent_menu() ;
                            
                           

                                        
                                foreach($menu_parents as $parents){
                                    $child_key=get_menu($parents['parent']);
                                    if(count($child_key) > 0){

                                        
                              
                                            $class='';

                                        echo'<li class="treeview '.$class.'">
                                                <a href="#">
                                                    <i class="fa fa-th"></i>
                                                    <span>'.ucwords($parents['nama_menu']).'</span>
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </a>
                                                <ul class="treeview-menu">';
                                                foreach($child_key as $child_menu){
                                                    echo '<li><a href="'.base_url($child_menu['link']).'"><i class="fa fa-angle-double-right"></i>'.ucwords($child_menu['nama_menu']).'</a></li>';
                                                }
                                                    
                                                    
                                          echo '</ul>
                                            </li>';
                                    }
                                    else{
                                        echo'<li class="active">
                                            <a href="'.base_url($parents['link']).'">
                                                <i class="fa fa-dashboard"></i> <span>'.ucwords($parents['nama_menu']).'</span>
                                            </a>
                                        </li>';    
                                    }
                                    
                                }
                            ?>
                            <!--<li class="active">
                                <a href="index.html">
                                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                                </a>
                            </li>
                            
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-th"></i>
                                    <span>Artikel</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="<?php echo base_url('admin/news/news_list/add/')?>"><i class="fa fa-angle-double-right"></i> Buat Artikel</a></li>
                                    <li><a href="<?php echo base_url('admin/news/news_list/publish')?>"><i class="fa fa-angle-double-right"></i>Artikel Saya (Publish)</a></li>
                                    <li><a href="<?php echo base_url('admin/news/news_list/draft')?>"><i class="fa fa-angle-double-right"></i>Artikel Saya (Draft)</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-users"></i>
                                    <span>Pengaturan Profile</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="pages/UI/general.html"><i class="fa fa-angle-double-right"></i> Profile Saya</a></li>
                                    <li><a href="pages/UI/icons.html"><i class="fa fa-angle-double-right"></i> Edit Profile</a></li>
                                   
                                </ul>
                            </li>-->
                        </ul>
                    </section>
                    <!-- /.sidebar -->
                </aside>

                <!-- Right side column. Contains the navbar and content of the page -->
                <aside class="right-side">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <h1><?php echo $section .'<small>'.$subsection.'</small>'?></h1>
                        <ol class="breadcrumb">
                           <!-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                            <li class="active">Dashboard</li>-->
                        </ol>
                    </section>
                    <!-- Main content -->
                    <section class="content">
                        <!-- Small boxes (Stat box) -->
                        

                        <!-- top row -->
                        <div class="row" style="width: 99%;margin: 0 auto;">
                            <div class="col-xs-12 connectedSortable">
                                 <?php  echo $content;?>
                            </div><!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Main row -->
                        <div class="row">
                              
                        </div><!-- /.row (main row) -->
                    </section><!-- /.content -->
                </aside><!-- /.right-side -->
            </div><!-- ./wrapper -->
            <!-- jQuery 2.0.2 -->
            <script type="text/javascript">
               /* if (!window.jQuery) {
                    alert('aaa');
                     var jq = document.createElement('script'); jq.type = 'text/javascript';
                    jq.src = '<?php echo base_url("assets/js/jquery.js")?>';
                    document.getElementsByTagName('head')[0].appendChild(jq);
                }*/
            </script>
            
                    <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title"></h4>

            </div>
            <div class="modal-body"><div class="te"></div></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
            <!-- jQuery UI 1.10.3 -->
            <script src="<?php echo base_url('assets/js/jquery-ui-1.10.3.min.js')?>" type="text/javascript"></script>
            <!-- Bootstrap -->
            <script src="<?php echo base_url('assets/js/bootstrap.min.js')?>" type="text/javascript"></script>
            <!-- AdminLTE App -->
            <script src="<?php echo base_url('assets/js/AdminLTE/app.js')?>" type="text/javascript"></script>
            
        </body>
    </html>