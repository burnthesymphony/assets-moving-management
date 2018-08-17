<?php
class Admin_model extends CI_Model {
	var $imagePath = 'files/media/produk/video';
 
    function __construct() {
        parent::__construct();
		//error_reporting(E_ALL);
	}
	
	function _insert($field='',$table=''){
		if(is_array($field)){
			$key_fields= array_keys($field);
			
			foreach($key_fields as $key){
				$time_function=array('now()','cur_date()','date()','timestamp()');
				if(in_array(strtolower($field[$key]), $time_function))
					$this->db->set($key, $field[$key], FALSE);
				else
					$this->db->set($key, $field[$key], TRUE);
			}
			
			$this->db->insert($table);
			return array('last_id'=>$this->db->insert_id(),'error_message'=>$this->db->_error_message());
		}
		else{
			return array('error_message'=>'No data Inserted');
		}
		
	}
	function get_data($array)	{
	    
	    
	    if (isset($array['table'])) {
	    	if (isset($array['select']))	$this->db->select($array['select']);
	    	
	    	if (isset($array['join']))		{
	    		
	    			for($i=0;$i<count($array['join']['table']);$i++){	
	    				$this->db->join($array['join']['table'][$i],$array['join']['on'][$i],$array['join']['method'][$i]);
	    			}
	    		}
    	    if (isset($array['where']))     $this->db->where($array['where']);
    	    if (isset($array['order_by']))  $this->db->order_by($array['order_by']['field'],$array['order_by']['type']);
    	    if (isset($array['group_by']))  $this->db->group_by($array['group_by']); 
    	    if (isset($array['limit']))  	$this->db->limit($array['limit'],$array['offset']); 
    	    
    	    $this->db->from($array['table']);

    	    if (isset($array['data']) && $array['data'] == 'row') 
    	    	return $this->db->get()->row_array();
    	   	else
    	   		return $this->db->get()->result_array();
	    } else
	        return array();
	}
	function get_jumlah_artikel($criteria=''){
		 error_reporting(E_ALL);
		
		if($this->session->userdata('level')==2)
			$criteria['user_id']=$this->session->userdata('id');
		
		$conf=array('select'=>'id','table'=>'hik_news','where'=>$criteria);
		$result = $this->admin_model->get_data($conf);
		return count($result);

	}
}