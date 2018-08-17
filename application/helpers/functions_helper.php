<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



function stripHTMLtags($str)
{
    $t = preg_replace('/<[^<|>]+?>/', '', htmlspecialchars_decode($str));
    $t = htmlentities($t, ENT_QUOTES, "UTF-8");
    return $t;
}

function cari_array($products, $needle = 0)
{
$needle = $needle;
//array_map(function ($a, $b) { return $a * $b; }, $origarray1, $origarray2);
    return array_filter($products, "categoryone");
  //  return array_filter($products, function($products) use($needle) {  return (is_array($products) && $products['parent']== $needle); });
}


function get_parent_menu(){
	error_reporting(E_ALL);
	$CI =& get_instance();
	$CI->load->model('global_model');
	
	$level=$CI->session->userdata('id_otoritas');
	$conf= array('table'	=> 'mst_otoritas_menu as a ',
				 'select'	=> 'b.*',
				 'where'	=> array('a.id_otoritas'=>$level,'parent'=>0,'b.aktif'=>'Y'),
				 'join' 	=> array('table'=>array('mst_menu as b'),'on'=>array('a.id_menu=b.id_menu'),'method'=>array('left')),
				 //'group_by'	=>'a.parent'
				);
	$result = $CI->global_model->get_data($conf);
	//echo $CI->db->last_query();
	return $result;
}
function get_menu($parent=0){
	error_reporting(E_ALL);
	$CI =& get_instance();
	$CI->load->model('global_model');
	
	$level=$CI->session->userdata('id_otoritas');
	$conf= array('table'	=> 'mst_otoritas_menu as a ',
				 'select'	=> 'b.*',
				 'where'	=> array('a.id_otoritas'=>$level,'parent'=>$parent,'b.aktif'=>'Y'),
				 'order_by' =>array('field'=>'a.urutan','type'=>'ASC'),
				 'join' 	=> array('table'=>array('mst_menu as b'),'on'=>array('a.id_menu=b.id_menu'),'method'=>array('left')),
				 //'group_by'	=>'a.parent'
				);
	$result = $CI->global_model->get_data($conf);
	
	return $result;
}

function hari($hari)		{
    		switch ($hari)
    		{
		         case 0 : $hari = "Minggu";
		                  return $hari;
		                  break;
		         case 1 : $hari = "Senin";
		                  return $hari;
		                  break;
		         case 2 : $hari = "Selasa";
		                 return $hari;
		                 break;
		         case 3 : $hari = "Rabu";
		                 return $hari;
		                  break;
		        case 4 : $hari = "Kamis";
		               return $hari;
		               break;
		        case 5 : $hari = "Jum\'at";
		               return $hari;
		               break;
		       case 6 : $hari = "Sabtu";
		               return $hari;
	               break;
			}
		}
 
		function bulan($bulan){
		
   			switch ($bulan)
   			{
		     case "01" : $bulan = " Januari";
		               return $bulan;
		               break;
		     case "02" : $bulan = " Februari"; 
		            return $bulan;
		                break;
		     case "03" : $bulan = " Maret"; 
		               return $bulan;
		               break;
		     case "04" : $bulan = " April"; 
		               return $bulan;
		               break;
		     case "05" : $bulan = " Mei"; 
		               return $bulan;
		               break;
		     case "06" : $bulan = " Juni";
		               return $bulan;
		               break;
		     case "07" : $bulan = " Juli";
		               return $bulan;
		               break;
		     case "08" : $bulan_ = " Agustus";
		               return $bulan_;
		               break;
		     case "09" : $bulan_ = " September";
		               return $bulan_;
		               break;
		     case "10" : $bulan = " Oktober"; 
		               return $bulan;
		               break;
		     case "11" : $bulan = " November"; 
		               return $bulan;
		               break;
		     case "12" : $bulan = " Desember"; 
		               return $bulan;
		               break;
    		}

		}
 
function hari_tanggalindo($tgl='')
{
   
   if($tgl=='' ||empty($tgl))
   	return '<div class="tanggal_artikel">&nbsp;</div>';
   else{
   $hari_sekarang = hari(date("w",strtotime($tgl)));
   $bln_sekarang = bulan(date("m",strtotime($tgl)));
   return '<div class="tanggal_artikel">'.$hari_sekarang.", ".date("d",strtotime($tgl)).$bln_sekarang.date(" Y",strtotime($tgl)).'</div>';
   }
}
function terbilang($satuan){  
$huruf = array ("", "satu", "dua", "tiga", "empat", "lima", "enam",   
"tujuh", "delapan", "sembilan", "sepuluh","sebelas");  
if ($satuan < 12)  
 return " ".$huruf[$satuan];  
elseif ($satuan < 20)  
 return terbilang($satuan - 10)." belas";  
elseif ($satuan < 100)  
 return terbilang($satuan / 10)." puluh".  
 terbilang($satuan % 10);  
elseif ($satuan < 200)  
 return "seratus".terbilang($satuan - 100);  
elseif ($satuan < 1000)  
 return terbilang($satuan / 100)." ratus".  
 terbilang($satuan % 100);  
elseif ($satuan < 2000)  
 return "seribu".terbilang($satuan - 1000);   
elseif ($satuan < 1000000)  
 return terbilang($satuan / 1000)." ribu".  
 terbilang($satuan % 1000);   
elseif ($satuan < 1000000000)  
 return terbilang($satuan / 1000000)." juta".  
 terbilang($satuan % 1000000);   

 elseif ($satuan < 1000000000000)
return terbilang($satuan / 1000000000) . " milyar" . terbilang($satuan % 1000000000);
elseif ($satuan < 1000000000000000)
return terbilang($x / 1000000000000) . " trilyun" . terbilang($satuan % 1000000000000); 

}
