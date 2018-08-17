<?php class Salary extends MX_Controller {    
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
  public function  list_salary(){
    
    $main = $this->load->module('main/main');
    
    $data['section']            = 'List';
    $data['subsection']         = 'Salary';
    
  
    /*$data['form_pencarian']     = $this->_form_pencarian();
    $data['content']            = $this->load->view('list_salary',$data,TRUE);*/
   
    $data['content']            = $this->_form_pencarian();

    
    $main::default_template($data);

 }
 function coba(){
    echo "yuk";
  }
 
 function list_(){

    $uri    = $this->uri->uri_to_assoc(4);
    $limit  = 25;
    if(!empty($_POST['id_departemen']))     $where['b.id_departemen']=$_POST['id_departemen'];
    if(!empty($_POST['id_tipe_karyawan']))  $where['b.id_tipe_karyawan']=$_POST['id_tipe_karyawan'];
    if(!empty($_POST['tahun']))             $where['a.tahun']=$_POST['tahun'];
    if(!empty($_POST['bulan']))             $where['a.bulan']=$_POST['bulan'];
    if((!empty($_POST['id_karyawan'])) && ($_POST['id_karyawan']<>'all') )       $where['a.id_karyawan']=$_POST['id_karyawan'];

    $where['a.aktif']='YA';
    if(isset($uri['offset']))
      $offset=$uri['offset'];
    else
      $offset=0;
    $parm     = array('table' => 'trs_payroll as a',
                 'limit'=>$limit,
                 'offset'=>$offset,
                'where'=> $where,
                'join'  => array(
                            'table'   =>array('mst_karyawan as b','mst_departemen as c','mst_tipe_karyawan as d'),
                            'on'      =>array('a.id_karyawan=b.id_karyawan','b.id_departemen=c.id_departemen','b.id_tipe_karyawan=d.id_tipe_karyawan'),
                            'method'  =>array('LEFT','LEFT','LEFT')
                          ),
            'select'=>'a.bulan,a.id_payroll,a.tahun,a.id_karyawan,a.jenis_pengiriman,b.nik,b.nama_karyawan,c.nama_departemen,d.nama_tipe_karyawan,
                      (SELECT SUM(x.jumlah) FROM trs_payroll_detail  as x where x.id_payroll=a.id_payroll and x.jenis=\'TUNJANGAN\' ) as tunjangan,
                      (SELECT SUM(y.jumlah) FROM trs_payroll_detail  as y where y.id_payroll=a.id_payroll and y.jenis=\'POTONGAN\' ) as potongan'
            );
    ## GET TOTAL ROW
    $parm_all       = $parm;
    unset($parm_all['offset']);
    unset($parm_all['limit']);
    $total_row = count($this->global_model->get_data($parm_all));
    //echo $this->db->last_query().'<br>';
    
    $data['result']     = $this->global_model->get_data($parm);
    //echo $this->db->last_query();

    $data['offset']     = $offset;
    $data['parm']       = $_POST;
    ## Pagination
    $this->load->library('pagination');
    $config= $this->global_model->pagination_config($total_row);
    $config['base_url']     = base_url('payroll/salary/list_/offset/');
    $config['per_page']     = $limit; 
    $config['uri_segment']    = 5;
    $this->pagination->initialize($config); 
    $this->load->view('list_salary',$data);

 }
  function _form_pencarian(){

    
    for($i=1;$i<=12;$i++){
      $bulan_payroll[$i]=bulan(str_pad($i,2, "0", STR_PAD_LEFT));
    }
   
    $data['opt_bulan_payroll']      = $bulan_payroll;
    $data['tahun']                  = array('name'=>'tahun','id'=>'tahun','value'=>'','class'=>'form-control','maxlength'=>'4','size'=>'4','style'=>'width:100px');
    $data['opt_departemen']         = $this->global_model->getoptions('mst_departemen','id_departemen','nama_departemen',array('aktif'=>'YA'));
    $data['opt_tipe_karyawan']      = $this->global_model->getoptions('mst_tipe_karyawan','id_tipe_karyawan','nama_tipe_karyawan',array('aktif'=>'YA'));

    return  $this->load->view('_form_pencarian',$data,TRUE);
  }
  function detail_payroll(){
  //die("NANAN");
	if(!empty($_POST['bulan'])) $data['bulan_payroll']=$_POST['bulan'];else  $data['bulan_payroll']=$_GET['bulan'];
    if(!empty($_POST['tahun'])) $data['tahun_payroll']=$_POST['tahun'];else  $data['tahun_payroll']=$_GET['tahun'];
	if(!empty($_POST['thp'])) $data['thp']=$_POST['thp'];else  $data['thp']=$_GET['thp'];
	if(!empty($_POST['id_karyawan'])) $data['id_karyawan']=$_POST['id_karyawan'];else  $data['id_karyawan']=$_GET['id_karyawan'];
	 
     $data['result_karyawan']   = $this->global_model->get_data_karyawan(" and a.id_karyawan =".$data['id_karyawan']);
    
     $this->load->view('detail_payroll',$data);
  }
  function get_salary($jenis,$id_karyawan,$bulan,$tahun){
    $result = $this->global_model->get_salary(array('id_karyawan'=>$id_karyawan,'bulan'=>$bulan,'tahun'=>$tahun,'b.jenis'=>$jenis));
    if($jenis=='TUNJANGAN')
      $label='PENERIMAAN';
    else
      $label=$jenis;

    echo '<table width="100%">';
    $total=0;
    $no=1;
    foreach($result as $rec_){

        echo '<tr><td style="padding-left:10px">'.$rec_['nama_komponen_gaji'].'</td><td style="text-align:right"><b>'.number_format($rec_['jumlah']).'</b></td></tr>';
        $total= $total+ $rec_['jumlah'];  
      $no++;
     }
     
      ## untuk menyamakan baris
      if($no<6){
        $batas= 6- $no;
        for($i=1;$i<=$batas;$i++)
        {
          echo '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
        }
      }
    
    echo '</table>';
    echo '<div style="vertical-align:bottom"><table width="100%">';
       echo '<tr><td colspan="2" ><hr></td></tr>';
      echo '<tr><td>TOTAL '.$label.'</td><td style="text-align:right"><b>'.number_format($total).'</b></td></tr>';
    echo '</table></div>';
  }

  function cetak_slip_gaji(){
     $uri    = $this->uri->uri_to_assoc(4);

     $data['bulan_payroll']     = $uri['bulan'];
     $data['tahun_payroll']     = $uri['tahun'];
     $data['thp']               = '';
     $data['all_print']         = TRUE;
     $where='';
     if($uri['id_departemen']<>'all')
        $where.=" AND a.id_departemen=".$uri['id_departemen'];
     if($uri['id_tipe_karyawan']<>'all')
        $where.=" AND a.id_tipe_karyawan=".$uri['id_tipe_karyawan'];
      if($uri['id_karyawan']<>'all')
        $where.=" AND a.id_karyawan=".$uri['id_karyawan'];

     $data['result_karyawan']   = $this->global_model->get_data_karyawan($where);

    
     $this->load->view('detail_payroll',$data);
  }
  function get_absensi($bulan_payroll,$tahun_payroll,$id_karyawan){
    
    $absensi= $this->global_model->get_data(array('table'=>'trs_absensi_karyawan',
                                        'where'=>array('bulan'=>$bulan_payroll,'tahun'=>$tahun_payroll,'id_karyawan'=>$id_karyawan),
                                         'data'=>'row' 
                                        )
                                 );
    return $absensi;
  }
  
  function change_pengiriman(){
	$data = array('jenis_pengiriman' => $_POST['jenis_pengiriman']);
	$this->db->where('id_payroll', $_POST['payroll_id']);
	$this->db->update('trs_payroll', $data); 
	echo $this->db->last_query();
  }
  

function edit_payroll(){

      echo "nanan";
      die;
   /* $main = $this->load->module('main/main');
    $data['section']            = 'Edit';
    $data['subsection']         = 'Payroll';
    $data['id_payroll']         = $id_payroll;   
    $data['content']            = $this->load->view('edit_payrol',$data,TRUE);
    $main::default_template($data);*/
  }

}