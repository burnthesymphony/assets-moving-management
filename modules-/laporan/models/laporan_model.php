<?php 
class Laporan_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

	public function rekapitulasi($where='') ## COPY FUNGSI DARI PEK WISNU
	{
			/*$sql="SELECT c.id_departemen,sum(a.jumlah) FROM trs_payroll_detail as a LEFT JOIN  trs_payroll as b on a.id_payroll=b.id_payroll  LEFT JOIN mst_karyawan as c on b.id_karyawan=c.id_karyawan WHERE a.jenis='TUNJANGAN' GROUP BY c.id_departemen"*/
			
			if(is_array($where)){
				$keys=array_keys($where);
				foreach($keys as $key){
					if(!empty($where[$key]))
					$this->db->where($key,$where[$key]);		
				}
			}
			$this->db->select('d.nama_departemen');
			$this->db->select_sum('a.jumlah');
			$this->db->join('trs_payroll as b','a.id_payroll=b.id_payroll','LEFT');
			$this->db->join('mst_karyawan as c','b.id_karyawan=c.id_karyawan','LEFT');
			$this->db->join('mst_departemen as d','c.id_departemen=d.id_departemen','LEFT');
			
			
			$this->db->group_by('c.id_departemen');
			$query = $this->db->get('trs_payroll_detail as a');
			//echo $this->db->last_query().'<br>';

			if(!empty($where['c.id_departemen']))
			return $query->row_array();
				else
			return $query->result_array();
	}
}