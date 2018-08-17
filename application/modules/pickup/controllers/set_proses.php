<?php 
    class Set_proses extends MX_Controller {

    function __construct() {
  
        parent::__construct();
        $this->load->database();
        //$this->load->library('grocery_CRUD');
        
	    $this->load->library(array('session','General'));
        $this->load->helper(array('url','form'));
       
        //$auth = $this->load->module('main/auth');
        $auth = $this->load->module('main/auth');
        $main = $this->load->module('main/main');
        $auth::session_check();
        
     }
     
     function index($proses=''){
        
        $main                   = $this->load->module('main/main');
        
        $parm                       =  $this->_frm_sj($_POST);
        $parm['proses']             =  $proses;
        $parm['next_process_name']  =  $process['process_name'];
        $data['selected']           =  $_POST;
        $data['content']            =  $this->load->view('change_process_by_sj',$parm,TRUE);  
        $data['section']            = 'SET PROCESS '.$process['process_name'];
        $data['subsection']         = 'Demo Only';
        $main::demo_template($data);      

     }
    function _frm_sj(){
        $data['frm_permit_numbers'] = array('name'=>'permit_number','id'=>'permit_number','class'=>'form-control' ,'value'=>$_POST['permit_number']);
        return $data;
    }
    function change_status(){
        $proses             = $_POST['process_name'];
        $no_surat_jalan     = $_POST['permit_number'];
        $where['a.aktif']   = 'Y';
        $where['a.permit_number']   = $no_surat_jalan;
        $data['result']     = $this->global_model->get_data(array('table'=>'trs_pickup as a',
                                                                     'join'=>array(
                                                                                'table'=>array(
                                                                                            'mst_gate_inventory as b',
                                                                                            'mst_gate_inventory as c',
                                                                                            'mst_user as d',
                                                                                            'mst_driver as e'
                                                                                        ),
                                                                                 'on'=>array(
                                                                                        'a.loading_point=b.id_gate',
                                                                                        'a.id_gate_to=c.id_gate',
                                                                                        'a.user_create=d.id_user',
                                                                                        'a.id_driver=e.id_driver'
                                                                                        ),
                                                                                 'method'=>array('LEFT','LEFT','LEFT','LEFT')
                                                                                ),
                                                                    'where'=>$where,
                                                                    'select'=>'a.status,a.id_pickup,a.permit_number,a.date_create,a.car_number,e.driver_name,
                                                                               b.gate_name as gate_from,c.gate_name as gate_destination,
                                                                               d.nama_lengkap','data'=>'row'
                                                                    )
                                                               );
        if(count($data['result']) == 0 ){
           echo ' <div class="alert alert-danger"><b>MAAF !</b> DATA SURAT JALAN TIDAK ADA </div>';
        }
        else{
           $sql_detail="SELECT `a`.*, `b`.`item_name`, `b`.`id_item_category`, `b`.`description`, `b`.`barcode`, `b`.`barcode_old`, `c`.`category_name` 
                        FROM (`trs_pickup_detail` as a) LEFT JOIN `mst_item` as b ON `a`.`id_item`=`b`.`id_item` 
                          LEFT JOIN `mst_item_category` c ON `c`.`id_item_category`=`b`.`id_item_category` 
                          WHERE `a`.`id_pickup` = '".$data['result']['id_pickup']."' AND `a`.`parent_item` is NULL ORDER BY `item_name` ASC";
            
            $data['result_detail'] =  $this->db->query($sql_detail)->result_array();
            echo '<pre>';
            print_r($data['result_detail']);  
            echo '</pre>';
        }
        
    }
 }