<?php 
class Resize_model  extends CI_Model {
    
    function resize($image_name=''){ 
       $this->load->library('image_lib');
        $ukuran_all                 = $this->config->item('img_size');
         $config['image_library']    = 'gd2';
        foreach($ukuran_all as $ukuran){
            
            ## cek jika foldernya belum di buat maka buat foldernya terlebih dahulu
            if(!file_exists(DIECTORY_IMAGE.$ukuran[2]))
                mkdir(DIECTORY_IMAGE.$ukuran[2]);
            
            $config['source_image']     = DIECTORY_IMAGE.$image_name;
            $config['create_thumb']     = FALSE;
            $config['maintain_ratio']   = FALSE;
            $config['width']            = $ukuran[0];
            $config['height']           = $ukuran[1];
            $config['new_image']        = DIECTORY_IMAGE.$ukuran[2].'/'.$image_name;

            $this->image_lib->initialize($config);
            if(!$this->image_lib->resize())
                echo $this->image_lib->display_errors();
             
            $this->image_lib->clear();
                
        }
        
    }
}