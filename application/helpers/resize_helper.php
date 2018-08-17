<?php
function resize($fpath, $fname = null, $w = null, $h = null)
	{
		$mode = 'album';
		if(!file_exists($fpath)) return false;
		
		if($fname == null) $fname = end(explode('/', $fpath));
		if(empty($w) || empty($h)) list($w, $h) = getimagesize($fpath);
		
		$sizes = $this->config->item("img_size_$mode");
		
		if(empty($sizes))
		{
			$sizes = $this->config->item('img_size');
		#	if($mode == 'album')
			{
				$album = $this->config->item('album_img_size');
				$sizes = array_merge($sizes, $album);
			}
		}
		
		foreach($sizes as $name => $size)
		{
			list($width, $height) = $size;
			
			$path  = realpath(UPLOAD_PATH . "images/$name");
			if(!file_exists($path)) mkdir($path);
			$path .= "/".$fname;
			$resize = array();
			
			if($w == $width && $h == $height)
			{
				copy($fpath, $path);
				continue;
			}
			
			$resize['source_image'] = $fpath;
			$resize['new_image'] = $path;
			$resize['maintain_ratio'] = false;
			
			if(($w / $h) > ($width / $height))
			{
				$resize['master_dim'] = 'height';
				$resize['height'] = $height;
				$resize['width'] = ($height / $h) * $w;
			}
			else
			{
				$resize['master_dim'] = 'width';
				$resize['width'] = $width;
				$resize['height'] = ($width / $w) * $h;
			}
			
			$this->image_lib->initialize($resize);
			$this->image_lib->resize();
			$this->image_lib->clear();
			
			list($img_width, $img_height) = getimagesize($path);
			
			$crop['source_image'] = $path;
			$crop['maintain_ratio'] = false;
			$crop['width'] = $width;
			$crop['height'] = $height;
			$crop['x_axis'] = ($img_width - $width) / 2;
			$crop['y_axis'] = ($img_height - $height) / 2;
			
			$this->image_lib->initialize($crop);
			$this->image_lib->crop();
			$this->image_lib->clear();
		}
		
		return $fname;
	}

function new_resize($config){
		$ci =&get_instance();
	   if(!file_exists($config['new_dir']))
            mkdir($config['new_dir'], 0777);

	    
    	$ci->image_lib->initialize($config);   
    	if ( ! $ci->image_lib->resize())
    		echo $ci->image_lib->display_errors();
		

    	print_r($config);

}