<?php 
class Pickup extends MX_Controller {

    function __construct() {
  
        parent::__construct();
        $this->load->database();
        //$this->load->library('grocery_CRUD');
        
	    $this->load->library(array('session','General'));
        $this->load->helper(array('url','form'));
       
        //$auth = $this->load->module('main/auth');
        $auth = $this->load->module('main/auth');
        $main = $this->load->module('main/main');
        $auth::session_check();
        
     }
     
     function index($bulan='',$tahun=''){
        
        $main                   = $this->load->module('main/main');
        $data['content']        = '<h1>WELCOME</h1>';//$this->_dashboard($bulan,$tahun);

        
        $data['section']        = 'ASSETS MOVING MANAGEMENT';
        $data['subsection']     = 'ISUZU';
        $main::demo_template($data);

     }
     function pickup_barang(){
        
        $main                       = $this->load->module('main/main');
        $element['draft_id_pickup'] = $this->_create_draft_surat_jalan();
        $element['frm_barcode']     = array('name'=>'barcode','class'=>'form-control','id'=>'barcode','value'=>'');
        $data['content']            = $this->load->view('pickup_barang',$element,TRUE);         
        $data['section']            = 'PICKUP';
        $data['subsection']         = 'Barang';
        $main::demo_template($data);
     }
     function _create_draft_surat_jalan(){
        
        $this->db->set('user_create',$this->session->userdata('id_user'));
        $this->db->set('date_create','now()',FALSE);
        $this->db->insert('trs_pickup') ;
        $last_id_pickup = $this->db->insert_id();
        return $last_id_pickup;
     }
     function delete_detail_pickup_pickup(){
      
      $result=$this->db->delete('trs_pickup_detail',array('id_pickup_detail'=>$_POST['id_pickup_detail']));
      $data=array('error_message'=>$this->db->_error_message());
      echo json_encode($data);
     }
     function _frm_pickup(){
        $data['frm_barcode']            = array('name'=>'barcode','class'=>'form-control','id'=>'barcode','value'=>'');
        $data['frm_nomor_kendaraan']    = array('name'=>'car_number','class'=>'form-control','id'=>'car_number','value'=>'');
        $data['frm_nama_supir']         = array('name'=>'drivername','class'=>'form-control','id'=>'drivername','value'=>'');  
        $data['opt_inventory']          = $this->global_model->getoptions('mst_inventory','id_inventory','inventory_name');      
        return $data;
     }  
     function insert_detail_pickup($draft_id_pickup=''){
        $sql= "SELECT * FROM mst_item WHERE barcode='".$_POST['barcode']."' OR barcode_old='".$_POST['barcode']."'";
        $data['result_item']=$this->db->query($sql)->row_array();
        
        $this->db->set('id_pickup',$draft_id_pickup);
        $this->db->set('id_item',$data['result_item']['id_item']);  
        
        $this->db->insert('trs_pickup_detail') ;
        $data['last_id_pickup_detail'] = $this->db->insert_id(); 
        
         ## insert LOG PROCESS ITEM
        $this->db->query("call InsertLogItem(2,".$data['result_item']['id_item'].",1,".$this->session->userdata('id_user').",1,".$data['last_id_pickup_detail'].")");
        $this->load->view('detail_pickup',$data);
    }
    function set_siap_cetak(){
        $result         = $this->db->update('trs_pickup',array('status'=>'SIAPCETAK'),array('id_pickup'=>$_POST['draft_id_pickup']));
        $error_message  = $this->db->_error_message();
        echo json_encode(array('error_message'=>$error_message));

    }
    function _create_permit_number(){

    }
    function submit_pickup(){
      
        ##INSERT TRS_PICKUP (HEADER SURAT JALAN)
        $rand=rand(); ## FOR DEMO ONLY
        $this->db->set('permit_number','DEMO-'.$rand);
        $this->db->set('user_create',$this->session->userdata('id_user'));
        $this->db->set('date_create','now()',FALSE);
        $this->db->set('id_inventory_from',$_POST['id_inventory_from']);        
        $this->db->set('id_inventory_to',$_POST['id_inventory_to']);        
        $this->db->set('car_number',$_POST['car_number']);        
        $this->db->set('drivername',$_POST['drivername']); 
        $this->db->insert('trs_pickup') ;
        
        $last_id_pickup = $this->db->insert_id();

        ##INSERT TRS_PICKUP_DETAIL (DETAIL SURAT JALAN)
        $id_item_list = array_keys($_POST['quantity']);
        foreach ($id_item_list as $id_item) {
            
            $this->db->set('id_pickup',$last_id_pickup);
            $this->db->set('qty',$_POST['quantity'][$id_item]);
            $this->db->set('id_item',$id_item);   
            $this->db->insert('trs_pickup_detail') ;
            $last_id_pickup_detail = $this->db->insert_id();


            ## insert LOG PROCESS ITEM
            $this->db->query("call InsertLogItem(2,".$id_item.",".$_POST['id_inventory_from'].",".$this->session->userdata('id_user').",".$_POST['quantity'][$id_item].",".$last_id_pickup_detail.")");
        
        }

    }

