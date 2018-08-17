<?php class Content extends MX_Controller {

    
    function __construct() {
  
        
       parent::__construct();
        $this->load->database();
        $this->load->library('grocery_CRUD');
        
	    $this->load->library(array('session','General'));
        $this->load->helper(array('url','form','resize'));
       
        $auth = $this->load->module('main/auth');
        $main = $this->load->module('main/main');
        $auth::session_check();

         
     }
     
     function berita(){
      error_reporting(0);
     	$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('tbl_berita');
			$crud->unset_print();
			$crud->unset_export();
			$crud->set_subject('Berita');
  		$crud->columns(array('judul','penulis','tanggal','berita','username','jenis'));
      $crud->order_by('Id','DESC');
      $crud->display_as('jenis','foto');

      $crud->callback_column('jenis',array($this,'_ganti_path_foto'));
      $crud->callback_before_insert(array($this,'set_session_user'));
      $crud->callback_before_update(array($this,'set_session_user'));
      $crud->callback_before_upload(array($this,'_callback_before_upload'));
      $crud->callback_after_insert(array($this, '_after_insert_resize'));
      $crud->callback_after_update(array($this, '_after_insert_resize'));
      
      $kode        = $this->session->userdata('kode');
      
      ## Remove and add session halaman bekerja
      $this->session->unset_userdata(array('edited_section'=>''));
      $this->session->set_userdata(array('edited_section'=>'berita'));
      
      $upload_path ='files/Berita-PISEW/';

      if(!file_exists($upload_path));
          mkdir($upload_path.'/'.$kode, 0755);

      $crud->set_field_upload('jenis',$upload_path);
      $output = $crud->render();
      $data['content'] = $this->load->view('output',$output,TRUE);
   	
  	  $main = $this->load->module('main/main');
      $data['menu']           = $main->get_menu();
      $data['section']        = 'Content';
      $data['subsection']     = 'Berita';
      $main::default_template($data);

     }
     function event(){

      //error_reporting(E_ALL);
      $crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('tbl_event');
			$crud->unset_print();
			$crud->unset_export();
			$crud->set_subject('Event');
	    $crud->columns(array('judul','penulis','tanggal','foto','isi'));
      $crud->unset_add_fields('foto1','foto2');
      $crud->unset_edit_fields('foto1','foto2');
      ## Remove and add session halaman bekerja
      $this->session->unset_userdata(array('edited_section'=>''));
      $this->session->set_userdata(array('edited_section'=>'event'));

      $crud->callback_column('foto',array($this,'_ganti_path_foto'));
      $crud->callback_before_insert(array($this,'set_session_user'));
      $crud->callback_before_update(array($this,'set_session_user'));
      
      $crud->callback_after_upload(array($this,'_callback_after_upload_event'));
      $crud->callback_after_insert(array($this, '_after_insert_event'));
      $crud->callback_after_update(array($this, '_after_insert_event'));
      
      $kode        = $this->session->userdata('kode');
      
      

      $upload_path ='files/image-sementara/';
     
      $crud->set_field_upload('foto',$upload_path);
      $output                  = $crud->render();
      $main                    = $this->load->module('main/main');
      $data['menu']            = $main->get_menu();
      $data['section']         = 'Content';
      $data['subsection']      = 'Event';
      $data['content']         = $this->load->view('output',$output,TRUE);
      $data['public_path']     = "http://localhost/pnpm2014";
   	
  	
  	$main::default_template($data);

     }
     function _callback_after_upload_event($uploader_response,$field_info, $files_to_upload){
        error_reporting(E_ALL);
                    /*
             * Examples of what the $uploader_response, $files_to_upload and $field_info will be:
            $uploader_response = Array
                (
                    [0] => stdClass Object
                        (
                            [name] => 6d9c1-52.jpg
                            [size] => 495375
                            [type] => image/jpeg
                            [url] => http://grocery_crud/assets/uploads/files/6d9c1-52.jpg
                        )
             
                )
             
            $field_info = stdClass Object
            (
                    [field_name] => file_url
                    [upload_path] => assets/uploads/files
                    [encrypted_field_name] => sd1e6fec1
            )
             
            $files_to_upload = Array
            (
                    [sd1e6fec1] => Array
                    (
                            [name] => 86.jpg
                            [type] => image/jpeg
                            [tmp_name] => C:\wamp\tmp\phpFC42.tmp
                            [error] => 0
                            [size] => 258177
                    )
             
            )
            */   
        $public_path=$_SERVER['DOCUMENT_ROOT'].'/pnpm2014/';
        $encrypt=$field_info->encrypted_field_name;
        foreach($uploader_response as $response){ }
        $kode        = $this->session->userdata('kode');
       
       if(!file_exists($public_path.'beranda/event/'.$kode.'/'))
                mkdir($public_path.'beranda/event/'.$kode.'/', 0755);
        


       $path_sementara     = $public_path.'admin/files/image-sementara/'.$response->name;
       $image_real_event   = $public_path.'beranda/event/'.$kode.'/'.$response->name;

       
        if(!copy($path_sementara, $image_real_event))
            die('ERROR ON UPLOAD');
        

     }
     function _after_insert_event($post_array,$primary_key){
        $file_sementara=$_SERVER['DOCUMENT_ROOT'].'/pnpm2014/admin/files/image-sementara/'.$post_array['foto'];
        unlink($file_sementara);
       // $this->_after_insert_resize($post_array,$primary_key);
        return true;
        die;

     }
     function _after_insert_resize($post_array,$primary_key){
         if($this->session->userdata('edited_section')=='berita'){

            $config_small['source_image']  = './files/Berita-PISEW/'.$post_array['jenis'];
            $config_small['new_dir']       = './files/Berita-PISEW/'.$this->session->userdata('kode').'/small';
            $config_small['new_image']     = './files/Berita-PISEW/'.$this->session->userdata('kode').'/small/'.str_replace($this->session->userdata('kode').'/','', $post_array['jenis']);
            $config_small['width']         = 140;
            $config_small['height']        = 140;

            $config_medium['source_image'] = './files/Berita-PISEW/'.$post_array['jenis'];
            $config_medium['new_dir']      = './files/Berita-PISEW/'.$this->session->userdata('kode').'/medium';
            $config_medium['new_image']    = './files/Berita-PISEW/'.$this->session->userdata('kode').'/medium/'.str_replace($this->session->userdata('kode').'/', '', $post_array['jenis']);
            $config_medium['width']        = 550;
            $config_medium['height']       = 330;
         }
         if($this->session->userdata('edited_section')=='artikel'){

            $config_small['source_image']  = './files/Artikel-PISEW/'.$post_array['foto'];
            $config_small['new_dir']       = './files/Artikel-PISEW/'.$this->session->userdata('kode').'/small';
            $config_small['new_image']     = './files/Artikel-PISEW/'.$this->session->userdata('kode').'/small/'.str_replace($this->session->userdata('kode').'/','', $post_array['foto']);
            $config_small['width']         = 140;
            $config_small['height']        = 140;

            $config_medium['source_image'] = './files/Artikel-PISEW/'.$post_array['foto'];
            $config_medium['new_dir']      = './files/Artikel-PISEW/'.$this->session->userdata('kode').'/medium';
            $config_medium['new_image']    = './files/Artikel-PISEW/'.$this->session->userdata('kode').'/medium/'.str_replace($this->session->userdata('kode').'/', '', $post_array['foto']);
            $config_medium['width']        = 550;
            $config_medium['height']       = 330;
         }
         if($this->session->userdata('edited_section')=='best_practice'){

            $config_small['source_image']  = './files/Bestpractice-PISEW/'.$post_array['foto'];
            $config_small['new_dir']       = './files/Bestpractice-PISEW/'.$this->session->userdata('kode').'/small';
            $config_small['new_image']     = './files/Bestpractice-PISEW/'.$this->session->userdata('kode').'/small/'.str_replace($this->session->userdata('kode').'/','', $post_array['foto']);
            $config_small['width']         = 140;
            $config_small['height']        = 140;

            $config_medium['source_image'] = './files/Bestpractice-PISEW/'.$post_array['foto'];
            $config_medium['new_dir']      = './files/Bestpractice-PISEW/'.$this->session->userdata('kode').'/medium';
            $config_medium['new_image']    = './files/Bestpractice-PISEW/'.$this->session->userdata('kode').'/medium/'.str_replace($this->session->userdata('kode').'/', '', $post_array['foto']);
            $config_medium['width']        = 550;
            $config_medium['height']       = 330;
         }
          
          $this->resize_image($config_small);
          $this->resize_image($config_medium);


     }
     function resize_image($config){

        error_reporting(E_ALL);
        new_resize($config);
     }
     function editorial(){
         	$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('tbl_redaksi');
			$crud->unset_print();
			$crud->unset_export();
			$crud->set_subject('Editorial');
  			$crud->columns(array('judul','penulis','tanggal','isi'));
            $crud->unset_add_fields('attach');
            $crud->unset_edit_fields('attach');
			$output = $crud->render();
            ## Remove and add session halaman bekerja
            $this->session->unset_userdata(array('edited_section'=>''));
            $this->session->set_userdata(array('edited_section'=>'editorial'));

			$data['content'] = $this->load->view('output',$output,TRUE);
         	
        	$main = $this->load->module('main/main');
            $data['menu']           = $main->get_menu();
            $data['section']        = 'Content';
            $data['subsection']     = 'Editorial';
        	$main::default_template($data);

     }
       function best_practice(){
        $crud = new grocery_CRUD();

        $crud->set_theme('datatables');
        $crud->set_table('tbl_bestpractice');
        $crud->unset_print();
        $crud->unset_export();
        $crud->set_subject('Best Practice');
        $crud->columns(array('judul','penulis','tglentry','isi','file','foto'));
        $crud->callback_before_upload(array($this,'_callback_before_upload'));
        ## Remove and add session halaman bekerja
        $kode= $this->session->userdata('kode');
        $this->session->unset_userdata(array('edited_section'=>''));
        $this->session->set_userdata(array('edited_section'=>'best_practice'));

        $upload_path ='files/Bestpractice-PISEW/';

        if(!file_exists($upload_path));
          mkdir($upload_path.$kode.'/', 0755);

        $crud->set_field_upload('foto',$upload_path);
        $crud->set_field_upload('file',$upload_path);
        $crud->callback_before_insert(array($this,'set_session_user'));
        $crud->callback_before_update(array($this,'set_session_user'));
        $crud->callback_after_insert(array($this, '_after_insert_resize'));
        $crud->callback_after_update(array($this, '_after_insert_resize'));
        
        $output = $crud->render();



        $data['content'] = $this->load->view('output',$output,TRUE);

        $main = $this->load->module('main/main');
        $data['menu']           = $main->get_menu();
        $data['section']        = 'Content';
        $data['subsection']     = 'Best Practice';
        $main::default_template($data);

     }
     function artikel(){
            //error_reporting(E_ALL);
        $crud = new grocery_CRUD();
        $crud->set_theme('datatables');
        $crud->set_table('tbl_tulisan');
        $crud->unset_print();
        $crud->unset_export();
        $crud->set_subject('Artikel');
        $crud->columns(array('judul','penulis','tanggal','isi','foto','file'));

        ## Remove and add session halaman bekerja
        $kode= $this->session->userdata('kode');
        $this->session->unset_userdata(array('edited_section'=>''));
        $this->session->set_userdata(array('edited_section'=>'artikel'));
        $upload_path ='files/Artikel-PISEW/';

        if(!file_exists($upload_path));
            mkdir($upload_path.$kode.'/', 0755);

        $crud->set_field_upload('foto',$upload_path);
        $crud->set_field_upload('file',$upload_path);
        $crud->callback_before_insert(array($this,'set_session_user'));
        $crud->callback_before_update(array($this,'set_session_user'));
        $crud->callback_before_upload(array($this,'_callback_before_upload'));
        $crud->callback_after_insert(array($this, '_after_insert_resize'));
        $crud->callback_after_update(array($this, '_after_insert_resize'));

        $crud->callback_column('foto',array($this,'_ganti_path_foto'));
        $crud->callback_column('file',array($this,'_ganti_path_file'));

        $output = $crud->render();

        $data['content'] = $this->load->view('output',$output,TRUE);

        $main = $this->load->module('main/main');
        $data['menu']           = $main->get_menu();
        $data['section']        = 'Content';
        $data['subsection']     = 'Artikel';
        $main::default_template($data);

     }
     function pengumuman(){
     	    $crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('tbl_pengumuman');
			$crud->unset_print();
			$crud->unset_export();
			$crud->set_subject('Pengumuman');
            $this->session->unset_userdata(array('edited_section'=>''));
            $this->session->set_userdata(array('edited_section'=>'pengumuman'));
              $crud->callback_before_insert(array($this,'set_session_user'));
  			$crud->callback_before_update(array($this,'set_session_user'));
            //$crud->columns(array('judul','penulis','tanggal','isi'));
			$output = $crud->render();

			$data['content'] = $this->load->view('output',$output,TRUE);

         	
        	$main = $this->load->module('main/main');
            $data['menu']           = $main->get_menu();
            $data['section']        = 'Content';
            $data['subsection']     = 'Pengumuman';
        	$main::default_template($data);

     }
     function set_session_user($post_array){
        $post_array['username']     = $this->session->userdata('username');
        $kode                       = $this->session->userdata('kode');
        ## ganti isi field foto masing masing tabel di sesuaikan dengan kode kabupaten atau propinsinya
        if($this->session->userdata('edited_section')=='berita')
            $post_array['jenis']    = $kode.'/'.$post_array['jenis'];
        if($this->session->userdata('edited_section')=='event') 
            $post_array['foto']    = $kode.'/'.$post_array['foto'];
        if(($this->session->userdata('edited_section')=='best_practice') || ($this->session->userdata('edited_section')=='artikel')){
            $post_array['foto']    = $kode.'/'.$post_array['foto'];
            $post_array['file']    = $kode.'/'.$post_array['file'];
        }
        if($this->session->userdata('edited_section')=='pengumuman')
          $post_array['sumber']     = $this->session->userdata('username'); 


        return $post_array;

     }
     function _ganti_path_foto($value, $row){

        $path_public    = 'http://pnpm=pisew.org/';
        $kode           = $this->session->userdata('kode');
        
        if($this->session->userdata('edited_section')=='berita')
            $path_image = base_url('files/Berita-PISEW/'.$value);
        if($this->session->userdata('edited_section')=='event')
            $path_image = $path_public.'beranda/event/'.$value;
        if($this->session->userdata('edited_section')=='artikel')
           $path_image = base_url('files/Artikel-PISEW/'.$value);
        
        return '<img src="'.$path_image.'" height="50px">';
       

     }
     function _ganti_path_file($value, $row){
        $repl=str_replace($this->session->userdata('kode').'/', '', $value);
        
        if($this->session->userdata('edited_section')=='artikel')
            $path_file=base_url('files/Artikel-PISEW/'.$value);
        
        return '<a href="'.$path_file.'">'.$repl.'</a>';
     }
     function _callback_before_upload($files_to_upload,$field_info)
     {
            /*
             * Examples of what the $files_to_upload and $field_info will be:    
            $files_to_upload = Array
            (
                    [sd1e6fec1] => Array
                    (
                            [name] => 86.jpg
                            [type] => image/jpeg
                            [tmp_name] => C:\wamp\tmp\phpFC42.tmp
                            [error] => 0
                            [size] => 258177
                    )
             
            )
             
            $field_info = stdClass Object
            (
                    [field_name] => file_url
                    [upload_path] => assets/uploads/files
                    [encrypted_field_name] => sd1e6fec1
            )
             
            */
            $kode   = $this->session->userdata('kode');
            $curent_path_upload = $field_info->upload_path;
            $field_info->upload_path=$curent_path_upload.'/'.$kode; 
           // print_r($field_info)            ;
     }
 }
  