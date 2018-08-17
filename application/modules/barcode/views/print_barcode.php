<style>
	@page {
  
}
@media print {
  html, body {
    width: 100mm;
    height: 80mm;
     
     margin: 0px !important;
  }
  
  .break_ {page-break-before: always}
}

</style>
<?php 	$ass=$this->load->module('master/asset'); ?>
<?php 
	foreach($result as $rec){
		echo '<div>';
		$ass::generate_barcode($rec['barcode']);
		echo '</div> <div class="break_">&nbsp;</div>';
	}
?>