    function surat_jalan($status='DRAFT'){
        $main                   = $this->load->module('main/main');
        $parm['result']         = $this->global_model->get_data(array('table'=>'trs_pickup as a',
                                                                     'join'=>array(
                                                                                'table'=>array(
                                                                                            'mst_gate_inventory as b',
                                                                                            'mst_gate_inventory as c',
                                                                                            'mst_user as d',
                                                                                            'mst_driver as e'
                                                                                        ),
                                                                                 'on'=>array(
                                                                                        'a.id_gate_from=b.id_gate',
                                                                                        'a.id_gate_to=c.id_gate',
                                                                                        'a.user_create=d.id_user',
                                                                                        'a.id_driver=e.id_driver'
                                                                                        ),
                                                                                 'method'=>array('LEFT','LEFT','LEFT','LEFT')
                                                                                ),
                                                                    'where'=>array('a.aktif'=>'Y','a.status'=>$status),
                                                                    'select'=>'a.status,a.id_pickup,a.permit_number,a.date_create,a.car_number,e.driver_name,
                                                                               b.gate_name as gate_from,c.gate_name as gate_destination,
                                                                               d.nama_lengkap'
                                                                    )
                                                               );
        //echo $this->db->last_query();
        $data['content']        = $this->load->view('surat_jalan',$parm,TRUE);      
        $data['section']        = 'SURAT JALAN';
        $data['subsection']     = $status;
        $main::demo_template($data);       
    }
    function detail_surat_jalan(){
         $result =  $this->global_model->get_data(array('table'=>'trs_pickup_detail as a',
                                                                     'join'=>array(
                                                                                'table'=>array('mst_item as b',
																								//'trs_log_item_process as c',
																								//'mst_process as d',
																								),
                                                                                 'on'=>array('a.id_item=b.id_item',
																							 //'c.id_pickup_detail=a.id_pickup_detail',
																							 //'c.id_process=d.id_process',
																							 ),
                                                                                 'method'=>array('LEFT'/*,'LEFT','LEFT'*/)
                                                                                ),
                                                                        'where'=>array('a.id_pickup'=>$_POST['id_pickup']),
                                                                        'select'=>'a.*,b.item_name,b.description,b.barcode ',/*,d.process_name,c.qty as qty_per_status,c.user_create,c.date_create',*/
																		'order_by'=>array('field'=>'item_name','type'=>'ASC'),
                                                                    )
                                                              );
															 //  echo $this->db->last_query();
       /*  $result= $this->global_model->get_data(array('table'=>'trs_pickup_detail as a',
                                                                     'join'=>array(
                                                                                'table'=>array('mst_item as b'),
                                                                                 'on'=>array('a.id_item=b.id_item'),
                                                                                 'method'=>array('LEFT')
                                                                                ),
                                                                        'where'=>array('a.id_pickup'=>$_POST['id_pickup']),
                                                                        'select'=>'a.*,b.item_name,b.description'
                                                                    )
                                                               ); */
        echo '<table class="table table-bordered table-condensed">
                <thead>
                <tr><th>No</th><th>Nama Item</th><th>Deskripsi</th><th>Quantity</th>
				<!--<th>Status Proses</th>
				<th>Jumlah Item <br> dalam Status Proses</th>
				<th>User Proses</th>
				<th>Tanggal Proses</th>-->
				</tr>
                </thead><tbody>';
        $no=1;
        foreach($result as $rec){
            echo '<tr>
                    <td>'.$no.'</td>
                    <td>'.$rec['item_name'].'</td>
                    <td>'.$rec['description'].'</td>
                    <td>'.$rec['qty'].'</td>
					<!--<td>'.$rec['process_name'].'</td>
					<td>'.$rec['qty_per_status'].'</td>
					<td>Nandra Maulana Irawan <!--DEMO ONLY--></td>
					<!--<td>'.$rec['date_create'].'</td>-->
                    </tr>';
        $no++;
        }
        echo '</tbody></table>';
    }

