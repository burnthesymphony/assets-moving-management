<?php
class Dashboard_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
    function jumlah_karyawan_by_tipe(){
    	$sql="SELECT a.id_tipe_karyawan,b.nama_tipe_karyawan, count(a.id_karyawan) as jumlah 
    			FROM mst_karyawan as a LEFT JOIN mst_tipe_karyawan as b on a.id_tipe_karyawan=b.id_tipe_karyawan 
    		  WHERE a.aktif='YA'GROUP BY a.id_tipe_karyawan";
    	$result=$this->db->query($sql)->result_array();
    	return $result;


    }
    function jumlah_karyawan_by_departemen(){
    	$sql="SELECT a.id_departemen,b.nama_departemen, count(a.id_karyawan) as jumlah 
    			FROM mst_karyawan as a LEFT JOIN mst_departemen as b on a.id_departemen=b.id_departemen 
    		  WHERE a.aktif='YA'GROUP BY a.id_departemen";
    	$result=$this->db->query($sql)->result_array();
    	return $result;
    }
}
