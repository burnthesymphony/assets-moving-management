<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth {

    var $AT = null;

    function __construct() {
        $this->AT = & get_instance();
        $this->AT->load->database();
    }

    function process_login($user, $pass) {
        $this->AT->db->where('username', $user);
        
        $this->AT->db->where('password', md5($pass));
        //$this->AT->db->where('status', 1);
        $eo = $this->AT->db->get('hik_user');

        if ($eo->num_rows == 1) {
            $login  = $eo->row_array();
            $id     = $login['id'];            
            $sess   = array('id' => $id,'nama'=>$login['fullname'], 'login' => TRUE, 'level' => $login['level'],'foto'=>$login['foto']);
            $this->AT->session->set_userdata($sess);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function logout(){

        $array_items =array('id' => '', 'login' => '', 'level' => '');
        $this->session->unset_userdata($array_items);
        
    }
}

?>
