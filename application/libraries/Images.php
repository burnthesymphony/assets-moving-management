<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
/**
 * Handle common image manipulation using the CI image_lib class.
 * 
 * @category   Webcoding.CMS
 * @package    Webcoding_Library
 * @name Images.php
 * @version 1.0
 * @author Jarolewski Piotr
 * @copyright Webcoding Jarolewski Piotr
 * @created: 13.01.2011
 */
 
 class Images
 {
     private $CI;
     
     public function __construct()
     {
         $this->CI = & get_instance();
     }
     
     /**
     * Resize Images and Crop width and height
     * 
     * @param $oldFile Full path and filename of original image
     * @param $newFile The full destination path and filename
     * @param $width The new width new image
     * @param $height The new height new image     
     * @return void
     */
     
     public function resize($oldFile, $newFile, $width, $height)
     {
        $obj =& get_instance();
        
        $info = pathinfo($oldFile);        
        
        $tempFile = '/asset/media/temp/' . $info['filename'] . '-' . $width . 'x' . $height . '.' . $info['extension'];
        $newFile = $newFile;
        
        //if image already exists, use it
        if(file_exists('.' .$newFile))
            return $newFile;

        //math for resize/crop without loss
        $o_size = $this->_get_size($oldFile);        
        
        $master_dim = ($o_size['width']-$width < $o_size['height']-$height?'width':'height');
        
        $perc = max( (100*$width)/$o_size['width'] , (100*$height)/$o_size['height']  );
        
        $perc = round($perc, 0);
        
        $w_d = round(($perc*$o_size['width'])/100, 0);        
        $h_d = round(($perc*$o_size['height'])/100, 0);
        
                // end math stuff

        /*
         *    Resize image
         */
        $config['image_library'] = 'gd2';
        $config['source_image'] = $oldFile;
        $config['new_image'] = '.' . $tempFile;
        $config['maintain_ratio'] = TRUE;
        $config['master_dim'] = $master_dim;
        $config['width'] = $w_d + 1;
        $config['height'] = $h_d + 1;

	$this->CI->load->library('image_lib', $config);
        $this->CI->image_lib->initialize($config);
        
        $this->CI->image_lib->resize();
        
        $size = $this->_get_size($tempFile);    

        unset($config); // clear $config

        /*
         *    Crop image  in weight, height
         */
         
        $config['image_library'] = 'gd2';
        $config['source_image'] = '.' . $tempFile;
        $config['new_image'] = '.' . $newFile;
        $config['maintain_ratio'] = FALSE;
        $config['width'] = $width;
        $config['height'] = $height;
        $config['y_axis'] = round(($size['height'] - $height) / 2);
        $config['x_axis'] = 0;

        $this->CI->image_lib->clear();
        $this->CI->image_lib->initialize($config);
        if ( ! $this->CI->image_lib->crop())
        {
            echo $this->CI->image_lib->display_errors();
        }
        
        $info = pathinfo($newFile);        
        
        return $newFile;
     }
     
     private function _get_size($image)
     {
         $img = getimagesize($image);
         return Array('width'=>$img['0'], 'height'=>$img['1']);
    }
     
 }  
