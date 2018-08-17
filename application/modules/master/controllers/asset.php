<?php class Asset extends MX_Controller {

    
    function __construct() {
  
        
       parent::__construct();
        $this->load->database();
	     $this->load->library(array('session','General'));
        $this->load->helper(array('url','form','resize'));
        $auth = $this->load->module('main/auth');
        $main = $this->load->module('main/main');
        $auth::session_check();

         
     }
     
      function index($jenis=''){

          ## ASSET = BOX;
          $data['content'] = $this->_main($jenis);
      
          $main = $this->load->module('main/main');

          $data['section']        = 'Master';
          if($jenis=='box')
            $data['subsection']     = 'Box (Non Asset)';
          if($jenis=='item')
            $data['subsection']     = 'Item (Asset)';
          $main::demo_template($data);

     }
     function _main($jenis){
          $data   = $this->_form_cari();
          $data['jenis']=$jenis;
          $view   = $this->load->view('form_cari_asset',$data,TRUE);

          return $view;
     }
     function _form_cari($selected=''){
        $data['item_name']          = array('name'=>'item_name','id'=>'item_name','class'=>'form-control','value'=>$selected['item_name']);
        $data['barcode']            = array('name'=>'barcode','id'=>'barcode','class'=>'form-control','value'=>$selected['barcode']);
        $data['opt_item_category']  = $this->global_model->getoptions('mst_item_category','id_item_category','category_name');
        return $data;
     }
    function list_(){
        
        //print_r($_POST);
        $uri  = $this->uri->uri_to_assoc(4);
        $limit  = 25;
      
        if(isset($uri['offset']))
          $offset=$uri['offset'];
        else
          $offset=0;

        $where['a.aktif']='YA';

        if(isset($_POST['filter'])){
          foreach($_POST['filter'] as $key=>$value){
            if(!empty($_POST['filter'][$key]['value']))
            $where[$_POST['filter'][$key]['name']]=$_POST['filter'][$key]['value'];
          }
        }
        if($_POST['jenis']=='item')
          $where['a.id_item_category']=1;

        $parm      = array('table'  => 'mst_item as a',
                     'limit'=>$limit,
                     'offset'=>$offset,
                     'where' => $where,
                     'order_by'=>array('field'=>'id_item','type'=>'desc'),
                    'join'  => array('table'=>array('mst_item_category as b','mst_user as c'),
                                'on'=>array('b.id_item_category=a.id_item_category','a.user_create=c.id_user'),
                                'method'=>array('LEFT','LEFT')
                              ),
                'select'=>'a.*,b.category_name,c.nama_lengkap'
                );
      
        if($_POST['jenis']=='box')
         $parm['where_not_equal']=array('a.id_item_category'=>1);
        
        $data['result']     = $this->global_model->get_data($parm);

        //echo $this->db->last_query();
        $data['jenis']      = $_POST['jenis'];
        $data['offset']     = $offset;
        
        ## Pagination
        $parm['select']='count(a.id_item) as total_row';
        $parm['data'] ='row';
        unset($parm['limit']);
        unset($parm['offset']);
        $result_all     = $this->global_model->get_data($parm);
       
        $this->load->library('pagination');
        $config= $this->global_model->pagination_config($result_all['total_row']);
        $config['base_url']     = base_url('master/asset/index/offset/');
        $config['per_page']     = $limit; 
        $config['uri_segment']    = 5;
        $this->pagination->initialize($config); 
        $data['total_row'] = $result_all['total_row'];
        $list   = $this->load->view('list_asset',$data,TRUE);
        echo $list;

    }
    public function insert($jenis='',$id_item=''){
          
          if(!empty($id_item)){ ## jika EDIT
            $selected=$this->global_model->get_data(array('table'=>'mst_item','where'=>array('id_item'=>$id_item),'data'=>'row'));
          }
          $frm             = $this->_form($selected);
          $frm['selected']  = $selected;
          $frm['jenis']     = $jenis;
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
          //echo ''$_POST['id_item'];
          if(!empty($_POST['id_item'])){
            $this->db->where('id_item',$_POST['id_item']);
            $result=$this->db->update('mst_item');
          }

          else{
            $result=$this->db->insert('mst_item');
          }
          echo $this->db->last_query();


          
          //if($result)
           // redirect('master/asset/');  

  }
  function generate_barcode($barcode=222){
      
    ?>
    <img src="<?php echo base_url();?>master/asset/bikin_barcode/<?php  echo $barcode ?>" >
 <?php }


  function bikin_barcode($kode='ss/aa')  {
      
      $this->load->library('zend');
      $this->zend->load('Zend/Barcode');
      Zend_Barcode::render('code128', 'image', array('text'=>$kode), array());
      //  $imageResource = Zend_Barcode::render('code39', 'image', array('text'=>$kode), array() );  
        //echo $imageResource;
  }

  function list_item($id_box=''){
    $data['parent']= $id_box;
      $parm      = array('table'  => 'mst_item as a',
                          'where' => array('parent'=>$id_box),
                          'join'  => array('table'=>array('mst_item_category as b','mst_user as c'),
                                'on'=>array('b.id_item_category=a.id_item_category','a.user_create=c.id_user'),
                                'method'=>array('LEFT','LEFT')
                              ),
                'select'=>'a.*,b.category_name,c.nama_lengkap'
                );
      $data['result'] = $this->global_model->get_data($parm);
      $this->load->view('list_item',$data);

  }
  function insert_item(){
    $this->db->where('barcode',$_POST['barcode']);
    $this->db->or_where('barcode_old',$_POST['barcode']);
    $result= $this->db->update('mst_item',array('parent'=>$_POST['parent']));

    $error_message=$this->db->_error_message();
    if(empty($error_message)){
       $parm      = array('table'  => 'mst_item as a',
                          'where' => array('parent'=>$_POST['parent']),
                          'join'  => array('table'=>array('mst_item_category as b','mst_user as c'),
                                'on'=>array('b.id_item_category=a.id_item_category','a.user_create=c.id_user'),
                                'method'=>array('LEFT','LEFT')
                              ),
                'select'=>'a.*,b.category_name,c.nama_lengkap',
                'order_by'=>array('field'=>'id_item','type'=>'desc')
                );
      $result = $this->global_model->get_data($parm);
      foreach($result as $rec): 
      echo '<tr>
      <td>'.$rec['item_name'].'</td>
      <td>'.$rec['category_name'].'</td>
      <td>'.$rec['barcode'] .'</td>
      <td>'.$rec['barcode_old'] .'</td>
    </tr>';
    endforeach;
  

    }

  }
  function detail_item($id_item){
        $parm      = array('table'  => 'mst_item as a',
                          'where' => array('id_item'=>$id_item),
                          'join'  => array('table'=>array('mst_item_category as b','mst_user as c'),
                                'on'=>array('b.id_item_category=a.id_item_category','a.user_create=c.id_user'),
                                'method'=>array('LEFT','LEFT')
                              ),
                'select'=>'a.*,b.category_name,c.nama_lengkap','data'=>'row',
                'order_by'=>array('field'=>'id_item','type'=>'desc')
                );
      $result = $this->global_model->get_data($parm);
      return $result;
  }
  function hapus(){
    $this->db->delete('mst_item',array('id_item'=>$_POST['id_item']));
    echo $this->db->_error_message();
  }
  function update_barcode_item($id_item=''){

    $i=1;
    $result   = $this->db->get('mst_item')->result_array();
    foreach($result as $rec){
        $barcode=$rec['barcode_category'].$rec['barcode_departmen'].$rec['barcode_gate'].$rec['barcode_new_location'].str_pad($rec['id_item'], 4, "0", STR_PAD_LEFT);
        
        if(!empty($rec['barcode_category'])){
          $this->db->where('id_item',$rec['id_item']);
          $this->db->update('mst_item',array('barcode'=>$barcode));
          $i++;
        }
    }
    echo $i.' data telah di update';


  }
  function isi_box($id_box){
     $parm      = array('table'  => 'mst_item as a',
                          'where' => array('parent'=>$id_box),
                          'join'  => array('table'=>array('mst_item_category as b','mst_user as c'),
                                'on'=>array('b.id_item_category=a.id_item_category','a.user_create=c.id_user'),
                                'method'=>array('LEFT','LEFT')
                              ),
                'select'=>'a.*,b.category_name,c.nama_lengkap',
                'order_by'=>array('field'=>'id_item','type'=>'desc')
                );
      $result = $this->global_model->get_data($parm);
      return $result;
  }

 }