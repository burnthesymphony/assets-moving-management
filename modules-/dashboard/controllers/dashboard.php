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
         
        // die("asdasd");
	    
        
     }
     
     function index(){
        $main                   = $this->load->module('main/main');
        $data['content']        ='';
      
        $data['section']        = 'Dashboard';
        $data['subsection']     = 'Dashboard';
        $main::default_template($data);

     }
    function news_list($status='published') {
        error_reporting(1);

        $crud =  new grocery_CRUD();
        $crud->set_theme('flexigrid');
        
        $crud->set_table('hik_news');
        $crud->where('aktif',1);
        $crud->set_subject('Berita');
        $crud->columns(array('date','title','user_id','channel_id','views','status'));
        $crud->add_fields('title','subtitle','content','status','date','channel_id','source','reporter','user_id','is_headline','is_pilihan','is_sticky','Pilih_Foto','Upload_Foto');
        $crud->edit_fields('title','subtitle','content','status','date','channel_id','source','reporter','user_id','is_headline','is_pilihan','is_sticky','list_foto','Pilih_Foto','Upload_Foto');
        
        

        ## RULES
        $crud->required_fields('title','content','status','channel_id','reporter');
        if($this->session->userdata('level')==2){ ## Member
             $crud->add_fields('title','subtitle','content','date','channel_id','source','reporter','user_id','Pilih_Foto','Upload_Foto');
            $crud->edit_fields('title','subtitle','content','date','channel_id','source','reporter','user_id','list_foto','Pilih_Foto','Upload_Foto');
        }
        else{
             $crud->add_fields('title','subtitle','content','status','date','channel_id','source','reporter','user_id','is_headline','is_pilihan','is_sticky','Pilih_Foto','Upload_Foto');
             $crud->edit_fields('title','subtitle','content','status','date','channel_id','source','reporter','user_id','is_headline','is_pilihan','is_sticky','list_foto','Pilih_Foto','Upload_Foto');
        }
        if($status=='published')
            $crud->where('status',1);
        if($status=='draft')
            $crud->where('status',0);
        if($this->session->userdata('level')<>1) ## JIKA BUKAN ROOT MAKA TAMPILKAN ARTIKEL SESUAI DENGAN USER ID nya
            $crud->where('user_id',$this->session->userdata('id'));
        ## END RULES
        $crud->set_relation('channel_id','hik_channel','channel');
        $crud->set_relation('user_id','hik_user','fullname');
        
        $crud->unset_export();
        $crud->unset_print();
        $crud->unset_edit_fields(array('views'));
        $crud->unset_add_fields(array('views'));
        
        $crud->field_type('status','dropdown',array('0'=>'Draft','1' => 'Publish'));
        $crud->field_type('date','invisible');
        $crud->display_as('channel_id','Channel');
        
        $crud->callback_add_field('is_headline',array($this,'add_headline_checkbox'));
        $crud->callback_add_field('is_sticky',array($this,'add_sticky_checkbox'));
        $crud->callback_add_field('is_pilihan',array($this,'add_pilihan_checkbox'));
        $crud->callback_add_field('Pilih_Foto',array($this,'_call_back_pilih_gambar'));
        $crud->callback_add_field('Upload_Foto',array($this,'_call_back_upload_foto'));

        $crud->callback_edit_field('is_headline',array($this,'add_headline_checkbox'));
        $crud->callback_edit_field('is_sticky',array($this,'add_sticky_checkbox'));
        $crud->callback_edit_field('list_foto',array($this,'_get_list_foto'));
        $crud->callback_edit_field('is_pilihan',array($this,'add_pilihan_checkbox'));
        $crud->callback_edit_field('Pilih_Foto',array($this,'_call_back_pilih_gambar'));
        $crud->callback_edit_field('Upload_Foto',array($this,'_call_back_upload_foto'));
        
        $crud->callback_delete(array($this,'_delete_news'));
        $crud->callback_before_insert(array($this,'set_session_user'));
        $crud->callback_after_insert(array($this, '_insert_image_news'));
        $crud->callback_after_update(array($this, '_after_update'));
        
       
        $output = $crud->render();
        $data['section']    = 'Artikel';
        $data['subsection'] = $status;
        $data['content'] = $this->load->view('admin/output',$output,true);
        
        $this->load->view('admin/new_template', $data);
    }
    function news_list_old() {
        error_reporting(1);

        $crud =  new grocery_CRUD();
        $crud->set_theme('flexigrid');
        
        $crud->set_table('hik_news');
        $crud->where('aktif',1);
        $crud->set_subject('Berita');
        $crud->columns(array('date','title','user_id','channel_id','views','status'));
        $crud->add_fields('title','subtitle','content','status','date','channel_id','source','reporter','user_id','is_headline','is_pilihan','is_sticky','Pilih_Foto','Upload_Foto');
        $crud->edit_fields('title','subtitle','content','status','date','channel_id','source','reporter','user_id','is_headline','is_pilihan','is_sticky','list_foto','Pilih_Foto','Upload_Foto');
        
        ## RULES
        $crud->required_fields('title','content','status','channel_id','reporter');

        $crud->set_relation('channel_id','hik_channel','channel');
        $crud->set_relation('user_id','hik_user','fullname');
        
        $crud->unset_export();
        $crud->unset_print();
        $crud->unset_edit_fields(array('views'));
        $crud->unset_add_fields(array('views'));
        
        $crud->field_type('status','dropdown',array('0'=>'Draft','1' => 'Publish'));
        $crud->field_type('date','invisible');
        $crud->display_as('channel_id','Channel');
        
        $crud->callback_add_field('is_headline',array($this,'add_headline_checkbox'));
        $crud->callback_add_field('is_sticky',array($this,'add_sticky_checkbox'));
        $crud->callback_add_field('is_pilihan',array($this,'add_pilihan_checkbox'));
        $crud->callback_add_field('Pilih_Foto',array($this,'_call_back_pilih_gambar'));
        $crud->callback_add_field('Upload_Foto',array($this,'_call_back_upload_foto'));

        $crud->callback_edit_field('is_headline',array($this,'add_headline_checkbox'));
        $crud->callback_edit_field('is_sticky',array($this,'add_sticky_checkbox'));
        $crud->callback_edit_field('list_foto',array($this,'_get_list_foto'));
        $crud->callback_edit_field('is_pilihan',array($this,'add_pilihan_checkbox'));
        $crud->callback_edit_field('Pilih_Foto',array($this,'_call_back_pilih_gambar'));
        $crud->callback_edit_field('Upload_Foto',array($this,'_call_back_upload_foto'));
        
        $crud->callback_delete(array($this,'_delete_news'));
        $crud->callback_before_insert(array($this,'set_session_user'));
        $crud->callback_after_insert(array($this, '_insert_image_news'));
        $crud->callback_after_update(array($this, '_after_update'));
        
       
        $output = $crud->render();
       
        $data['content'] = $this->load->view('admin/output',$output,true);
        
        $this->load->view('admin/template', $data);
    }
    function _delete_news($news_id){
        $this->db->update('news',array('aktif'=>0),array('id'=>$news_id));
        echo $this->db->last_query();
        $log=array('news_id'=>$news_id,'status'=>'DELETE','user_id'=>$this->session->userdata("id"),'date'=>date('Y-m-d H:i:s'));
        echo $this->db->last_query();
        $this->_log_news($log);


    }
    function _get_list_foto($value,$news_id){
        error_reporting(1);
       
        
        $conf                   = array('table'=>'hik_news_image as a','select'=>'a.primary,b.id,b.filename,b.caption,b.source',
                                        'join'=>array('table'   =>array('hik_image as b'),
                                                      'on'      =>array('a.image_id=b.id'),
                                                      'method'  =>array('LEFT')
                                                      ),
                                        'where'=>array('a.news_id'=>$news_id),
                                        );
        $result_image           = $this->admin_model->get_data($conf);
       

        echo '<div>';
        foreach($result_image as $rec_image){
        $rand=rand();
           $image.= ' <div style="width: 100px;float: left;" align="center" id="terpilih_'.$rand.'">
                        <a style="font-size: 11px;color: #000;text-decoration: none;vertical-align: top;float: left;" href="javascript:;" onclick="hapus_id(\'terpilih_'.$rand.'\')">
                            <img  src="'.base_url('assets/grocery_crud/themes/flexigrid/css/images/close.png').'">Hapus Foto</a>
                            <img width="80px" height="80px" src="'.base_url('files/images/'.$rec_image['filename']).'">
                        <input type="hidden" name="selected_photo[]" value="'.$rec_image['id'].'" ><br>
                        <br>Is Primary<br><input type="hidden" name="primary_flag_pilih[]" value="'.$rand.'">';
           if($rec_image['primary']==1)
                $image.='<input type="radio" name="primary" value="'.$rand.'" checked="checked">';           
            else
                $image.='<input type="radio" name="primary" value="'.$rand.'">';

            $image.='</div>';
        }
        echo '</div>';
        return $image;
    }
    function _after_update($post_array,$news_id){
        $this->db->delete('hik_news_image',array('news_id'=>$news_id));
        $this->_insert_image_news($post_array,$news_id,'update');
    }
    function _insert_image_news($post_array,$last_news_id,$action='insert')
    {
    
        
        ## UPLOAD IMAGE
        $this->load->library('upload');
        $files = $_FILES;
        $cpt = count($_FILES['foto']['name']);
        for($i=0; $i<$cpt; $i++)
        {   

                $_FILES['userfile']['name']= $files['foto']['name'][$i];
                $_FILES['userfile']['type']= $files['foto']['type'][$i];
                $_FILES['userfile']['tmp_name']= $files['foto']['tmp_name'][$i];
                $_FILES['userfile']['error']= $files['foto']['error'][$i];
                $_FILES['userfile']['size']= $files['foto']['size'][$i]; 

                $this->upload->initialize($this->set_upload_options());
                if($this->upload->do_upload()){
                        $this->upload->data();
                        $ext            = pathinfo($files['foto']['name'][$i], PATHINFO_EXTENSION);
                        $img_ext_chk    = array('jpg','png','gif','jpeg','JPG','PNG', 'GIF', 'JPEG');
                        if(in_array($ext,$img_ext_chk)){
                            ## INSERT TABLE IMAGE
                            $field_image=array('filename'   => $_FILES['userfile']['name'],
                                               'caption'    => $_POST['caption_foto'][$i],
                                               'source'     => $_POST['source_foto'][$i],
                                               'user_id'   => $this->session->userdata("id")); 
                            
                            $insert_image=$this->admin_model->_insert($field_image,'hik_image');
                            
                            $last_image_id=$insert_image['last_id'];
                
                            if($_POST['primary_flag_upload'][$i]==$_POST['primary'])
                                $primary=1;
                            else
                                $primary=0;
                            $field_news_image=array('news_id'   => $last_news_id,
                                                    'image_id'  => $last_image_id,
                                                    'primary'   => $primary);
                            $this->admin_model->_insert($field_news_image,'hik_news_image');

                            ##RESIZE IMAGE
                             
                            $this->resize_model->resize($_FILES['userfile']['name']); 


                        }
                 }
               
        }
        ## INSERT DATA IMAGE DARI PILIH FOTO
        if(isset($_POST['selected_photo'])){
            $selected_photo=$_POST['selected_photo'];
            $a=0;
            foreach($selected_photo as $photo_id){
                $primary_flag=$_POST['primary_flag_pilih'][$a];
                if($primary_flag == $_POST['primary'] )
                    $primary=1;
                else
                    $primary=0;

                $field_news_image=array('news_id'=> $last_news_id,'image_id'=>$photo_id,'primary'=> $primary);
                $this->admin_model->_insert($field_news_image,'hik_news_image'); 
                //echo 'Query FROM CHOOSE'.$this->db->last_query().'<br>';               
            $a++;
            }

        }

                            
        ## INSERT LOG FILE                    
        if($action=='insert')
            $status_log ='CREATE';
        else
            $status_log = "UPDATE";

        $log=array('news_id'=>$last_news_id,'status'=>$status_log,'user_id'=>$this->session->userdata("id"),'date'=>date('Y-m-d H:i:s'));
       
        $this->_log_news($log);
        //die;
      
    }
    function _log_news($data=''){
          $this->admin_model->_insert($data,'hik_news_log');
    }
    private function set_upload_options()
    {   
    
        $config = array();
        $config['upload_path'] = DIECTORY_IMAGE;
        $config['allowed_types'] = 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG|pdf|doc|docx|xls|xlsx';
        $config['max_size'] = '0'; // 0 = no file size limit
        $config['max_width']  = '0';
        $config['max_height']  = '0';
        $config['overwrite'] = TRUE;
        return $config;
    }

    function pilih_foto($offset=0){
        $data['image_per_load'] = 12;
        $data['offset']         = $offset;
        $conf                   = array('table'=>'hik_image','select'=>'id,filename,caption','limit'=> $data['image_per_load'],'where'=>array('user_id'=>$this->session->userdata('id')),'offset'=>$offset);
        $data['result_image']   = $this->admin_model->get_data($conf);
        $this->load->view('admin/list_image',$data);
    }
    
    function load_other_images($offset){
        $conf                   = array('table'=>'hik_image','select'=>'id,filename,caption','limit'=>'12','where'=>array('user_id'=>$this->session->userdata('id')),'offset'=>$offset);
        $result_image           = $this->admin_model->get_data($conf);
        foreach($result_image as $rec_image){
            echo '<div style="float:left;width:170px;padding:8px" align="center">
                    <img width="150px"  height="150px" src="'.base_url('files/images/'.$rec_image['filename']).'">
                    <input type="checkbox" id_image="'.$rec_image['id'].'" class="foto_pilihan" name="foto_pilihan[]" value="'.$rec_image['filename'].'">
            </div>';
        }
    }

    function _call_back_pilih_gambar($value=''){
       return '<a  class="fancybox btn" data-fancybox-type="ajax" href="'.site_url('admin/news/pilih_foto/').'">Pilih Foto</a>
                <div id="gambar_pilihan" style="margin-top: 15px;"></div>';
    }
    function _call_back_upload_foto($value=''){
        $rand=rand();
        return '<input type="file" name="foto[]" value="">
                <br><br>Caption&nbsp;&nbsp;<input type="text" name="caption_foto[]" value="">
                <br><br>Source   &nbsp;&nbsp;<input type="text" name="source_foto[]" value=""><br>
                <br>Is Primary &nbsp;&nbsp;<input type="hidden" name="primary_flag_upload[]" value="'.$rand.'"><input type="radio" name="primary" value="'.$rand.'">
                <div id="add_foto"></div><br><input type="button" name="tambah_upload" value="Add Photo" onclick="add_foto()">';
    }
    function set_session_user($post_array){

        $post_array['user_id']  = $this->session->userdata("id"); 
        $post_array['date']     = date('Y-m-d H:i:s');

        return $post_array;
    }
    
    function add_headline_checkbox($value=''){
       $check=$this->create_checkbox('is_headline',$value);
       return     $check;
    }
    
    function add_sticky_checkbox($value=''){
       $check=$this->create_checkbox('is_sticky',$value);
       return     $check;
    }
    
    function add_pilihan_checkbox($value=''){
       $check=$this->create_checkbox('is_pilihan',$value);
       return     $check;
    }    
    
    function create_checkbox($nama,$value){
        if($value==1)
            return '<input type="checkbox" checked="checked"  value=1 name="'.$nama.'" >';
        else
            return '<input type="checkbox"  value=1 name="'.$nama.'" >';
    }
    function resize_image(){
      
          $this->resize_model->resize('bill.jpg');
       
        //echo 'ini Resize';
    }
}