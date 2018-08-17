<?php 
	echo '<div style="width:1150px;margin: 0 auto;height:500px;overflow-y:auto"><h1>Pilih Foto</h1>';
	foreach($result_image as $rec_image){
		echo '<div style="float:left;width:170px;padding:8px" align="center">
				<img width="150px" height="150px" src="'.base_url('files/images/'.$rec_image['filename']).'">
				<input type="checkbox" id_image="'.$rec_image['id'].'" class="foto_pilihan" name="foto_pilihan[]" value="'.$rec_image['filename'].'">
				</div>';
	}
	echo '<input type="hidden" name="offset" id="offset" value="'.$offset.'"> ';
	echo '<div id="other_image"></div>';
	echo '<div align="center" style=";clear:both"><input type="button" name="LoadMore" onclick="load_other_image()" value="Load More" style="width:400px" class="btn"></div></div>';
	echo '<div align="right" style="position: fixed;bottom: 26px;background: #000;width: 1212px;padding: 10px;margin-left: -16px;"><input type="button" name="PilihGambar" onclick="select_foto()" value="Pilih Gambar" class="btn"></div>';
?>
<script>
function load_other_image(){
	next_offset=parseInt($('#offset').val()) +parseInt('<?php echo $image_per_load?>');
	$('#other_image').html('<div align="center" id="image_loading" style="clear:both;"><i>...Please Wait...</i></div>');
	$.post('<?php echo base_url("admin/news/load_other_images/")?>/'+next_offset,function(data){
		$('#image_loading').remove();
		$('#other_image').append(data);
		$('#offset').val(next_offset);
	});

}
function select_foto(){
	var values = new Array();
	$.each($("input[name='foto_pilihan[]']:checked"), function() {
		rand_= rand_=Math.floor((Math.random()*100)+1);
  		$('#gambar_pilihan').append('<div style="width: 100px;float: left;" align="center" id="terpilih_'+rand_+'"><a style="font-size: 11px;color: #000;text-decoration: none;vertical-align: top;float: left;" href="javascript:;" onclick="hapus_id(\'terpilih_'+rand_+'\')"><img  src="<?php echo base_url('assets/grocery_crud/themes/flexigrid/css/images/close.png')?>">Hapus Foto</a><br><img width="80px" height="80px" src="<?php echo base_url('files/images/')?>/'+$(this).val()+'"> <input type="hidden" name="selected_photo[]" value="'+$(this).attr('id_image')+'" ><br>'+
  									'<br>Is Primary<br><input type="hidden" name="primary_flag_pilih[]" value="'+rand_+'"><input type="radio" name="primary" value="'+rand_+'"></div>');
	});


	$.fancybox.close();
}
</script>