<?php class Payroll extends MX_Controller {    
  function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('global_model');
	      $this->load->library(array('session','General'));
        $this->load->helper(array('url','form','resize'));
       
        $auth = $this->load->module('main/auth');
        $main = $this->load->module('main/main');
        $auth::session_check();

         
}
 
 
public function  proses_payroll(){

  $main = $this->load->module('main/main');
  $data                   = $this->_form_proses_payroll();
  $data['section']        = 'Proses';
  $data['subsection']     = 'Penggajian';
  $data['view_absensi_dw']= $this->_absensi_dw();
  $data['view_potongan']  = $this->_potongan_tunjangan('POTONGAN');
  $data['view_tunjangan'] = $this->_potongan_tunjangan('TUNJANGAN');
  $data['content']        = $this->load->view('proses_payroll',$data,TRUE);
  
  $main::default_template($data);

 }
 function _potongan_tunjangan($jenis){
    $data['jenis']                  = $jenis;
    $data['opt_departemen']         = $this->global_model->getoptions('mst_departemen','id_departemen','nama_departemen',array('aktif'=>'YA'));
    $data['opt_tipe_karyawan']      = $this->global_model->getoptions('mst_tipe_karyawan','id_tipe_karyawan','nama_tipe_karyawan',array('aktif'=>'YA'));
    $data['opt_komponen_gaji']      = $this->global_model->getoptions('mst_komponen_gaji','id_komponen_gaji','nama_komponen_gaji',array('jenis'=>$jenis,'aktif'=>'YA','pokok'=>'TIDAK'));
    $data['nominal_tunjangan']      = array('name'=>'nominal_tunjangan','id'=>'nominal_tunjangan','class'=>'form-control input'.$jenis,'style'=>'width:250px');
    $data['nominal_potongan']       = array('name'=>'nominal_potongan','id'=>'nominal_potongan','class'=>'form-control input'.$jenis,'style'=>'width:250px');
    
    $view_ =$this->load->view('potongan_tunjangan',$data,TRUE);
    return $view_;
 }
 function _form_proses_payroll(){

    
    $current_month  = date('n');
    $bulan_payroll[0]        = "Pilih Bulan";
    for($i=$current_month;$i<=12;$i++){
      $bulan_payroll[$i]=bulan(str_pad($i,2, "0", STR_PAD_LEFT));
    }
   
    $data['opt_bulan_payroll']	= $bulan_payroll;
    $data['tahun']   			= array('name'=>'tahun','id'=>'tahun','value'=>date('Y'),'class'=>'form-control','maxlength'=>'4','size'=>'4','style'=>'width:100px');
    $data['frm_service']    	= array('name'=>'service','id'=>'service','value'=>'','class'=>'form-control','style'=>'width:130px');
	return $data;
 }
 function _absensi_dw(){

    $data['result_dw_casual']  = $this->global_model->get_data_karyawan('and a.id_tipe_karyawan in(3,4)');
    $view                      = $this->load->view('absensi_dw',$data,TRUE);
    return $view;
 }
 function get_karyawan(){
    
 
    $result=$this->global_model->get_data_karyawan(" and a.nik like'%".strtoupper($this->input->get('q'))."%'");
    
    foreach($result as $rec){
     
      $data[]= array('label'=>$rec['nama_karyawan'],'id'=>$rec['id_karyawan'], 'desc'=>$rec['nama_departemen'].' '.$rec['nama_tipe_karyawan']);
    }
    echo json_encode($data);
  }
  function get_cbo_karyawan(){
     $kriteria='';
    if(!empty($_POST['id_departemen']))
        $kriteria .= " AND a.id_departemen=".$_POST['id_departemen'];
    if(!empty($_POST['id_tipe_karyawan']))
        $kriteria .= " AND a.id_tipe_karyawan=".$_POST['id_tipe_karyawan'];
 
    $result=$this->global_model->get_data_karyawan($kriteria);
        $opt['all']='Semua Karyawan';
    foreach($result as $rec){
        $opt[$rec['id_karyawan']]=$rec['nama_karyawan'];
    }
    if(!empty($_POST['jenis']))
      echo form_dropdown('id_karyawan_'.strtolower($_POST['jenis']),$opt,'','id="id_karyawan_'.strtolower($_POST['jenis']).'" class="form-control input'.$_POST['jenis'].'" style="width:200px"');
    else
      echo form_dropdown('id_karyawan',$opt,'','id="id_karyawan" class="form-control input" style="width:200px"');
 }
 function proses_penggajian(){

      $tahun          = $_POST['tahun'];
      $bulan_payroll  = $_POST['bulan'];

      $this->db->trans_start();

      $result_rate  = $this->global_model->get_data(array('table'=>'mst_rate_dw','data'=>'row','where'=>array('aktif'=>'YA')));
     
      $rate_dw      = $result_rate['jumlah'];
      ## ENTRY DATA ABSENSI DW AND CASUAL
      $jumlah_hari_masuk  = $_POST['jumlah_hari_masuk'];
      $jumlah_lembur      = $_POST['jumlah_lembur'];
      $hari_masuk_keys    = array_keys($jumlah_hari_masuk); ## index hari masuk key= index jumlah lembur == id_karyawan
     
      foreach ($hari_masuk_keys as $key_hari_masuk ) {
        
        $this->db->set('id_karyawan',$key_hari_masuk);
        $this->db->set('bulan',$bulan_payroll);
        $this->db->set('tahun',$tahun);
        $this->db->set('jumlah_hari_masuk',$jumlah_hari_masuk[$key_hari_masuk]);
        $this->db->set('jumlah_lembur',$jumlah_lembur[$key_hari_masuk]);

        $this->db->insert('trs_absensi_karyawan');
        
        //echo $this->db->last_query().'<br>';
        ## HITUNG JUMLAH UPAH DW AND CASUAL
        $this->db->set('id_karyawan',$key_hari_masuk);
        $this->db->set('bulan',$bulan_payroll);
        $this->db->set('tahun',$tahun);
        $this->db->set('tanggal_create','now()',FALSE);
        $this->db->set('user_create',$this->session->userdata('id_user'));
        
        $this->db->insert('trs_payroll');
        //echo $this->db->last_query().'<br>';
        
        $last_payroll_id = $this->db->insert_id();
        ## hitung gaji pokok DW sesuai hari kerja
        $total_gaji_pokok   =$rate_dw * $jumlah_hari_masuk[$key_hari_masuk];
        $total_upah_lembur  =$rate_dw * $jumlah_lembur[$key_hari_masuk];
        
        $this->db->set('id_payroll',$last_payroll_id);
        $this->db->set('id_komponen_gaji',4);
        $this->db->set('jenis','TUNJANGAN');
        $this->db->set('jumlah',$total_gaji_pokok);
        
        $this->db->insert('trs_payroll_detail');        
        //echo $this->db->last_query().'<br>';

        ## hitung upah lembur  DW 
        $this->db->set('id_payroll',$last_payroll_id);
        $this->db->set('id_komponen_gaji',7);
        $this->db->set('jenis','TUNJANGAN');
        $this->db->set('jumlah',$total_upah_lembur);

        $this->db->insert('trs_payroll_detail');
        //echo $this->db->last_query().'<br>';

      }

   ## HITUNG JUMLAH GAJI POKOK TUNJANGAN DAN POTONGAN JAMSOSTEK UNTUK KARYAWAN TETAP DAN KONTRAK
      $result_karyawan_tetap_kontrak  = $this->global_model->get_data_karyawan("and a.id_tipe_karyawan  in(1,2)");
      $rec_meal						  = $this->global_model->get_data(array('table'=>'mst_config_meal','data'=>'row'));
	  $total_meal					  = $rec_meal['jumlah'] * $rec_meal['jumlah_hari'];
	  $result_jamsostek               = $this->global_model->get_data(array('table'=>'mst_config_jamsostek','where'=>array('aktif'=>'YA')));
      foreach ($result_jamsostek as $rec_jamsostek) {
        if($rec_jamsostek['jenis']=='TUNJANGAN')
          $persen_tunjangan_jamsostek= $rec_jamsostek['jumlah'];
        if($rec_jamsostek['jenis']=='POTONGAN')
          $persen_potongan_jamsostek= $rec_jamsostek['jumlah'];

      }
      foreach($result_karyawan_tetap_kontrak as $kontrak_tetap){
          $this->db->set('id_karyawan',$kontrak_tetap['id_karyawan']);
          $this->db->set('bulan',$bulan_payroll);
          $this->db->set('tahun',$tahun);
          $this->db->set('tanggal_create','now()',FALSE);
          $this->db->set('user_create',$this->session->userdata('id_user'));
        
          $this->db->insert('trs_payroll');
          //echo $this->db->last_query().'<br>';
          $last_payroll_id = $this->db->insert_id();
          ## insert gaji pokok
          $this->db->set('id_payroll',$last_payroll_id);
          $this->db->set('id_komponen_gaji',4);
          $this->db->set('jenis','TUNJANGAN');
          $this->db->set('jumlah',$kontrak_tetap['gaji_pokok']);
		  $this->db->insert('trs_payroll_detail');
		  
		  ## insert service
          $this->db->set('id_payroll',$last_payroll_id);
          $this->db->set('id_komponen_gaji',5);
          $this->db->set('jenis','TUNJANGAN');
          $this->db->set('jumlah',$_POST['service']);
          $this->db->insert('trs_payroll_detail');
		  
		  
		  ##insert uang makan
		  $this->db->set('id_payroll',$last_payroll_id);
          $this->db->set('id_komponen_gaji',11);
          $this->db->set('jenis','TUNJANGAN');
          $this->db->set('jumlah',$total_meal);
          $this->db->insert('trs_payroll_detail');
		  
		  $this->db->set('id_payroll',$last_payroll_id);
          $this->db->set('id_komponen_gaji',12);
          $this->db->set('jenis','POTONGAN');
          $this->db->set('jumlah',$total_meal);
          $this->db->insert('trs_payroll_detail');
		  
          
          ## insert TUNJANGAN JAMSOSTEK
          $total_tunjangan_jamsostek = ($persen_tunjangan_jamsostek * $kontrak_tetap['gaji_pokok']) /100;
          //echo "PERSEN TUNJANGAN".$persen_tunjangan_jamsostek.'#gaji pokok'.$kontrak_tetap['gaji_pokok'].'#TOTAL'.$total_tunjangan_jamsostek;
          $this->db->set('id_payroll',$last_payroll_id);
          $this->db->set('id_komponen_gaji',1);
          $this->db->set('jenis','TUNJANGAN');
          $this->db->set('jumlah',$total_tunjangan_jamsostek);

          $this->db->insert('trs_payroll_detail');
          //echo $this->db->last_query().'<br>';

          ## insert POTONGAN JAMSOSTEK
          $total_potongan_jamsostek = ($persen_potongan_jamsostek * $kontrak_tetap['gaji_pokok']) /100;
         // echo "PERSEN POTONGAN".$persen_potongan_jamsostek.'#gaji pokok'.$kontrak_tetap['gaji_pokok'].'#TOTAL'.$total_potongan_jamsostek;
          $this->db->set('id_payroll',$last_payroll_id);
          $this->db->set('id_komponen_gaji',8);
          $this->db->set('jenis','POTONGAN');
          $this->db->set('jumlah',$total_potongan_jamsostek);

          $this->db->insert('trs_payroll_detail');
          //echo $this->db->last_query().'<br>';
      }
    ##HITUNG DATA TUNJANGAN LAINNYA 
      $id_karyawan_tunjangan  = $_POST['id_karyawan_tunjangan'];
      $id_tunjangan           = $_POST['id_tunjangan'];
      $nominaltunjangan       = $_POST['nominaltunjangan'];
      $key_karyawan_tunjangan = array_keys($id_karyawan_tunjangan);
      
      foreach($key_karyawan_tunjangan as $key){
          for($i=0;$i < count($id_tunjangan[$key]); $i++){
            $id_payroll= $this->_get_payrol_id(array('id_karyawan'=>$key,'bulan'=>$bulan_payroll,'tahun'=>$tahun));
         //   echo $key.'tunjangan '.$id_tunjangan[$key][$i].' BESARNYA'.$nominaltunjangan[$key][$i].'<br>';
            $this->db->set('id_payroll',$id_payroll);
            $this->db->set('id_komponen_gaji',$id_tunjangan[$key][$i]);
            $this->db->set('jenis','TUNJANGAN');
            $this->db->set('jumlah',$nominaltunjangan[$key][$i]);
            $this->db->insert('trs_payroll_detail');
          }
      }
  
    ##HITUNG DATA POTONGAN LAINNYA
      $id_karyawan_potongan  = $_POST['id_karyawan_potongan'];
      $id_potongan           = $_POST['id_potongan'];
      $nominalpotongan       = $_POST['nominalpotongan'];
      $key_karyawan_potongan = array_keys($id_karyawan_potongan);
      
      foreach($key_karyawan_potongan as $key){
          for($i=0;$i < count($id_potongan[$key]); $i++){
            $id_payroll= $this->_get_payrol_id(array('id_karyawan'=>$key,'bulan'=>$bulan_payroll,'tahun'=>$tahun));
            echo $key.'potongan '.$id_potongan[$key][$i].' BESARNYA'.$nominalpotongan[$key][$i].'<br>';
            $this->db->set('id_payroll',$id_payroll);
            $this->db->set('id_komponen_gaji',$id_potongan[$key][$i]);
            $this->db->set('jenis','POTONGAN');
            $this->db->set('jumlah',$nominalpotongan[$key][$i]);
            $this->db->insert('trs_payroll_detail');
          }
      }    
    $this->db->trans_complete();
    echo "Proses Payroll Selesai";

 }
 function _get_payrol_id($where){
    $parm=array('table'=>'trs_payroll','where'=>$where,'data'=>'row','select'=>'id_payroll');
    $payroll=$this->global_model->get_data($parm);
    
    return $payroll['id_payroll'];
 }

}