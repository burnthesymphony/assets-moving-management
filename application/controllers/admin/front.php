<?php

class Front extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library(array('session','General'));
 
         if ($this->session->userdata("login") != TRUE) {
           $this->session->set_flashdata('login_notif','<p>You must be logged in</p>');
            redirect('admin_login', 'refresh');
        }
        $this->load->model('admin_model');
    }

    function index_old() {
        $data['content']='admin/front';
        $this->load->view('admin/template',$data);
    }
    function index() {
        error_reporting(E_ALL);
        $beranda['total_draft_artikel']         = $this->admin_model->get_jumlah_artikel(array('status'=>0,'aktif'=>1));
        $beranda['total_published_artikel']     = $this->admin_model->get_jumlah_artikel(array('status'=>1,'aktif'=>1));
        $beranda['total_blocked_artikel']       = $this->admin_model->get_jumlah_artikel(array('status'=>-1,'aktif'=>1));
        $beranda['total_reported_artikel']      = $this->admin_model->get_jumlah_artikel(array('is_reported'=>1,'aktif'=>1));

        $conf=array('select'    =>'a.id,a.title,a.views,a.user_id,b.fullname',
                    'table'     =>'hik_news as a',
                    'where'     =>array('a.status'=>1),
                    'join'      =>array('table'     =>array('hik_user as b'),
                                        'on'        =>array('a.user_id=b.id'),
                                        'method'    =>array('LEFT')
                                 ),
                    'order_by'  =>array('field'=>'views','type'=>'DESC'),
                    'limit'     =>5,
                    'offset'    =>0
                    );
        $beranda['top_news']    = $this->admin_model->get_data($conf);
        $data['content']        = $this->load->view('admin/beranda',$beranda,TRUE);
        $data['section']        = 'Dashboard';
        $data['subsection']     = 'Beranda';
        $this->load->view('admin/new_template',$data);
    }
    function logout(){
         $this->session->sess_destroy();
         redirect('admin_login', 'refresh');
    }

}
?>
