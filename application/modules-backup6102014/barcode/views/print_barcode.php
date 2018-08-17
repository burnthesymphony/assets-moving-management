<?php 	$ass=$this->load->module('master/asset'); ?>
<?php 
	foreach($result as $rec){
		echo '<div>';
		$ass::generate_barcode($rec['barcode']);
		echo '</div>';
	}
?>