<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="<?php echo STATICPATH; ?>/css/dropdown.css" type="text/css" media="screen">
    <link href="<?php echo STATICPATH; ?>css/admin.css" rel="stylesheet" type="text/css" media="screen">
    <link rel="stylesheet" media="all" type="text/css" href="<?php echo STATICPATH; ?>css/jquery-ui.css">

	<script type="text/javascript" src="<?php echo STATICPATH; ?>js/jquery-1.8.2.min.js"></script>

    <title>
      Admin Page
    </title>  </head>
  
    <body>
	<?php $data['stat'] = array( 0 => 'Disabled', 1 => 'Enabled', ); ?>
    <div id="wrapper">
      <div id="header">
        <div id="rol-header">
          <div id="top-banner"></div>
        </div>
      </div>
      <div id="topmenu">
        <ul class="myMenu">
          <li>
            <a href="#">Berita</a>
            <ul>
              <!--<li><?php //echo anchor('admin/produk/index', 'Produk'); ?></li>-->
              <li><?php echo anchor('admin/news/news_list', 'Daftar Berita'); ?></li>
              <!--<li><?php echo anchor('admin/statis/index', 'yang ini Statis'); ?></li> -->
            </ul>
          </li>
		  <li>
            <a href="#">Master</a>
            <ul>
              <li><?php echo anchor('admin/master/channel', 'Channel'); ?></li>
              <li><?php echo anchor('admin/master/user', 'User'); ?></li>
            </ul>
          </li>
                  
		 <?php if($this->session->userdata('level') ==1) { ?>
          <?php } ?>
          <li>
            <?php echo anchor('admin/front/logout', 'Logout'); ?>
          </li>
        </ul>
        <div class="clear"></div>
      </div>
      <div id="top-content">
        <div id="clearer2"></div>
        <div>
          <div class="form-content-auto">
            <div class="content">
              <div id="data" class="data">
                <div id="notif" class="<?php echo !$this->session->flashdata('notif') ? 'success' : 'error'; ?>"><?php echo $this->session->flashdata('notif');?>
                </div><?php echo $content;//if (!empty($content)): ?><?php //$this->load->view($content,$data); ?><?php // endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="clearer2"></div>
    </div>
    <script type="text/javascript">

    $(document).ready(function () {
    $('.myMenu > li').bind('mouseover', openSubMenu);
    $('.myMenu > li').bind('mouseout', closeSubMenu);

    function openSubMenu() {
        $(this).find('ul').css('visibility', 'visible');
    };

    function closeSubMenu() {
        $(this).find('ul').css('visibility', 'hidden');
    };


     });
    </script>

  </body>
</html>

