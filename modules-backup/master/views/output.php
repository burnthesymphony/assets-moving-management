<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; 
	if(empty($width_list))
		$width_list="1024";

?>

<div style="min-width:<?php echo $width_list?>px;overflow:hidden"><?php echo $output; ?></div>
<script type="text/javascript">
	/*$(function(){
		$('#username_field_box').remove();
		sumber=$('#sumber_field_box').length;
		
		if(sumber=='1')
			$('#sumber_field_box').remove();
		if($('#foto_input_box img').length==1){ //Jika edit event rubah atribut src imagenya
			attr_src=$('#foto_input_box img').attr('src');
			new_attr=attr_src.replace("<?php echo base_url('files/image-sementara/'.$this->session->userdata('kode').'/')?>","<?php echo str_replace('admin/','',base_url('beranda/event/'.$this->session->userdata('kode').'/'))?>");
			$('#foto_input_box img').attr('src',new_attr);
		}

	})*/

</script>

<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
