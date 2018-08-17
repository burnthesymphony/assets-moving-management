<?php 
class Main extends MX_Controller {
	public function __construct(){
		
		$this->load->model('global_model');
	}
	
	
	function default_template($data){
		//error_reporting(E_ALL);
		//echo "aaaaa Main";
		
		 $this->load->view('main/new_template', $data);
	}
	function demo_template($data){
		error_reporting(0);	
		//error_reporting(E_ALL);
		//echo "aaaaa Main";
		
		 $this->load->view('main/demo_template', $data);
	}
	
}