    function change_process_by_sj($next_process=''){
        //print_r($_POST);
        $main                   = $this->load->module('main/main');
        $process                = $this->global_model->get_data(array( 'table'=>'mst_process as a',
                                                                        'where'=>array('a.id_process'=>$next_process),
                                                                        'data'=>'row'
                                                                        )
                                                               );
        $parm                       =  $this->_frm_sj($_POST);
        $parm['next_process_id']    =  $next_process;
        $parm['next_process_name']  =  $process['process_name'];
        $data['selected']           =  $_POST;
        if(isset($_POST['permit_number']))  
            $parm['subcontent']     =  $this->_detail_all_sj($_POST);
        else
            $parm['subcontent']     ='';

        $data['content']            =  $this->load->view('change_process_by_sj',$parm,TRUE);  


        $data['section']            = 'SET PROCESS '.$process['process_name'];
        $data['subsection']         = 'Demo Only';
        $main::demo_template($data);              
    }
    function _frm_sj(){
        $data['frm_permit_numbers'] = array('name'=>'permit_number','id'=>'permit_number','class'=>'form-control' ,'value'=>$_POST['permit_number']);
        return $data;
    }
    function _detail_all_sj($post_array){
     
        $data['result']        = $this->global_model->get_data(array('table'=>'trs_pickup as a',
                                                                     'join'=>array(
                                                                                'table'=>array(
                                                                                            'mst_inventory as b',
                                                                                            'mst_inventory as c',
                                                                                            'mst_user as d'
                                                                                        ),
                                                                                 'on'=>array(
                                                                                        'a.id_inventory_from=b.id_inventory',
                                                                                        'a.id_inventory_to=c.id_inventory',
                                                                                        'a.user_create=d.id_user'
                                                                                        ),
                                                                                 'method'=>array('LEFT','LEFT','LEFT')
                                                                                ),
                                                                    'where'=>array('a.permit_number'=>$post_array['permit_number']),
                                                                    'select'=>'a.id_pickup,a.permit_number,a.date_create,a.car_number,
                                                                               b.inventory_name as inventory_from,c.inventory_name as inventory_to,
                                                                               d.nama_lengkap,b.id_inventory as id_inventory_from,c.id_inventory as id_inventory_to',
                                                                    'data'=>'row')
                                                               );
        $data['result_detail'] =  $this->global_model->get_data(array('table'=>'trs_pickup_detail as a',
                                                                     'join'=>array(
                                                                                'table'=>array('mst_item as b',
																								'trs_log_item_process as c',
																								'mst_process as d',
																								),
                                                                                 'on'=>array('a.id_item=b.id_item',
																							 'c.id_pickup_detail=a.id_pickup_detail',
																							 'c.id_process=d.id_process',
																							 ),
                                                                                 'method'=>array('LEFT','LEFT')
                                                                                ),
                                                                        'where'=>array('a.id_pickup'=>$data['result']['id_pickup']),
                                                                        'select'=>'a.*,b.item_name,b.description,b.barcode,d.process_name,c.qty as qty_per_status'
                                                                    )
                                                               );
        $data['frm_barcode']        = array('name'=>'barcode','class'=>'form-control','id'=>'barcode','value'=>'');
        $data['next_process_id']    = $post_array['next_process_id'];
        $data['next_process_name']  = $post_array['next_process_name'];
        $data['id_pickup']          = $data['result']['id_pickup'];
		## MENCARI JIKA ADA PROCESS BERIKUTNYA
		$data['next_result']		=  $this->global_model->get_data(array('table'=>'trs_log_item_process as a',
                                                                     'join'=>array(
                                                                                'table'=>array('mst_item as b',
																								'trs_pickup_detail as c '),
                                                                                 'on'=>array('a.id_item=b.id_item','a.id_pickup_detail=c.id_pickup_detail'),
                                                                                 'method'=>array('LEFT','LEFT')
                                                                                ),
                                                                        'where'=>array('c.id_pickup'=>$data['result']['id_pickup'],
																						'a.id_process'=>$post_array['next_process_id']),
                                                                        'select'=>'a.*,b.item_name,b.description,b.barcode'
                                                                    )
                                                               );
      // print_r($result['next_result']);
       return $this->load->view('all_sj',$data,TRUE);
    }
    function set_progress_by_sj(){
    
      $result_detail =  $this->global_model->get_data(array('table'=>'trs_pickup_detail as a',
                                                                     'join'=>array(
                                                                                'table'=>array('mst_item as b'),
                                                                                 'on'=>array('a.id_item=b.id_item'),
                                                                                 'method'=>array('LEFT')
                                                                                ),
                                                                        'where'=>array('a.id_pickup'=>$_POST['id_pickup'],'b.barcode'=>$_POST['barcode']),
                                                                        'select'=>'a.*,b.item_name,b.description,b.barcode','data'=>'row'
                                                                    )
                                                               );
    ## CEK DITABLE PROGRESS SUDAH ADA APA BELUM JIKA SUDAH MAKA UPDATE DATANYA
		//if(count($result_detail>0)){
			$this->db->query("call InsertLogItem(".$_POST['next_process_id'].",".$result_detail['id_item'].",".$_POST['id_inventory_to'].",".$this->session->userdata('id_user').",1,".$result_detail['id_pickup_detail'].")");
			$result_cek_progress=  $this->global_model->get_data(array('table'=>'trs_log_item_process as a',
                                                               'where'=>array('a.id_pickup_detail'=>$result_detail['id_pickup_detail'],
                                                                              'a.id_item'=>$result_detail['id_item']
                                                                              ),
                                                                'data'=>'row'
                                                                    )
                                                           );
														 //  print_r($result_cek_progress); 
    ?>
        <tr id="row-next-proccess-<?php echo $result_detail['barcode'] ?>">
                    <td><?php echo $result_detail['barcode']?> </td>
                    <td><?php echo $result_detail['item_name']?></td>
                    <td><?php echo $result_detail['description']?></td>
                    <td >
					<span id="qty-next-<?php echo $result_detail['barcode'] ?>"><?php echo 1?></span>
					 <input type="hidden" name="id_log[]" id="log-item-<?php  echo $result_detail['barcode'] ?>" value="<?php echo $result_cek_progress['id_log_item_process']?>">
                    </td>';
    <?php 
		 //}
      
    
    }
	function update_progress(){
		$this->db->update('trs_log_item_process', array('qty'=>$_POST['qty_update']), array('id_log_item_process' => $_POST['log_id']));
		echo $this->db->_error_message();
		//$this->db->update('trs_log_item_process',array(''))
	}

