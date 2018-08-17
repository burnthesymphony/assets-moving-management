<?php class Item extends MX_Controller {

    
    function __construct() {
  
        
       parent::__construct();
        $this->load->database();
	     $this->load->library(array('session','General'));
        $this->load->helper(array('url','form','resize'));
        $auth = $this->load->module('main/auth');
        $main = $this->load->module('main/main');
        $auth::session_check();

         
     }
     
      function index(){
 
        $crud = new grocery_CRUD();
          
         $crud->set_theme('datatables');
         $crud->set_table('mst_karyawan');
         $crud->unset_print();
         $crud->unset_export();
         $crud->set_subject('Karyawan');
         $crud->unset_edit();
         $crud->unset_read();
         $crud->add_action('View', '', base_url('master/form_karyawan/view/').'/','ui-icon-document');
         $crud->add_action('Edit', '', base_url('master/form_karyawan/edit/').'/','ui-icon-pencil');
         
         $crud->columns(array('nik','nama_karyawan','id_kota_lahir','tanggal_lahir','id_tipe_karyawan','id_departemen'));
         
         $crud->set_relation('id_tipe_karyawan','mst_tipe_karyawan','nama_tipe_karyawan');
         $crud->set_relation('id_propinsi','mst_propinsi','nama_propinsi');
         $crud->set_relation('id_kabupaten_kota','mst_kabupaten_kota','nama_kabupaten_kota');
         $crud->set_relation('id_kota_lahir','mst_kabupaten_kota','nama_kabupaten_kota');
         $crud->set_relation('id_bank','mst_bank','nama_bank');
         $crud->set_relation('id_departemen','mst_departemen','nama_departemen');
         
         $crud->unset_texteditor('alamat','full_text')->unset_texteditor('pengalaman_kerja','full_text')
              ->unset_texteditor('hobi','full_text')->unset_texteditor('pengalaman_berorganisasi','full_text')
              ->unset_texteditor('pendidikan_non_formal','full_text');
         
         $crud->display_as('id_tipe_karyawan','Status Karyawan')->display_as('id_propinsi','Propinsi')
              ->display_as('id_kabupaten_kota','Kab / Kota')->display_as('id_bank','Bank')
              ->display_as('id_kota_lahir','Tempat Lahir')->display_as('id_departemen','Departemen');
          
          $output = $crud->render();
          
          //$output->width_list="2834";

          $data['content'] = $this->load->view('output',$output,TRUE);
      
          $main = $this->load->module('main/main');

          $data['section']        = 'Master';
          $data['subsection']     = 'Karyawan';
          $main::default_template($data);

     }
     function user(){
        $crud = new grocery_CRUD();
          
        $crud->set_theme('datatables');
        $crud->set_table('mst_user');
        $crud->unset_print();
        $crud->unset_export();
        $crud->set_subject('User');
        $crud->set_relation('id_otoritas','mst_otoritas','nama_otoritas');
        $crud->display_as('id_otoritas','Otoritas');
        $crud->change_field_type('password', 'password');
        $crud->callback_before_insert(array($this,'encrypt_pass'));
        
        $crud->fields('username','password','id_otoritas','nama_lengkap','aktif');
        $output = $crud->render();
        $data['content'] = $this->load->view('output',$output,TRUE);
        $main = $this->load->module('main/main');

        $data['section']        = 'Master';
        $data['subsection']     = 'User';
        $main::default_template($data);
     }
	 function jabatan(){
		$crud = new grocery_CRUD();
          
        $crud->set_theme('datatables');
        $crud->set_table('mst_jabatan');
        $crud->unset_print();
        $crud->unset_export();
        $crud->set_subject('jabatan');
        $crud->set_relation('id_departemen','mst_departemen','nama_departemen');
        $crud->fields('id_departemen','nama_jabatan');
        $crud->display_as('id_departemen','nama_departemen');
              
        $output = $crud->render();
        $data['content'] = $this->load->view('output',$output,TRUE);
        $main = $this->load->module('main/main');

        $data['section']        = 'Master';
        $data['subsection']     = 'Jabatan';
        $main::default_template($data);
	 }
	 function level_karyawan(){
		$crud = new grocery_CRUD();
          
        $crud->set_theme('datatables');
        $crud->set_table('mst_level_karyawan');
        $crud->unset_print();
        $crud->unset_export();
        $crud->set_subject('Level karyawan');
       
        $crud->fields('nama_level_karyawan');
      
              
        $output = $crud->render();
        $data['content'] = $this->load->view('output',$output,TRUE);
        $main = $this->load->module('main/main');

        $data['section']        = 'Master';
        $data['subsection']     = 'Level Karyawan';
        $main::default_template($data);
	 }
     function encrypt_pass($post_array){
      $post_array['password']=md5($post_array['password']);
      return $post_array;
    }
     function bank(){
 
     	$crud = new grocery_CRUD();
        
			$crud->set_theme('datatables');
			$crud->set_table('mst_bank');
			$crud->unset_print();
			$crud->unset_export();
			$crud->set_subject('Bank');
  
      
    
      $output = $crud->render();
      
      $data['content'] = $this->load->view('output',$output,TRUE);
   	
  	  $main = $this->load->module('main/main');

      $data['section']        = 'Master';
      $data['subsection']     = 'Bank';
      $main::default_template($data);

     }
      function persentase_jamsostek(){
 
      $crud = new grocery_CRUD();
        
      $crud->set_theme('datatables');
      $crud->set_table('mst_config_jamsostek');
      $crud->unset_print();
      $crud->unset_export();
      $crud->unset_add();
      $crud->unset_delete();
      $crud->unset_read();
      $crud->set_subject('Persentase Jamsostek');
     // $crud->columns(array('jenis,jumlah'));
      $crud->display_as('jumlah','jumlah(%)');
    
      $output = $crud->render();
      
      $data['content'] = $this->load->view('output',$output,TRUE);
    
      $main = $this->load->module('main/main');

      $data['section']        = 'Persentase';
      $data['subsection']     = 'Jamsostek';
      $main::default_template($data);

     }
	  function meal_config(){
 
      $crud = new grocery_CRUD();
        
      $crud->set_theme('datatables');
      $crud->set_table('mst_config_meal');
      $crud->unset_print();
      $crud->unset_export();
      $crud->unset_add();
      $crud->unset_delete();
      $crud->unset_read();
      $crud->set_subject('Konfigurasi Uang Makan Per hari');
     // $crud->columns(array('jenis,jumlah'));
      $crud->display_as('jumlah','jumlah(Rp)');
    
      $output = $crud->render();
      
      $data['content'] = $this->load->view('output',$output,TRUE);
    
      $main = $this->load->module('main/main');

      $data['section']        = 'Konfigurasi';
      $data['subsection']     = 'Uang Makan';
      $main::default_template($data);

     }
     function departemen(){
 
      $crud = new grocery_CRUD();
        
      $crud->set_theme('datatables');
      $crud->set_table('mst_departemen');
      $crud->unset_print();
      $crud->unset_export();
      $crud->set_subject('Departemen');
  
      
    
      $output = $crud->render();
      
      $data['content'] = $this->load->view('output',$output,TRUE);
    
      $main = $this->load->module('main/main');

      $data['section']        = 'Master';
      $data['subsection']     = 'Departemen';
      $main::default_template($data);

     }
    function tipe_karyawan(){
 
      $crud = new grocery_CRUD();
        
      $crud->set_theme('datatables');
      $crud->set_table('mst_tipe_karyawan');
      $crud->unset_print();
      $crud->unset_export();
      $crud->set_subject('Tipe Karyawan');
  
      
    
      $output = $crud->render();
      
      $data['content'] = $this->load->view('output',$output,TRUE);
    
      $main = $this->load->module('main/main');

      $data['section']        = 'Master';
      $data['subsection']     = 'Tipe Karyawan';
      $main::default_template($data);

     }
      function komponen_gaji(){
 
      $crud = new grocery_CRUD();
        
      $crud->set_theme('datatables');
      $crud->set_table('mst_komponen_gaji');
      $crud->unset_print();
	  $crud->unset_delete();
      $crud->unset_export();
      $crud->set_subject('Komponen gaji');
  
      
    
      $output = $crud->render();
      
      $data['content'] = $this->load->view('output',$output,TRUE);
    
      $main = $this->load->module('main/main');

      $data['section']        = 'Master';
      $data['subsection']     = 'Komponen Gaji';
      $main::default_template($data);

     }
     function form_karyawan($tipe='insert',$id_karyawan=''){
        
        $form_anak                = $this->_form_karyawan('','data_anak');
        $form_pendidikan          = $this->_form_karyawan('','pendidikan');
        $form_pengalaman          = $this->_form_karyawan('','pengalaman_kerja');
        if(($tipe=='edit') || ($tipe=='view')){
            $selected_personal                				= $this->global_model->get_data(array('table'=>'mst_karyawan','where'=>array('id_karyawan'=>$id_karyawan),'data'=>'row'));
            $form_anak['selected_anak']            			= $this->global_model->get_data(array('table'=>'mst_karyawan_anak','where'=>array('id_karyawan'=>$id_karyawan)));
            $form_pendidikan['selected_pendidikan']      	= $this->global_model->get_data(array('table'=>'mst_karyawan_pendidikan','where'=>array('id_karyawan'=>$id_karyawan)));
            $form_pengalaman['selected_pengalaman_kerja']	= $this->global_model->get_data(array('table'=>'mst_karyawan_working_experience','where'=>array('id_karyawan'=>$id_karyawan)));
          
        }
        else{
            $selected_personal                = '';
            $data['selected_anak']            = '';
            $data['selected_pendidikan']      = '';
            $data['selected_pengalaman_kerja']= '';
        }
        $main                     = $this->load->module('main/main');
        $form_personal            = $this->_form_karyawan($selected_personal,'personal');
        $data['form_personal']    = $this->load->view('form_personal',$form_personal,TRUE);
        $data['form_anak']        = $this->load->view('form_anak',$form_anak,TRUE);
        $data['form_pendidikan']  = $this->load->view('form_pendidikan',$form_pendidikan,TRUE);
        $data['form_pengalaman']  = $this->load->view('form_pengalaman',$form_pengalaman,TRUE);
        $data['action']           = $tipe;
        $data['content']          = $this->load->view('form_karyawan',$data,TRUE);
        $data['section']          = 'Masukan';
        $data['subsection']       = 'Data Karyawan';
        $main::default_template($data);
     }
     function get_kabupaten_kota_dropdown($nama_dropdown,$selected=''){
        $opt = $this->global_model->getoptions('mst_kabupaten_kota','id_kabupaten_kota','nama_kabupaten_kota',array('id_propinsi'=>$_POST['id_propinsi']));
        echo form_dropdown($nama_dropdown,$opt,$selected,'id="'.$nama_dropdown.'" class="form-control" style="width:200px"');
     }
	 function get_jabatan_dropdown($selected=''){
		$opt = $this->global_model->getoptions('mst_jabatan','id_jabatan','nama_jabatan',array('id_departemen'=>$_POST['id_departemen']));
        echo form_dropdown('id_jabatan',$opt,$selected,'id="id_jabatan" class="form-control" style="width:200px"');
	 }
     function _form_karyawan($selected='',$tipe='all'){
       ## FORM PERSONAL
      
      if(($tipe=='all') || ($tipe=='personal')) :
        $data['frm_nik']              = array('name'=>'nik','id'=>'nik','class'=>'form-control','value'=>$selected['nik']);
        $data['frm_nama_karyawan']    = array('name'=>'nama_karyawan','id'=>'nama_karyawan','class'=>'form-control','value'=>$selected['nama_karyawan']);
        $data['opt_propinsi_lahir']       = $this->global_model->getoptions('mst_propinsi','id_propinsi','nama_propinsi');
        $data['frm_tanggal_lahir']    = array('name'=>'tanggal_lahir','id'=>'tanggal_lahir','class'=>'form-control datepicker','value'=>$selected['tanggal_lahir']);
        $data['opt_jenis_kelamin']    = $this->global_model->get_enum_values('mst_karyawan','jenis_kelamin');
        $data['opt_golongan_darah']   = $this->global_model->get_enum_values('mst_karyawan','golongan_darah');
        $data['opt_agama']            = $this->global_model->get_enum_values('mst_karyawan','agama');
        $data['frm_alamat']           = array('name'=>'alamat','id'=>'alamat','class'=>'form-control','value'=>$selected['alamat']);
        $data['opt_status']           = $this->global_model->get_enum_values('mst_karyawan','status');
        $data['frm_nama_pasangan']    = array('name'=>'nama_pasangan','id'=>'nama_pasangan','class'=>'form-control','value'=>$selected['nama_pasangan']);
        $data['frm_telepon_pasangan'] = array('name'=>'telepon_pasangan','id'=>'telepon_pasangan','class'=>'form-control','value'=>$selected['nama_pasangan']);
        $data['frm_nama_ayah']        = array('name'=>'nama_ayah','id'=>'nama_ayah','class'=>'form-control','value'=>$selected['nama_ayah']);
        $data['frm_nama_ibu']         = array('name'=>'nama_ibu','id'=>'nama_ibu','class'=>'form-control','value'=>$selected['nama_ibu']);
        $data['frm_telepon_emergency']= array('name'=>'telepon_emergency','id'=>'telepon_emergency','class'=>'form-control','value'=>$selected['telepon_emergency']);
        $data['frm_anak']             = array('name'=>'anak','id'=>'anak','class'=>'form-control','value'=>$selected['anak']);
        $data['opt_bahasa_asing']     = $this->global_model->get_set_values('mst_karyawan','bahasa_asing');
        $data['opt_pendidikan_terakhir'] = $this->global_model->get_enum_values('mst_karyawan','pendidikan_terakhir');
        $data['frm_nomor_telepon']        = array('name'=>'nomor_telepon','id'=>'nomor_telepon','class'=>'form-control','value'=>$selected['nomor_telepon']);
        $data['frm_hp']                   = array('name'=>'hp','id'=>'hp','class'=>'form-control','value'=>$selected['hp']);
        $data['opt_propinsi']         = $this->global_model->getoptions('mst_propinsi','id_propinsi','nama_propinsi');
        $data['opt_level_karyawan']    = $this->global_model->getoptions('mst_level_karyawan','id_level_karyawan','nama_level_karyawan');
		$data['opt_tipe_karyawan']    = $this->global_model->getoptions('mst_tipe_karyawan','id_tipe_karyawan','nama_tipe_karyawan');
        $data['opt_departemen']       = $this->global_model->getoptions('mst_departemen','id_departemen','nama_departemen');
        $data['opt_bank']             = $this->global_model->getoptions('mst_bank','id_bank','nama_bank');
        $data['frm_hobi']             = array('name'=>'hobi','id'=>'hobi','class'=>'form-control','value'=>$selected['hobi']);
        $data['frm_cabang_bank']      = array('name'=>'cabang_bank','id'=>'cabang_bank','class'=>'form-control','value'=>$selected['cabang_bank']);
		$data['frm_pengalaman_berorganisasi']   = array('name'=>'pengalaman_berorganisasi','id'=>'pengalaman_berorganisasi','class'=>'form-control','value'=>$selected['pengalaman_berorganisasi']);
        $data['frm_nomor_rekening']   = array('name'=>'nomor_rekening','id'=>'nomor_rekening','class'=>'form-control','value'=>$selected['nomor_rekening']);
        $data['frm_gaji_pokok']       = array('name'=>'gaji_pokok','id'=>'gaji_pokok','class'=>'form-control','value'=>$selected['gaji_pokok']);
        $data['frm_tanggal_join']       = array('name'=>'tanggal_join','id'=>'tanggal_join','class'=>'form-control datepicker','value'=>$selected['tanggal_join']);
      endif;
      
      if(($tipe=='all') || ($tipe=='data_anak'))  : 
         ## FORM ANAK
     
        $data['frm_nama_anak']        = array('name'=>'nama_anak[]','class'=>'form-control nama_anak','value'=>$selected['nama_anak']);
        $data['frm_umur']             = array('name'=>'umur[]','class'=>'form-control umur','value'=>$selected['umur']);
        $data['opt_pendidikan']       = $this->global_model->get_enum_values('mst_karyawan_anak','pendidikan');
      
      endif;
          ## FORM PENDIDIKAN
      if(($tipe=='all') || ($tipe=='pendidikan')) :
        $data['frm_nama_instansi_pendidikan']   = array('name'=>'nama_instansi_pendidikan[]','class'=>'form-control nama_instansi_pendidikan','value'=>$selected['nama_instansi_pendidikan']);
        $data['frm_tahun']                      = array('name'=>'tahun[]','class'=>'form-control tahun','value'=>$selected['tahun']);
        $data['opt_tingkat']                    = $this->global_model->get_enum_values('mst_karyawan_pendidikan','tingkat');
        $data['opt_jenis']                      = $this->global_model->get_enum_values('mst_karyawan_pendidikan','jenis');
       endif;
       
       if(($tipe=='all') || ($tipe=='pengalaman_kerja')) :
          ## FORM  PENGALAMAN KERJA
        $data['frm_nama_perusahaan']            = array('name'=>'nama_perusahaan[]','class'=>'form-control nama_perusahaan','value'=>$selected['nama_perusahaan']);
        $data['frm_alamat_kerja']               = array('name'=>'alamat_kerja[]','class'=>'form-control alamat_kerja','value'=>$selected['alamat']);
        $data['frm_reason_to_leave']            = array('name'=>'reason_to_leave[]','class'=>'form-control reason_to_leave','value'=>$selected['reason_to_leave']);
        $data['frm_contact_number']             = array('name'=>'contact_number[]','class'=>'form-control contact_number','value'=>$selected['reason_to_leave']);
        $data['frm_position']                   = array('name'=>'position[]','class'=>'form-control position','value'=>$selected['position']);
        $data['frm_mulai_kerja']                = array('name'=>'mulai_kerja[]','class'=>'form-control datepicker awal_kerja','value'=>$selected['mulai_kerja']);
        $data['frm_akhir_kerja']                = array('name'=>'akhir_kerja[]','class'=>'form-control datepicker akhir_kerja','value'=>$selected['akhir_kerja']);
      endif;
      $data['selected']   = $selected;
      return $data;


     }
     function frm_tambah_anak(){

      $selected=(array) json_decode($_POST['selected']);
      $form_=$this->_form_karyawan($selected,'data_anak');
      
        echo '<tr>
      <td>'.form_input($form_['frm_nama_anak']).'</td>
      <td>'.form_input($form_['frm_umur']).'</td>
      <td>'.form_dropdown('pendidikan[]',$form_['opt_pendidikan'],$selected['pendidikan'],'class="form-control"').'</td>
    </tr>';
     }
     function frm_tambah_pendidikan(){
       $selected=(array) json_decode($_POST['selected']);
        $form_=$this->_form_karyawan($selected,'pendidikan');
      ?>
          <tr>
            <td><?php echo form_input($form_['frm_nama_instansi_pendidikan'])?></td>
            <td><?php echo form_dropdown('tingkat[]',$form_['opt_tingkat'],$selected['tingkat'],'class="form-control"')?></td>
            <td><?php echo form_input($form_['frm_tahun'])?></td>
            <td><?php echo form_dropdown('jenis[]',$form_['opt_jenis'],'','class="form-control"')?></td>
        </tr>
     <?php
      }
      function frm_tambah_pengalaman(){

        $selected=(array) json_decode($_POST['selected']);
          $form_=$this->_form_karyawan($selected,'pengalaman_kerja');?>
             <tr>
              <td><?php echo form_input($form_['frm_nama_perusahaan'])?></td>
              <td><?php echo form_textarea($form_['frm_alamat_kerja'])?></td>
              <td><?php echo form_input($form_['frm_position'])?></td>
              <td><?php echo form_input($form_['frm_mulai_kerja'])?> - <?php echo form_input($form_['frm_akhir_kerja'])?>  </td>
              <td><?php echo form_textarea($form_['frm_reason_to_leave'])?></td>
              <td><?php echo form_input($form_['frm_contact_number'])?> </td>
          </tr>
          <?php
          

    }
    function insert_data_karyawan(){
      ## DATA KARYAWAN
        $this->db->set('nik',$this->input->post('nik'));
        $this->db->set('nama_karyawan',$this->input->post('nama_karyawan'));
        $this->db->set('id_propinsi_lahir',$this->input->post('id_propinsi_lahir'));
        $this->db->set('id_kota_lahir',$this->input->post('id_kota_lahir'));
        $this->db->set('tanggal_lahir',$this->input->post('tanggal_lahir'));
        $this->db->set('jenis_kelamin',$this->input->post('jenis_kelamin'));
        $this->db->set('golongan_darah',$this->input->post('golongan_darah'));
        $this->db->set('agama',$this->input->post('agama'));
        $this->db->set('alamat',$this->input->post('alamat'));
        $this->db->set('status',$this->input->post('status'));
        $this->db->set('nama_pasangan',$this->input->post('nama_pasangan'));
        $this->db->set('telepon_pasangan',$this->input->post('telepon_pasangan'));
        $this->db->set('nama_ayah',$this->input->post('nama_ayah'));
        $this->db->set('nama_ibu',$this->input->post('nama_ibu'));
        $this->db->set('telepon_emergency',$this->input->post('telepon_emergency'));
        foreach($_POST['bahasa_asing'] as $asing){
          $bahasa.=$asing.',';
        }
        $bahasa_asing=substr($bahasa, 0,-1);
        $this->db->set('bahasa_asing',$bahasa_asing);
        $this->db->set('pendidikan_terakhir',$this->input->post('pendidikan_terakhir'));
        $this->db->set('pengalaman_berorganisasi',$this->input->post('pengalaman_berorganisasi'));
        $this->db->set('nomor_telepon',$this->input->post('nomor_telepon'));
        $this->db->set('hp',$this->input->post('hp'));
        $this->db->set('id_propinsi',$this->input->post('id_propinsi'));
        $this->db->set('id_kabupaten_kota',$this->input->post('id_kabupaten_kota'));
        $this->db->set('id_departemen',$this->input->post('id_departemen'));
		$this->db->set('id_jabatan',$this->input->post('id_jabatan'));
		$this->db->set('id_level_karyawan',$this->input->post('id_level_karyawan'));
        $this->db->set('id_tipe_karyawan',$this->input->post('id_tipe_karyawan'));
        $this->db->set('hobi',$this->input->post('hobi'));
        $this->db->set('nomor_rekening',$this->input->post('nomor_rekening'));
        $this->db->set('gaji_pokok',$this->input->post('gaji_pokok'));
        $this->db->set('id_bank',$this->input->post('id_bank'));
		$this->db->set('cabang_bank',$this->input->post('cabang_bank'));
        $this->db->set('tanggal_join',$this->input->post('tanggal_join'));
    

       if(!empty($_POST['id_karyawan'])){
          $this->db->where('id_karyawan',$_POST['id_karyawan']);
          $this->db->update('mst_karyawan');
          $last_id_karyawan = $_POST['id_karyawan'];
       }
       else{
        ## INSERT 
          $this->db->insert('mst_karyawan');
          $last_id_karyawan = $this->db->insert_id();
       }
       ## insert data karyawan anak
       $this->db->delete('mst_karyawan_anak', array('id_karyawan' => $last_id_karyawan)); 
       $nama_anak         = $_POST['nama_anak'];
       $umur_anak         = $_POST['umur'];
       $pendidikan_anak   = $_POST['pendidikan'];

       for($i=0;$i<count($nama_anak);$i++){
          $this->db->set('id_karyawan',$last_id_karyawan);
          $this->db->set('nama_anak',$nama_anak[$i]);
          $this->db->set('umur',$umur_anak[$i]);
          $this->db->set('pendidikan',$pendidikan_anak[$i]);
          if(!empty($nama_anak[$i]))
          $this->db->insert('mst_karyawan_anak');
       }

        ## insert data penddikan
        $this->db->delete('mst_karyawan_pendidikan', array('id_karyawan' => $last_id_karyawan));
        $nama_instansi_pendidikan   = $_POST['nama_instansi_pendidikan'];
        $tingkat                    = $_POST['tingkat'];
        $tahun                      = $_POST['tahun'];
        $jenis                      = $_POST['jenis'];
      
        
        for($i=0;$i<count($nama_instansi_pendidikan);$i++){
          $this->db->set('id_karyawan',$last_id_karyawan);
          $this->db->set('nama_instansi_pendidikan',$nama_instansi_pendidikan[$i]);
          $this->db->set('tingkat',$tingkat[$i]);
          $this->db->set('tahun',$tahun[$i]);
          $this->db->set('jenis',$jenis[$i]);
          if(!empty($nama_instansi_pendidikan[$i]))
          $this->db->insert('mst_karyawan_pendidikan');
       }

       ## INSERT WORKING EXPERIENCES 
       $this->db->delete('mst_karyawan_working_experience', array('id_karyawan' => $last_id_karyawan)); 
       $nama_perusahaan = $_POST['nama_perusahaan'];
       $alamat_kerja    = $_POST['alamat_kerja'];
       $position        = $_POST['position'];
       $mulai_kerja     = $_POST['mulai_kerja'];
       $akhir_kerja     = $_POST['akhir_kerja'];
       $reason_to_leave = $_POST['reason_to_leave'];
       $contact_number  = $_POST['contact_number'];

       for($i=0;$i<count($nama_perusahaan);$i++){
          $this->db->set('id_karyawan',$last_id_karyawan);
          $this->db->set('nama_perusahaan',$nama_perusahaan[$i]);
          $this->db->set('alamat',$alamat_kerja[$i]);
          $this->db->set('contact_number',$contact_number[$i]);
          $this->db->set('mulai_kerja',$mulai_kerja[$i]);
          $this->db->set('akhir_kerja',$akhir_kerja[$i]);
          $this->db->set('reason_to_leave',$reason_to_leave[$i]);
          $this->db->set('position',$position[$i]);
          if(!empty($nama_perusahaan[$i]))
          $this->db->insert('mst_karyawan_working_experience');
       }


      redirect('master/karyawan');
    }

 }