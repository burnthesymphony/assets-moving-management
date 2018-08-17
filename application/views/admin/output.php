
<link rel="stylesheet" type="text/css" href='<?php echo base_url('assets/fancybox/jquery.fancybox.css?v=2.1.5') ?>' media="screen" />
<?php 
foreach($css_files as $file): ?>
<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />

<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<script type="text/javascript" src="<?php echo base_url('assets/fancybox/jquery.fancybox.js?v=2.1.5"') ?>"></script>
<?php echo $output; ?>
<script>
	$(function(){
		$('#user_id_field_box').remove(); /*GC Bug Avoid*/
		$(".fancybox").fancybox({
				maxWidth	: 1200,
				maxHeight	: 800,
				fitToView	: true,
				width		: '100%',
				height		: '100%',
				autoSize	: false,
				closeClick	: false,
				openEffect	: 'none',
				closeEffect	: 'none'
		});
	})
	
	function add_foto(){
		rand_=Math.floor((Math.random()*100)+1);
		$('#add_foto').append('<div id="upload'+rand_+'"><br><br><input type="file" name="foto[]" value="">'+
			'<br><br>Caption&nbsp;&nbsp;<input type="text" name="caption_foto[]" value="">'+
			'<br><br>Source   &nbsp;&nbsp;<input type="text" name="source_foto[]" value="">'+
			'<br>Is Primary &nbsp;&nbsp;<input type="hidden" name="primary_flag_upload[]" value="'+rand_+'"><input type="radio" name="primary" value="'+rand_+'">'+
			'<br><a href="javascript:;" onclick="hapus_id(\'upload'+rand_+'\')">'+
			'&nbsp;&nbsp;<img style="margin-top: -65px;position: absolute;margin-right: 327px;right: 0;" src="<?php echo base_url('assets/grocery_crud/themes/flexigrid/css/images/close.png')?>"></a></div>');
	}
	function hapus_id(id){
		$('#'+id).remove();
	}
</script>
