<?php
if ($type_form == 'post') {
    echo "<h3>Tambah slider</h3>";
    echo form_open_multipart('admin/slider/add');
} else {
    echo "<h3>Edit slider</h3>";
    echo form_open_multipart('admin/slider/update');
}
?>
 <?php echo form_error('images'); ?>
 <?php echo form_error('background'); ?>
 <?php echo form_error('status'); ?>
 <script src="<?php echo STATICPATH;?>js/jquery.minicolors.js" type="text/javascript"></script>
 <link href="<?php echo STATICPATH;?>css/jquery.minicolors.css" rel="stylesheet" type="text/css">

    
       <input type="hidden" name="id" id="id" value="<?php if(isset ($isi['id'])) echo $isi['id'];  ?>" />
    
   
        <div class="frm">
                <label for="images">images</label>
                   <?php echo form_upload('image');?>
         </br></div>
 
        <div class="frm">
                <label for="background">background</label>
                   <input type="text" name="background" id="background" value="<?php if(isset ($isi['background'])) echo $isi['background'];?>" /> 
	
		</br></div>
<script>
$('#background').minicolors();
</script>
 
        <div class="frm">
                <label for="url">URL</label>
                   <input type="text" name="url" id="url" value="<?php if(isset ($isi['url'])) echo $isi['url'];?>" /> 
         </br></div>
 
        <div class="frm">
                <label for="status">status</label>
            <?php echo form_dropdown('status', $option_status,$isi['status']); ?>         
         </br></div>
 
 
<div class="frm">   
               <?php if ($type_form == 'post') { ?>
            <input type="submit" name="post" value="Submit" />
               <?php } else {  ?>

            <input type="submit" name="update" value="update" />       
            
                <?php } ?>

<div class="frm">
</form>
