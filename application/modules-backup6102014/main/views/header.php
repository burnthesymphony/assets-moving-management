<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ASSETS MOVNG MANAGEMENT</title>
  <link rel="stylesheet" media="screen" href="<?php echo base_url('assets/css/style.css') ?>" />  
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-ui.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.ui.datepicker.js') ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.ui.tabs.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/form-validator/jquery.form-validator.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/function.js') ?>"></script>
  <!--<script type="text/javascript" src="<?=base_url()?>assets/js/fancybox/jquery.fancybox.pack.js?v=2.0.6"></script>-->
	<link rel="stylesheet" media="screen" href="<?php echo base_url('assets/css/ui/jquery.ui.all.css')?>" />
	<link rel="stylesheet" media="screen" href="<?php echo base_url('assets/css/ui/jquery.autocomplete.css')?>" />
  <link rel="stylesheet" media="screen" href="<?php echo base_url('assets/css/ui/jquery.ui.tabs.css')?>" />



	<link href="<?php echo base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet" media="screen">
   <!-- <link rel="stylesheet" href="<?=base_url()?>assets/js/fancybox/jquery.fancybox.css?v=2.0.6" type="text/css" media="screen" />-->
	<script>
		$(function(){
			$('.datepicker').datepicker();
			  $.datepicker.setDefaults({ dateFormat: "yy-mm-dd", changeMonth: true,  changeYear: true });
      /* $(".popup").fancybox({
        maxWidth  : $(window).width()-20,
        maxHeight  : $(window).height()-20,
        fitToView  : true,
       
        autoSize  : true,
        closeClick  : false,
        openEffect  : 'none',
        closeEffect  : 'none'
    });*/


		})
	</script>
</head>
<body>

<?php 
	## jika sudah Login Tampilkan menunya
	if($this->session->userdata('logged_in')==TRUE){

	 
  ?>
		<div style="float:left"><a href="<?php echo base_url('progress/progress/main/mods/0/dashboard/1') ?>"><img src="<?php echo base_url('assets/img/sci_logo.jpg') ?>" height="100px"></a></div>
    <div class="topmenu">
  <!-- <div class="application_name">Online Reporting</div>-->
      <?php echo '<div align="right" style="margin: 0 auto;">'.$this->session->userdata('fullname') .' | <a href="'.base_url('login/logout').'">Logout</a></div>';?>
            <div class="navbar navbar-inverse">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
		  <?php foreach($menus as $menu){ 
         

           $result_child=$this->global_model->get_data(array('table'=>'mst_akses as a',
                                                             'select'=>'b.*',
                                                              'join'=>array( 'table' =>array('mst_menu as b'),
                                                                          'on'    =>array('a.id_menu=b.id_menu'),
                                                                          'method'  =>array('LEFT')),
                                              'where'=>array('b.parent'=>$menu['id_menu'],
                                                              'a.id_grup'=>$this->session->userdata('id_group'))));
          if(count($result_child)>0){
            echo '<li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">'. ucwords($menu['nama_menu']).'<b class="caret"></b></a>
                    <ul class="dropdown-menu">';
          foreach($result_child as $rec_child){
              $link_child='/onlinereporting/'.$rec_child['folder'].'/'.$rec_child['controller'].'/mods/'.$rec_child['id_menu'];
               echo  '<li><a href="'.$link_child.'">'.ucwords($rec_child['nama_menu']).'</a></li>';
            }
            echo '</ul></li>';
          }
          else{
                
                $class="";
                if(isset($var_uri['mods'])){
                    if($menu['id_menu']==$var_uri['mods'])
                          $class="active";
                    else
                          $class="";
                    }
                
                if($menu['controller']=='#')
                      $link='#';
                else
                    $link='/onlinereporting/'.$menu['folder'].'/'.$menu['controller'].'/mods/'.$menu['id_menu'];
        ?>
            <li class="<?php echo $class ?>" ><a href="<?php echo $link ?>"><?php echo $menu['nama_menu'] ?></a></li>
		  <?php 
              }
          } 
      ?>
            <!--<li class="active"><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
              <ul class="dropdown-menu">
               
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>-->
          </ul>
          <!--<ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="./">Default</a></li>
            <li><a href="../navbar-static-top/">Static top</a></li>
            <li><a href="../navbar-fixed-top/">Fixed top</a></li>
          </ul>-->
        </div><!--/.nav-collapse -->
      </div>

      </div>

	<?php 
	}
		$var_uri=$this->uri->uri_to_assoc(4);
	?>
<div id="container">