    function cek_status_sj(){
                //print_r($_POST);
        $main                   = $this->load->module('main/main');
       
        $parm                       =  $this->_frm_sj($_POST);

        $data['selected']           =  $_POST;
        if(isset($_POST['permit_number']))  
            $parm['subcontent']     =  $this->_detail_status_sj($_POST);
        else
            $parm['subcontent']     ='';

        $data['content']            =  $this->load->view('change_process_by_sj',$parm,TRUE);  


        $data['section']            = 'SET PROCESS '.$process['process_name'];
        $data['subsection']         = 'Demo Only';
        $main::demo_template($data);    
    }
    function _detail_status_sj($post_array){
        $data['result']        = $this->global_model->get_data(array('table'=>'trs_pickup as a',
                                                                     'join'=>array(
                                                                                'table'=>array(
                                                                                            'mst_inventory as b',
                                                                                            'mst_inventory as c',
                                                                                            'mst_user as d'
                                                                                        ),
                                                                                 'on'=>array(
                                                                                        'a.id_inventory_from=b.id_inventory',
                                                                                        'a.id_inventory_to=c.id_inventory',
                                                                                        'a.user_create=d.id_user'
                                                                                        ),
                                                                                 'method'=>array('LEFT','LEFT','LEFT')
                                                                                ),
                                                                    'where'=>array('a.permit_number'=>$post_array['permit_number']),
                                                                    'select'=>'a.id_pickup,a.permit_number,a.date_create,a.car_number,
                                                                               b.inventory_name as inventory_from,c.inventory_name as inventory_to,
                                                                               d.nama_lengkap,b.id_inventory as id_inventory_from,c.id_inventory as id_inventory_to',
                                                                    'data'=>'row')
                                                               );
        $data['result_detail'] =  $this->global_model->get_data(array('table'=>'trs_pickup_detail as a',
                                                                     'join'=>array(
                                                                                'table'=>array('mst_item as b',
                                                                                               
                                                                                                ),
                                                                                 'on'=>array('a.id_item=b.id_item',
                                                                                             
                                                                                             ),
                                                                                 'method'=>array('LEFT','LEFT')
                                                                                ),
                                                                        'where'=>array('a.id_pickup'=>$data['result']['id_pickup']),
                                                                        'select'=>'a.*,b.item_name,b.description,b.barcode'
                                                                    )
                                                               );
        $data['frm_barcode']        = array('name'=>'barcode','class'=>'form-control','id'=>'barcode','value'=>'');
        $data['next_process_id']    = $post_array['next_process_id'];
        $data['next_process_name']  = $post_array['next_process_name'];
        $data['id_pickup']          = $data['result']['id_pickup'];
        ## MENCARI JIKA ADA PROCESS BERIKUTNYA
        $data['next_result']        =  $this->global_model->get_data(array('table'=>'trs_log_item_process as a',
                                                                     'join'=>array(
                                                                                'table'=>array('mst_item as b',
                                                                                                'trs_pickup_detail as c '),
                                                                                 'on'=>array('a.id_item=b.id_item','a.id_pickup_detail=c.id_pickup_detail'),
                                                                                 'method'=>array('LEFT','LEFT')
                                                                                ),
                                                                        'where'=>array('c.id_pickup'=>$data['result']['id_pickup'],
                                                                                        'a.id_process'=>$post_array['next_process_id']),
                                                                        'select'=>'a.*,b.item_name,b.description,b.barcode'
                                                                    )
                                                               );
      // print_r($result['next_result']);
       return $this->load->view('status_sj',$data,TRUE);
    }
    function get_process($id_pickup_detail='',$id_item='',$id_process=''){
       $result        = $this->global_model->get_data(array('table'=>'trs_log_item_process as a',
                                                                     
                                                                    'where'=>array('a.id_pickup_detail'=>$id_pickup_detail,
                                                                                   'a.id_item'=>$id_item,
                                                                                   'a.id_process'=>$id_process),
                                                                    'data'=>'row')
                                                               );
      if(count($result)>0)
       echo '<div> Waktu :'.$result['date_create'].'<br> Oleh: Nandra Maulana Irawan (DEMO ONLY)<br> jumlah : '.$result['qty'].' item</div>';
    }
    function verifikasi_cetak_sj($id_pickup){
      
         $data['form']  =array('no_surat_jalan' => array('name'=>'permit_number','id'=>'permit_number','class'=>'form-control input-sm'),
                               'id_gate_from'   => array('name'=>'id_gate_from','id'=>'id_gate_from','class'=>'form-control input-sm'),
                               'id_gate_to'     => array('name'=>'id_gate_to','id'=>'id_gate_to','class'=>'form-control input-sm'),
                               'car_number'     => array('name'=>'car_number','id'=>'car_number','class'=>'form-control input-sm'),
                               'ho_sopir'     => array('name'=>'no_hp','id'=>'no_hp','class'=>'form-control input-sm')

                              );
         $data['opt_driver']        = $this->global_model->getoptions('mst_driver','id_driver','driver_name');
         $data['opt_loading_point'] = $this->global_model->getoptions('mst_gate_inventory','id_gate',"gate_name",array('type'=>'loading_point'));
         $data['opt_gate_to']       = $this->global_model->getoptions('mst_gate_inventory','id_gate',"gate_name",array('type'=>'gate'));
         $data['id_pickup']         = $id_pickup;

         $data['result']            = $this->global_model->get_data(array('table'=>'trs_pickup as a','data'=>'row',
                                                                     'join'=>array(
                                                                                'table'=>array(
                                                                                            'mst_gate_inventory as b',
                                                                                            'mst_gate_inventory as c',
                                                                                            'mst_user as d',
                                                                                            'mst_driver as e'
                                                                                        ),
                                                                                 'on'=>array(
                                                                                        'a.id_gate_from=b.id_gate',
                                                                                        'a.id_gate_to=c.id_gate',
                                                                                        'a.user_create=d.id_user',
                                                                                        'a.id_driver=e.id_driver'
                                                                                        ),
                                                                                 'method'=>array('LEFT','LEFT','LEFT','LEFT')
                                                                                ),
                                                                    'where'=>array('a.id_pickup'=>$id_pickup),
                                                                    'select'=>'a.id_pickup,a.permit_number,a.date_create,a.car_number,e.driver_name,
                                                                               b.gate_name as gate_from,c.gate_name as gated_destination,
                                                                               d.nama_lengkap'
                                                                    )
                                                               );
       //  echo $this->db->last_query();
         $data['result_detail'] =  $this->global_model->get_data(array('table'=>'trs_pickup_detail as a',
                                                                     'join'=>array('table'=>array('mst_item as b','mst_item_category  c'),
                                                                                    'on'=>array('a.id_item=b.id_item','c.id_item_category=b.id_item_category'),
                                                                                 'method'=>array('LEFT','LEFT')
                                                                                ),
                                                                        'where'=>array('a.id_pickup'=>$id_pickup),
                                                                        'select'=>'a.*,b.item_name,b.description,b.barcode ,c.category_name,b.pic_department,b.barcode_old',
                                    'order_by'=>array('field'=>'item_name','type'=>'ASC'),
                                                                    )
                                                              );

        
        $this->load->view('verifikasi_cetak_sj',$data);

    }
    function driver_detail($id){
          $result_driver =  $this->global_model->get_data(array('table'=>'mst_driver ','where'=>array('id_driver'=>$id),'data'=>'row'));      

        echo json_encode($result_driver);
    }
    function verifikasi_benar_surat_jalan(){

      $fields = $this->db->list_fields('trs_pickup');
      foreach($fields as $f){
        if($_POST[$f]<>''){
            $this->db->set($f,$_POST[$f]);
        }
      }
       $this->db->set('status','TERBIT');
      $this->db->where('id_pickup',$_POST['id_pickup']);

      $result= $this->db->update('trs_pickup');
      echo $this->db->_error_message();
    } 
    function cetak_surat_jalan($id_pickup){
        $data['result']          = $this->global_model->get_data(array('table'=>'trs_pickup as a','data'=>'row',
                                                                     'join'=>array(
                                                                                'table'=>array(
                                                                                            'mst_gate_inventory as b',
                                                                                            'mst_gate_inventory as c',
                                                                                            'mst_user as d',
                                                                                            'mst_driver as e'
                                                                                        ),
                                                                                 'on'=>array(
                                                                                        'a.id_gate_from=b.id_gate',
                                                                                        'a.id_gate_to=c.id_gate',
                                                                                        'a.user_create=d.id_user',
                                                                                        'a.id_driver=e.id_driver'
                                                                                        ),
                                                                                 'method'=>array('LEFT','LEFT','LEFT','LEFT')
                                                                                ),
                                                                    'where'=>array('a.id_pickup'=>$id_pickup),
                                                                    'select'=>'a.id_pickup,a.permit_number,a.date_create,a.car_number,e.driver_name,
                                                                               b.gate_name as gate_from,c.gate_name as gate_destination,
                                                                               d.nama_lengkap,e.no_hp'
                                                                    )
                                                               );
         
        // echo $this->db->last_query();
         $data['result_detail'] =  $this->global_model->get_data(array('table'=>'trs_pickup_detail as a',
                                                                     'join'=>array('table'=>array('mst_item as b','mst_item_category  c'),
                                                                                    'on'=>array('a.id_item=b.id_item','c.id_item_category=b.id_item_category'),
                                                                                 'method'=>array('LEFT','LEFT')
                                                                                ),
                                                                        'where'=>array('a.id_pickup'=>$id_pickup),
                                                                        'select'=>'a.*,b.item_name,b.description,b.barcode ,c.category_name',
                                    'order_by'=>array('field'=>'item_name','type'=>'ASC'),
                                                                    )
                                                              );

          $this->load->view('cetak_surat_jalan',$data);
    }
    
}