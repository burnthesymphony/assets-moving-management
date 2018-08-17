<?php 
class Auth extends MX_Controller {

	
	public function session_check()
	{
		if($this->session->userdata('logged_in')<>TRUE){
			$this->session->sess_destroy();
			redirect(site_url());
		}
		
	}
}
