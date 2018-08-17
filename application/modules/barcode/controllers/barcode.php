<?php class Barcode extends MX_Controller {

    
    function __construct() {
  
        
       parent::__construct();
        $this->load->database();
	       $this->load->library(array('session','General'));
        $this->load->helper(array('url','form','resize'));
        $auth = $this->load->module('main/auth');
        $main = $this->load->module('main/main');
        $auth::session_check();

         
     }
     
      function daftar_barcode($status=''){
          

          $main = $this->load->module('main/main');
          if($status=='none')
              $subjudul= 'Belum Diprint';
          if($status=='on-print')
              $subjudul= 'Dalam Proses Print';
          if($status=='printed')
              $subjudul= 'Berhasil Print';
           if($status=='on-product')
              $subjudul= 'Di pasang di Item';

          $data['content'] = $this->_main($status);
          $data['section']        = 'Daftar Barcode';
          $data['subsection']     = $subjudul;
          $main::demo_template($data);

     }
     function _main($status){
          $data           = $this->_form_cari();
          $data['status'] = $status;
          $view           = $this->load->view('form_cari_asset',$data,TRUE);
          return $view;
     }
     function _form_cari($selected=''){
        $data['item_name']          = array('name'=>'item_name','id'=>'item_name','class'=>'form-control','value'=>$selected['item_name']);
        $data['barcode']            = array('name'=>'barcode','id'=>'barcode','class'=>'form-control','value'=>$selected['barcode']);
        $data['opt_item_category']  = $this->global_model->getoptions('mst_item_category','id_item_category','category_name');
        return $data;
     }
     function print_barcode(){
         $this->db->where_in('id_item',$_GET['selected_item']);
         $data['result']= $this->db->get('mst_item')->result_array();
         $this->_log_print($_GET['selected_item']);
         $this->load->view('print_barcode',$data);
     }
     function _log_print($selected_item){
        $in_='';
        foreach ($selected_item as $val) {
          $in_.= $val.',';
        }
        $in_=substr($in_, 0,-1);
        
        $sql= "INSERT INTO trs_log_print_barcode (id_item,barcode,user_create,tanggal_create) 
                  SELECT id_item,barcode ,'".$this->session->userdata('id_user')."' as user_create,now() as tanggal_create 
                      FROM mst_item 
                      WHERE id_item in(".$in_.")";
        $this->db->query($sql);
        
      
     }
     function pemasangan_barcode(){
          $main = $this->load->module('main/main');

          $frm['frm_barcode']     = array('name'=>'barcode','class'=>'form-control','id'=>'barcode','value'=>'');
          $data['content']        = $this->load->view('frm_pemasangan_barcode',$frm,TRUE);
          $data['section']        = 'Pemasangan';
          $data['subsection']     = 'barcode';
          $main::demo_template($data);
     }
    function list_(){
        $uri  = $this->uri->uri_to_assoc(4);
        $limit  = 25;
      
        if(isset($uri['offset']))
          $offset=$uri['offset'];
        else
          $offset=0;

        $where['a.aktif']         ='YA';
        if(isset($_POST['filter'][0]['value'])){
          if($_POST['filter'][0]['value']=='on-product'){
            $where['a.status_pemasangan']  = 'Y';
          }
          else
          $where['a.status_print']  = $_POST['filter'][0]['value'];
        }

        if(isset($_POST['status_pemasangan']))
            $where['a.status_pemasangan']  = $_POST['status_pemasangan'];
        
        if(isset($where['a.status_pemasangan']))
            $order_by=array('field'=>'tanggal_tempel','type'=>' DESC ');
          else
            $order_by=array('field'=>'id_item','type'=>' DESC ');
      
        $parm      = array(  'table'  => 'mst_item as a',
                             'limit'=>$limit,
                             'offset'=>$offset,
                             'where' => $where,
                             'order_by'=>$order_by,
                              'join'  => array('table'=>array('mst_item_category as b','mst_user as c'),
                                          'on'=>array('b.id_item_category=a.id_item_category','a.user_create=c.id_user'),
                                          'method'=>array('LEFT','LEFT')
                                        ),
                'select'=>'a.*,b.category_name,c.nama_lengkap'
                );
        $data['result']     = $this->global_model->get_data($parm);
        //echo $this->db->last_query();
        $data['status']     = $_POST['filter'][0]['value'];
        $data['offset']     = $offset;
        ## Pagination
        $this->load->library('pagination');
        $config= $this->global_model->pagination_config();
        $config['base_url']     = base_url('master/asset/index/offset/');
        $config['per_page']     = $limit; 
        $config['uri_segment']    = 5;
        $this->pagination->initialize($config); 

        $list   = $this->load->view('list_asset',$data,TRUE);
        echo $list;

    }
    function change_status($status=''){
      
      if(!empty($status))
        $this->db->set('status_print',$status);
     
      if(is_array($_POST['selected_item']))
        $this->db->where_in('id_item',$_POST['selected_item']);
      
      if(isset($_POST['barcode']))
        $this->db->where_in('barcode',$_POST['barcode']);
      
      $result=$this->db->update('mst_item');
      //echo $this->db->last_query();
      
      echo json_encode(array('error' => $this->db->_error_message()));
    }
    function change_status_pemasangan($status=''){
      
      if(!empty($status)){
        $this->db->set('status_pemasangan',$status);
        $this->db->set('user_tempel',$this->session->userdata('id_user'));
        $this->db->set('tanggal_tempel','now()',FALSE);
      }
      
      $this->db->where('barcode',$_POST['barcode']);
      $result=$this->db->update('mst_item');
     // echo $this->db->last_query();
      
      echo json_encode(array('error' => $this->db->_error_message()));
    }
    public function insert(){
      
          $frm             = $this->_form();
          $data['content'] = $this->load->view('form_asset',$frm,TRUE);
        
          $main = $this->load->module('main/main');

          $data['section']        = 'Master';
          $data['subsection']     = 'Asset';
          $main::demo_template($data);
    }
    function _form($selected=''){
        $data['item_name']            = array('name'=>'item_name','id'=>'item_name','class'=>'form-control','value'=>$selected['item_name']);
        $data['description']          = array('name'=>'description','id'=>'description','class'=>'form-control','value'=>$selected['description']);
        $data['barcode']              = array('name'=>'barcode','id'=>'barcode','class'=>'form-control','value'=>$selected['barcode']);
        $data['barcode_old']          = array('name'=>'barcode_old','id'=>'barcode_old','class'=>'form-control','value'=>$selected['barcode_old']);
        $data['opt_item_category']    = $this->global_model->getoptions('mst_item_category','id_item_category','category_name');
        return $data;
    }
    function submit(){
          $this->db->set('item_name', $this->input->post('item_name'));
          $this->db->set('description', $this->input->post('description'));
          $this->db->set('barcode', $this->input->post('barcode'));
          $this->db->set('barcode_old', $this->input->post('barcode_old'));
          $this->db->set('id_item_category', $this->input->post('id_item_categori'));
          $this->db->set('user_create', $this->session->userdata('id_user'));
          $this->db->set('tanggal_create','now()',false);
         
          if(!empty($_POST['id_item'])){
            $this->db->where('id_item',$_POST['id_item']);
            $result=$this->db->update('mst_item');
          }

          else
            $result=$this->db->insert('mst_item');
          


          
          if($result)
            redirect('master/asset/');  

  }
  function generate_barcode($barcode=222){
      
    ?>
    <img src="<?php echo base_url();?>master/asset/bikin_barcode/<?php  echo $barcode ?>">
 <?php }


  function bikin_barcode($kode='ss')  {
      
      $this->load->library('zend');
      $this->zend->load('Zend/Barcode');
      Zend_Barcode::render('code128', 'image', array('text'=>$kode), array());  
  }

 }