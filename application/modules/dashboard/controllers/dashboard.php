<?php 
class Dashboard extends MX_Controller {

    function __construct() {
  
        parent::__construct();
        $this->load->database();
        $this->load->library('grocery_CRUD');
        
	    $this->load->library(array('session','General'));
        $this->load->helper(array('url','form'));
       
        $auth = $this->load->module('main/auth');
        $main = $this->load->module('main/main');
        $auth::session_check();
         $this->load->model('dashboard_model');
        // die("asdasd");
	    
        
     }
     
     function index($bulan='',$tahun=''){
        
        $main                   = $this->load->module('main/main');
        $data['content']        = $this->_dashboard($bulan,$tahun);

        
        $data['section']        = 'Dashboard';
        $data['subsection']     = 'PSH';
        $main::default_template($data);

     }
     function _dashboard($bulan,$tahun  ){
        $data['result_karyawan_per_tipe']           = $this->dashboard_model->jumlah_karyawan_by_tipe();
        $data['result_karyawan_per_departemen']     = $this->dashboard_model->jumlah_karyawan_by_departemen();
        $data['bulan']          = $bulan;
        $data['tahun']          = $tahun;
        
        $view= $this->load->view('dashboard',$data,TRUE);
        return $view;
     }
    
}