<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title></title>
        <link rel="shortcut icon" href="../favicon.ico"> 
		  <link rel="stylesheet" type="text/css" href="<?php echo base_url('files/css/style.css"')?>" >
		 
	   </head>
    <body>
	  <div id="notif">
            <?php echo $this->session->flashdata('login_notif'); ?>
            <?php echo form_error('username'); ?>
            <?php echo form_error('password'); ?>
        </div>
        <div class="container">
		
			<!-- Codrops top bar --><!--/ Codrops top bar -->
			
	  <header>
			
				<!--<h1><strong><img src="/files/images/logo-bukukafe_03.png" width="231" height="63"></strong></h1>-->
                
				<h1>Ini namanya LOGIN CMS</h1>
				<div class="support-note">
					<span class="note-ie">Sorry, only modern browsers.</span>
			</div>
				
		  </header>
			
			<section class="main">
				<form id="login" action="<?php echo base_url(); ?>admin_login/index" method="post" class="form-1">
					<p class="field">
					<?php echo form_input(array('name'=>'username','placeholder'=>'Username') ) ?>
						<i class="icon-user icon-large"></i>
					</p>
						<p class="field">
					<?php echo form_password(array('name'=>'password','placeholder'=>'Password')); ?>  
							<i class="icon-lock icon-large"></i>
				  </p>
					<p class="submit">
						<button type="submit" name="submit">Login</button>
					</p>
				</form>
			</section>
        
        
        <div class="link"></div>
        
        </div>
    </body>
</html>