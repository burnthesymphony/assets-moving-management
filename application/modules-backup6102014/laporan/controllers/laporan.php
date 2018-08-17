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
  public function  rekapitulasi_dashboard($bulan_payroll,$tahun_payroll){ ## jangan di hapus

    
    $main                   = $this->load->module('main/main');
    $data                   = $this->_form_rekapitulasi($tahun_payroll);
    $data['section']        = 'Laporan';
    $data['subsection']     = 'Rekapitulasi Salary';
    $data['result']         = $this->global_model->get_data(array('table'=>'mst_departemen','where'=>array('aktif'=>'YA')));
    $data['bulan_payroll']  = $bulan_payroll;
    $data['tahun_payroll']  = $tahun_payroll;
    //print_r($data);
    $this->load->view('rekapitulasi_salary',$data);
  //  echo $data['content'];
   // $main::default_template($data);

   }
   public function  rekapitulasi($by=''){ ## jangan di hapus

    
    $main                   = $this->load->module('main/main');
    $data                   = $this->_form_rekapitulasi();
    if($by=='departemen')
    $data['url_cari']       = 'laporan/rekap_departemen';
    if($by=='status_karyawan')
    $data['url_cari']       = 'laporan/rekap_status_karyawan';
    $data['section']        = 'Laporan';
    $data['subsection']     = 'Rekapitulasi Salary Berdasarkan '.ucwords(str_replace('_',' ',$by));
    $data['content']        = $this->load->view('rekapitulasi_salary_new',$data,TRUE);
    
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
	function rekap_departemen(){
        if(!empty($_POST['bulan']))
            $bulan=$_POST['bulan'];
        if(!empty($_POST['tahun']))
            $tahun=$_POST['tahun'];
        if(!empty($_POST['nama_komponen_gaji']))
            $nama_komponen_gaji=$_POST['nama_komponen_gaji'];

        $data['bulan']            = $bulan;
        $data['tahun']            = $tahun;
		$data['rekap_tunjangan']  = $this->laporan_model->rekap_by_departemen('TUNJANGAN',$bulan,$tahun,$nama_komponen_gaji);
        
        $data['rekap_potongan']   = $this->laporan_model->rekap_by_departemen('POTONGAN',$bulan,$tahun,$nama_komponen_gaji);
        $this->load->view('laporan_rekap_departemen',$data);
		
	}
    function rekap_departemen_xls($bulan,$tahun,$nama_komponen_gaji=''){
       

        
        $data['rekap_tunjangan']  = $this->laporan_model->rekap_by_departemen('TUNJANGAN',$bulan,$tahun,$nama_komponen_gaji);
        $data['rekap_potongan']   = $this->laporan_model->rekap_by_departemen('POTONGAN',$bulan,$tahun,$nama_komponen_gaji);
        $data['is_xls']           = 'YA';
        $data['bulan']            = $bulan;
        $data['tahun']            = $tahun;
        
        $data['nama_komponen_gaji']     = $nama_komponen_gaji;

        $this->load->view('laporan_rekap_departemen',$data);
        
    }
    function rekap_status_karyawan(){
        if(!empty($_POST['bulan']))
            $bulan=$_POST['bulan'];
        if(!empty($_POST['tahun']))
            $tahun=$_POST['tahun'];
        if(!empty($_POST['nama_komponen_gaji']))
            $nama_komponen_gaji=$_POST['nama_komponen_gaji'];

        $data['rekap_tunjangan']        = $this->laporan_model->rekap_by_status_karyawan('TUNJANGAN',$bulan,$tahun,$nama_komponen_gaji);
        $data['rekap_potongan']         = $this->laporan_model->rekap_by_status_karyawan('POTONGAN',$bulan,$tahun,$nama_komponen_gaji);
        $data['bulan']                  = $bulan;
        $data['tahun']                  = $tahun;
        $data['nama_komponen_gaji']     = $nama_komponen_gaji;
        $this->load->view('laporan_rekap_status_karyawan',$data);
        
    }
    function rekap_status_karyawan_xls($bulan,$tahun,$nama_komponen_gaji=''){
        $data['rekap_tunjangan']  = $this->laporan_model->rekap_by_status_karyawan('TUNJANGAN',$bulan,$tahun,$nama_komponen_gaji);
        $data['rekap_potongan']   = $this->laporan_model->rekap_by_status_karyawan('POTONGAN',$bulan,$tahun,$nama_komponen_gaji);
        $data['is_xls']           = 'YA';
        $data['bulan']                  = $bulan;
        $data['tahun']                  = $tahun;
        $data['nama_komponen_gaji']     = $nama_komponen_gaji;
        $this->load->view('laporan_rekap_status_karyawan',$data);
    }


}