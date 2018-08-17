
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
	

	function hapus_id(id){
		$('#'+id).remove();
	}
</script>
