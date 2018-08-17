<?php 
class master extends CI_Controller {
        
    function __construct() {
        parent::__construct();
        $this->load->library('grocery_CRUD');
        $this->load->database();
		// $this->output->enable_profiler(TRUE);
	    $this->load->library(array('session','General'));
        $this->load->helper(array('url','form'));
        if ($this->session->userdata("login") != TRUE) {
            $this->session->set_flashdata('login_notif','<p>You must be logged in</p>');
            redirect('admin_login', 'refresh');
        }
        $this->load->model('admin_model'); 
        
     }

    function channel() {
         error_reporting(1);

        $crud =  new grocery_CRUD();
        $crud->set_theme('flexigrid');
        $crud->set_table('hik_channel');
        $crud->set_subject('Channel');
        $crud->unset_export();
        $crud->unset_print();
         ## RULES
        $crud->required_fields('channel','parent','slug');
        $crud->set_rules('parent','integer');
        $data['section']    = 'Master';
        $data['subsection'] = 'Channel';
        $output = $crud->render();
        $data['content'] = $this->load->view('admin/output_master',$output,true);
        $this->load->view('admin/new_template', $data);
    }
     function user() {
         error_reporting(1);

        $crud =  new grocery_CRUD();
        $crud->set_theme('flexigrid');
        $crud->set_table('hik_user');
        $crud->set_subject('User');
        $crud->unset_export();
        $crud->unset_print();
        $crud->callback_before_insert(array($this, '_set_password'));
        $crud->callback_before_update(array($this, '_before_update_user'));
        $crud->set_relation('level','hik_otoritas','nama_otoritas');
        $crud->set_field_upload('foto','files/images/user');
        $crud->field_type('password', 'password');
        $crud->set_rules('level','integer');
        $crud->set_rules('Email','email');

        $last_segment = count($this->uri->segment_array());
        $data['section']    = 'Master';
        $data['subsection'] = 'User';
        $status_edit = $this->uri->segment($last_segment);
        if($status_edit=='edit_profile'){
            $crud->unset_back_to_list();
            $crud->callback_after_update(array($this, '_after_update_profile'));
            ?>
            <script src="<?php echo base_url('assets/js/jquery.js')?>"></script>
            <script>
            $(function(){
                    $('#report-success').remove();   
                           
            });
               
            </script>
            <?php
             $data['section']    = 'Profile';
             $data['subsection'] = 'Edit Profil';
        }

        $output = $crud->render();
        $data['content'] = $this->load->view('admin/output_master',$output,true);
        $this->load->view('admin/new_template', $data);
    }
    function _email_($value){
        return '<input type="email" name="email" value=>';
    }
    function _set_password($post_array){
        $post_array['password']  = md5($post_array['password']); 
       
        return $post_array;
    }
    function _after_update_profile($post_array,$user_id){
        ?>
        <script type="text/javascript">alert('aaa');window.location = '<?php base_url('admin/master/profilsaya') ?>';</script>
        <?php
        //return false;
        //header('location:/');
 
    }
    function _before_update_user($post_array,$user_id){
        $conf                   = array('table'=>'hik_user','select'=>'password','where'=>array('id'=>$user_id,'password'=>$post_array['password']));
        $result_user            = $this->admin_model->get_data($conf);
        if(count($result_user)==0)
           $post_array['password']  = md5($post_array['password']);  

        return $post_array;       
    }
    function profilsaya(){
        error_reporting(E_ALL);
        $data['content']        = 'Profil saya';
        $conf_profile           = array('table'=>'hik_user',
                                        'data'=>'row',
                                        'where'=>array('id'=>$this->session->userdata('id'),)
                                        );
        $data2['profile']        = $this->admin_model->get_data($conf_profile);

        $conf_artikel           = array('table'=>'hik_news','select'=>'title,date,content,views,status','where'=>array('user_id'=>$this->session->userdata('id')),'order_by'=>array('field'=>'id','type'=>'desc'));
        $data2['result_artikel'] = $this->admin_model->get_data($conf_artikel);
        $data['content']        = $this->load->view('admin/profile_saya',$data2,true);
        $data['section']    = 'Profile';
        $data['subsection'] = 'Profil saya';
        $this->load->view('admin/new_template', $data);
    }
    function editprofil(){
        redirect('admin/master/user/edit/'.$this->session->userdata('id').'/2/edit_profile');
    }
    function  menu(){
         error_reporting(1);

        $crud =  new grocery_CRUD();
        $crud->set_theme('flexigrid');
        $crud->set_table('hik_menu');
        $crud->set_subject('Master Menu');
        $crud->unset_export();
        $crud->unset_print();
         ## RULES
        $crud->required_fields('nama_menu','parent','id_menu');
        $crud->set_rules('parent','integer');
        $crud->set_relation('parent','hik_menu','nama_menu');
        
        $output = $crud->render();
        $data['section']    = 'Master';
        $data['subsection'] = 'menu';
        $data['content'] = $this->load->view('admin/output_master',$output,true);
        $this->load->view('admin/new_template', $data);
    }
    function otoritas_menu(){
        error_reporting(1);

        $crud =  new grocery_CRUD();
        $crud->set_theme('flexigrid');
        $crud->set_table('hik_otoritas');
        $crud->set_subject('Pengaturan Otoritas  Menu');
        $crud->set_relation_n_n('menu', 'hik_otoritas_menu', 'hik_menu', 'id_otoritas', 'id_menu', 'nama_menu');
        //$crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');
        $crud->unset_export();
        $crud->unset_print();
         ## RULES
        //$crud->required_fields('nama_menu','parent','id_menu');
       // $crud->set_rules('parent','integer');
       // $crud->set_relation('parent','hik_menu','nama_menu');
        
        $output = $crud->render();
         $data['section']    = 'Master';
        $data['subsection'] = 'Otoritas Menu';
        $data['content'] = $this->load->view('admin/output_master',$output,true);
        $this->load->view('admin/new_template', $data);
    }
    function otoritas(){
          error_reporting(1);

        $crud =  new grocery_CRUD();
        $crud->set_theme('flexigrid');
        $crud->set_table('hik_otoritas');
        $crud->set_subject('Master otoritas');
        $crud->unset_export();
        $crud->unset_print();
         ## RULES
        $crud->required_fields('nama_otoritas','aktif');
        $crud->set_rules('aktif');
        
        
        $output = $crud->render();
        $data['section']    = 'Master';
        $data['subsection'] = 'Otoritas';
        $data['content'] = $this->load->view('admin/output_master',$output,true);
        $this->load->view('admin/new_template', $data);
    }
    
}