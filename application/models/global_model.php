<?php 
class Global_model extends CI_Model {
    function __construct()
    {
        parent::__construct();

    }

	public function get_data($array) ## COPY FUNGSI DARI PEK WISNU
	{
	    
	    
	    if (isset($array['table'])) {
	    	if (isset($array['select']))	$this->db->select($array['select']);
	    	
	    	if (isset($array['join']))		{
	    		
	    			for($i=0;$i<count($array['join']['table']);$i++){	
	    				$this->db->join($array['join']['table'][$i],$array['join']['on'][$i],$array['join']['method'][$i]);
	    			}
	    		}
    	   // if (isset($array['where_in']))     $this->db->where_in($array['where_in']);
    	    //if (isset($array['where'])) {
    	    //	$where_keys=array_keys($array['where']);
    	    //	foreach()
			if(is_array($array['where'])){
    	    		$this->db->where($array['where']);
				}
			if(isset($array['where_not_equal'])){
			if(is_array($array['where_not_equal'])){
    	    		foreach ($array['where_not_equal'] as $key => $value) {
    	    			$this->db->where($key.' != ',$value);
    	    		}
    	    		
				}
    	    }    
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
	function getoptions($tbl,$val,$label,$where=''){
		$query = $this->db->order_by($label,'ASC');
		$this->db->select(array($val ,$label));
		
		if(is_array($where)){
			$keys=array_keys($where);
			foreach($keys as $key){
				$this->db->where($key,$where[$key]);
			}
		}
		$query = $this->db->get($tbl);
		$opt['']= ucwords('--All Item--');
		foreach ($query ->result_array() as $rec){
			$opt[$rec[$val]]= ucwords($rec[$label]);
		}
		return $opt;
	}
	function get_set_values( $table , $field ){
		$query = "SHOW COLUMNS FROM $table LIKE '$field'";
		$result = $this->db->query( $query ) or die( 'Error getting Enum/Set field ' . mysql_error() );
		$row = $result->row_array();
		$search  = array("(", "'", ")","set");
		$replace = array('','','','');
		$set_ = str_replace($search, $replace, $row['Type']);
		$set_arr=explode(',',$set_);
		return $set_arr;
		
		//return $arOut ;
	}
	function get_enum_values($table_name , $column_name ){
		$result = $this->db->query("SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
       								WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = '$column_name'");

    	$row 		= $result->row_array();

   	 	$enumList 	= explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));
   	 	    	
    	foreach ($enumList as $key => $value) {
    		$opt[$value]=$value;
    	}
    	
   	 	return $opt;
	}
	
	function pagination_config($total_rows=3000){
		$config['full_tag_open']	= '<ul class="pagination pagination-sm no-margin pull-right">';
		$config['full_tag_close'] 	= '</ul>';
		$config['first_tag_open'] 	= '<li>';
		$config['first_tag_close'] 	= '</li>';
		$config['last_tag_open'] 	= '<li>';
		$config['last_tag_close'] 	= '</li>';
		$config['num_tag_open'] 	= '<li>';
		$config['num_tag_close'] 	= '</li>';
		$config['cur_tag_open'] 	= '<li><a style="background:#C0C0C0">';
		$config['cur_tag_close'] 	= '</li></a>';
		$config['prev_tag_open'] 	= '<li>';
		$config['prev_tag_close'] 	= '</li>';
		$config['next_tag_open'] 	= '<li>';
		$config['next_tag_close'] 	= '</li>';
		$config['total_rows'] 		= $total_rows;
		return $config;
	}
	
}