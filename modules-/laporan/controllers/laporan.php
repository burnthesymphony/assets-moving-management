<?php class Laporan extends MX_Controller {    
  function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('global_model');
        $this->load->model('laporan_model');
	      $this->load->library(array('session','General'));
        $this->load->helper(array('url','form','resize'));
       
        $auth = $this->load->module('main/auth');
        $main = $this->load->module('main/main');
        $auth::session_check();

         
}
  public function  rekapitulasi(){

    
    $main                   = $this->load->module('main/main');
    $data                   = $this->_form_rekapitulasi($this->uri->segment(4));
    $data['section']        = 'Laporan';
    $data['subsection']     = 'Rekapitulasi Salary';
    $data['result']         = $this->global_model->get_data(array('table'=>'mst_departemen','where'=>array('aktif'=>'YA')));
    $data['bulan_payroll']  = $this->uri->segment(3);
    $data['tahun_payroll']  = $this->uri->segment(4);
    $data['content']        = $this->load->view('rekapitulasi_salary',$data,TRUE);
    
    $main::default_template($data);

   }

    function _form_rekapitulasi($tahun_payroll=''){

    $bulan_payroll[0]        = "Pilih Bulan";
    for($i=1;$i<=12;$i++){
      $bulan_payroll[$i]=bulan(str_pad($i,2, "0", STR_PAD_LEFT));
    }
   
    $data['opt_bulan_payroll']= $bulan_payroll;
    $data['tahun']    = array('name'=>'tahun','placeholder'=>'tahun','id'=>'tahun','value'=>'','class'=>'form-control','maxlength'=>'4','size'=>'4','style'=>'width:100px','value'=>$tahun_payroll);
    
    return $data;
    }
    function get_salary($where){
        $res=$this->laporan_model->rekapitulasi($where);

        return $res['jumlah'];
    }


}