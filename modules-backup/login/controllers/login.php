<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login  extends MX_Controller  {
	
	
	public function __construct(){
		
		
		
		$this->load->model('global_model');
	}
	public function index()
	{
		
		error_reporting(E_ALL);
		
		if($this->session->userdata('logged_in')==TRUE){

			echo '<script>';

			echo 'location.href="'.base_url('dashboard/').'"';
			echo '</script>';
		}
		
		$data['username']	= array('name'=>'user_id','id'=>'loginUsername','value'=>'','class'=>'form-control','data-validation'=>'required','placeholder'=>'username');
		$data['password']	= array('name'=>'password','id'=>'loginPassword','value'=>'','class'=>'form-control','data-validation'=>'required','placeholder'=>'password');
		$data['action']		= 'login/cek_login';
		
		$this->load->view('form_login',$data);

	}
	function cek_login(){
		$data_login		= array('table'=>'mst_user','where'=>array('username'=>$_POST['user_id'],'password'=>md5($_POST['password'])),'data'=>'row');
		$cek			= $this->global_model->get_data($data_login);
		
		if(count($cek)==0){
			$this->session->sess_destroy();
			redirect(base_url('login'));
			
		}
		else{
			die('aaa');
			$newdata = array(

                   'id_user'  	=> $cek['id_user'],
                   'logged_in' 	=> TRUE,
				   'fullname' 	=> $cek['nama_lengkap'],
				   'id_otoritas'=> $cek['id_otoritas']

               );
			//$this->db->update('psh_master.mst_user', array('status_login'=>1), array('username' => $cek['id_user']));
			$this->session->set_userdata($newdata);
		
			redirect(base_url('dashboard/'));

			
		}
	}
	function logout(){
		$this->db->update('mst_user', array('status_login'=>0), array('id_user' => $this->session->userdata('id_user')));
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}
}
