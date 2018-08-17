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
	function get_data_karyawan($where){

		$sql="SELECT a.*, b.nama_tipe_karyawan, c.nama_propinsi, d.nama_kabupaten_kota, e.nama_kabupaten_kota as kota_lahir, 
					f.nama_bank, g.nama_departemen 
				FROM (mst_karyawan as a) 
				LEFT JOIN mst_tipe_karyawan as b  ON a.id_tipe_karyawan=b.id_tipe_karyawan 
				LEFT JOIN mst_propinsi as c ON a.id_propinsi=c.id_propinsi 
				LEFT JOIN mst_kabupaten_kota as d ON d.id_kabupaten_kota=a.id_kabupaten_kota 
				LEFT JOIN mst_kabupaten_kota as e ON e.id_kabupaten_kota=a.id_kota_lahir 
				LEFT JOIN mst_bank as f ON f.id_bank=a.id_bank 
				LEFT JOIN mst_departemen as g ON g.id_departemen=a.id_departemen 
				WHERE a.aktif='YA' ".$where ;
	
		$result=$this->db->query($sql);
	
			return $result->result_array();
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
	function get_salary($where){
		$parm     = array('table' => 'trs_payroll as a',
                 		  'where'=> $where,
                		  'join'  	=> array(
			                          'table'   =>array('trs_payroll_detail as b','mst_komponen_gaji as c'),
			                          'on'      =>array('a.id_payroll=b.id_payroll','b.id_komponen_gaji=c.id_komponen_gaji'),
			                          'method'  =>array('LEFT','LEFT')
                          			),
            'select'=>'b.*,c.nama_komponen_gaji'
            );
    	$result     = $this->global_model->get_data($parm);
    return $result;
	}
	function get_thp($id_karyawan,$bulan,$tahun){

      $sql="SELECT a.id_payroll ,
                  (SELECT SUM(b.jumlah) FROM trs_payroll_detail as b WHERE b.jenis='TUNJANGAN' and a.id_payroll=b.id_payroll) -
                  (SELECT SUM(c.jumlah) FROM trs_payroll_detail as c WHERE c.jenis='POTONGAN' and a.id_payroll=c.id_payroll) as thp
            FROM trs_payroll as a 
            WHERE a.tahun='".$tahun."' AND a.bulan=".$bulan." AND a.id_karyawan=".$id_karyawan;
      $result= $this->db->query($sql)->row_array();
      
      return $result['thp'];
  }
}