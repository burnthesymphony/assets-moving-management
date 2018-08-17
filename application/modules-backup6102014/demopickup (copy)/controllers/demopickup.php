<?php 
class Demopickup extends MX_Controller {

    function __construct() {
  
        parent::__construct();
        $this->load->database();
        //$this->load->library('grocery_CRUD');
        
	    $this->load->library(array('session','General'));
        $this->load->helper(array('url','form'));
       
        //$auth = $this->load->module('main/auth');
        $main = $this->load->module('main/main');
       ##DEMO ONLY
        $newdata = array(

                   'id_user'    => 1,
                   'logged_in'  => TRUE,
                   'fullname'   => 'Nandra Maualana Irawan',
                   'id_otoritas'=> 1

               );
            //$this->db->update('psh_master.mst_user', array('status_login'=>1), array('username' => $cek['id_user']));
            $this->session->set_userdata($newdata);
	    
        
     }
     
     function index($bulan='',$tahun=''){
        
        $main                   = $this->load->module('main/main');
        $data['content']        = '<h1>INVENTORY PICKUP DEMO ONLY</h1>';//$this->_dashboard($bulan,$tahun);

        
        $data['section']        = 'INVENTORY-PICKUP';
        $data['subsection']     = 'Demo Only';
        $main::demo_template($data);

     }
     function pickup_barang(){
        $main                   = $this->load->module('main/main');
        $element                =  $this->_frm_pickup();
        $data['content']        = $this->load->view('pickup_barang',$element,TRUE);      
        $data['section']        = 'INVENTORY-PICKUP';
        $data['subsection']     = 'Demo Only';
        $main::demo_template($data);
     }
     function _frm_pickup(){
        $data['frm_barcode']            = array('name'=>'barcode','class'=>'form-control','id'=>'barcode','value'=>'');
        $data['frm_nomor_kendaraan']    = array('name'=>'car_number','class'=>'form-control','id'=>'car_number','value'=>'');
        $data['frm_nama_supir']         = array('name'=>'drivername','class'=>'form-control','id'=>'drivername','value'=>'');  
        $data['opt_inventory']          = $this->global_model->getoptions('inventory_pickup.mst_inventory','id_inventory','inventory_name');      
        return $data;
     }  
     function detail_pickup(){
        $data['result_item']=$this->global_model->get_data(array('table'=>'inventory_pickup.mst_item','where'=>array('barcode'=> $_POST['barcode']),'data'=>'row'));
        
        $this->load->view('detail_pickup',$data);
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
        $this->db->insert('inventory_pickup.trs_pickup') ;
        
        $last_id_pickup = $this->db->insert_id();

        ##INSERT TRS_PICKUP_DETAIL (DETAIL SURAT JALAN)
        $id_item_list = array_keys($_POST['quantity']);
        foreach ($id_item_list as $id_item) {
            
            $this->db->set('id_pickup',$last_id_pickup);
            $this->db->set('qty',$_POST['quantity'][$id_item]);
            $this->db->set('id_item',$id_item);   
            $this->db->insert('inventory_pickup.trs_pickup_detail') ;
            $last_id_pickup_detail = $this->db->insert_id();


            ## insert LOG PROCESS ITEM
            $this->db->query("call inventory_pickup.InsertLogItem(2,".$id_item.",".$_POST['id_inventory_from'].",".$this->session->userdata('id_user').",".$_POST['quantity'][$id_item].",".$last_id_pickup_detail.")");
        
        }

    }

    function surat_jalan(){
        $main                   = $this->load->module('main/main');
        $parm['result']        = $this->global_model->get_data(array('table'=>'inventory_pickup.trs_pickup as a',
                                                                     'join'=>array(
                                                                                'table'=>array(
                                                                                            'inventory_pickup.mst_inventory as b',
                                                                                            'inventory_pickup.mst_inventory as c',
                                                                                            'inventory_pickup.mst_user as d'
                                                                                        ),
                                                                                 'on'=>array(
                                                                                        'a.id_inventory_from=b.id_inventory',
                                                                                        'a.id_inventory_to=c.id_inventory',
                                                                                        'a.user_create=d.id_user'
                                                                                        ),
                                                                                 'method'=>array('LEFT','LEFT','LEFT')
                                                                                ),
                                                                    'where'=>array('a.aktif'=>'Y'),
                                                                    'select'=>'a.id_pickup,a.permit_number,a.date_create,a.car_number,a.drivername,
                                                                               b.inventory_name as inventory_from,c.inventory_name as inventory_to,
                                                                               d.nama_lengkap'
                                                                    )
                                                               );
        $data['content']        = $this->load->view('surat_jalan',$parm,TRUE);      
        $data['section']        = 'SURAT JALAN';
        $data['subsection']     = 'Demo Only';
        $main::demo_template($data);       
    }
    function detail_surat_jalan(){
         $result =  $this->global_model->get_data(array('table'=>'inventory_pickup.trs_pickup_detail as a',
                                                                     'join'=>array(
                                                                                'table'=>array('inventory_pickup.mst_item as b',
																								//'inventory_pickup.trs_log_item_process as c',
																								//'inventory_pickup.mst_process as d',
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
       /*  $result= $this->global_model->get_data(array('table'=>'inventory_pickup.trs_pickup_detail as a',
                                                                     'join'=>array(
                                                                                'table'=>array('inventory_pickup.mst_item as b'),
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
        $process                = $this->global_model->get_data(array( 'table'=>'inventory_pickup.mst_process as a',
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
     
        $data['result']        = $this->global_model->get_data(array('table'=>'inventory_pickup.trs_pickup as a',
                                                                     'join'=>array(
                                                                                'table'=>array(
                                                                                            'inventory_pickup.mst_inventory as b',
                                                                                            'inventory_pickup.mst_inventory as c',
                                                                                            'inventory_pickup.mst_user as d'
                                                                                        ),
                                                                                 'on'=>array(
                                                                                        'a.id_inventory_from=b.id_inventory',
                                                                                        'a.id_inventory_to=c.id_inventory',
                                                                                        'a.user_create=d.id_user'
                                                                                        ),
                                                                                 'method'=>array('LEFT','LEFT','LEFT')
                                                                                ),
                                                                    'where'=>array('a.permit_number'=>$post_array['permit_number']),
                                                                    'select'=>'a.id_pickup,a.permit_number,a.date_create,a.car_number,a.drivername,
                                                                               b.inventory_name as inventory_from,c.inventory_name as inventory_to,
                                                                               d.nama_lengkap,b.id_inventory as id_inventory_from,c.id_inventory as id_inventory_to',
                                                                    'data'=>'row')
                                                               );
        $data['result_detail'] =  $this->global_model->get_data(array('table'=>'inventory_pickup.trs_pickup_detail as a',
                                                                     'join'=>array(
                                                                                'table'=>array('inventory_pickup.mst_item as b',
																								'inventory_pickup.trs_log_item_process as c',
																								'inventory_pickup.mst_process as d',
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
		$data['next_result']		=  $this->global_model->get_data(array('table'=>'inventory_pickup.trs_log_item_process as a',
                                                                     'join'=>array(
                                                                                'table'=>array('inventory_pickup.mst_item as b',
																								'inventory_pickup.trs_pickup_detail as c '),
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
    
      $result_detail =  $this->global_model->get_data(array('table'=>'inventory_pickup.trs_pickup_detail as a',
                                                                     'join'=>array(
                                                                                'table'=>array('inventory_pickup.mst_item as b'),
                                                                                 'on'=>array('a.id_item=b.id_item'),
                                                                                 'method'=>array('LEFT')
                                                                                ),
                                                                        'where'=>array('a.id_pickup'=>$_POST['id_pickup'],'b.barcode'=>$_POST['barcode']),
                                                                        'select'=>'a.*,b.item_name,b.description,b.barcode','data'=>'row'
                                                                    )
                                                               );
    ## CEK DITABLE PROGRESS SUDAH ADA APA BELUM JIKA SUDAH MAKA UPDATE DATANYA
		//if(count($result_detail>0)){
			$this->db->query("call inventory_pickup.InsertLogItem(".$_POST['next_process_id'].",".$result_detail['id_item'].",".$_POST['id_inventory_to'].",".$this->session->userdata('id_user').",1,".$result_detail['id_pickup_detail'].")");
			$result_cek_progress=  $this->global_model->get_data(array('table'=>'inventory_pickup.trs_log_item_process as a',
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
		$this->db->update('inventory_pickup.trs_log_item_process', array('qty'=>$_POST['qty_update']), array('id_log_item_process' => $_POST['log_id']));
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
        $data['result']        = $this->global_model->get_data(array('table'=>'inventory_pickup.trs_pickup as a',
                                                                     'join'=>array(
                                                                                'table'=>array(
                                                                                            'inventory_pickup.mst_inventory as b',
                                                                                            'inventory_pickup.mst_inventory as c',
                                                                                            'inventory_pickup.mst_user as d'
                                                                                        ),
                                                                                 'on'=>array(
                                                                                        'a.id_inventory_from=b.id_inventory',
                                                                                        'a.id_inventory_to=c.id_inventory',
                                                                                        'a.user_create=d.id_user'
                                                                                        ),
                                                                                 'method'=>array('LEFT','LEFT','LEFT')
                                                                                ),
                                                                    'where'=>array('a.permit_number'=>$post_array['permit_number']),
                                                                    'select'=>'a.id_pickup,a.permit_number,a.date_create,a.car_number,a.drivername,
                                                                               b.inventory_name as inventory_from,c.inventory_name as inventory_to,
                                                                               d.nama_lengkap,b.id_inventory as id_inventory_from,c.id_inventory as id_inventory_to',
                                                                    'data'=>'row')
                                                               );
        $data['result_detail'] =  $this->global_model->get_data(array('table'=>'inventory_pickup.trs_pickup_detail as a',
                                                                     'join'=>array(
                                                                                'table'=>array('inventory_pickup.mst_item as b',
                                                                                               
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
        $data['next_result']        =  $this->global_model->get_data(array('table'=>'inventory_pickup.trs_log_item_process as a',
                                                                     'join'=>array(
                                                                                'table'=>array('inventory_pickup.mst_item as b',
                                                                                                'inventory_pickup.trs_pickup_detail as c '),
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
       $result        = $this->global_model->get_data(array('table'=>'inventory_pickup.trs_log_item_process as a',
                                                                     
                                                                    'where'=>array('a.id_pickup_detail'=>$id_pickup_detail,
                                                                                   'a.id_item'=>$id_item,
                                                                                   'a.id_process'=>$id_process),
                                                                    'data'=>'row')
                                                               );
      if(count($result)>0)
       echo '<div> Waktu :'.$result['date_create'].'<br> Oleh: Nandra Maulana Irawan (DEMO ONLY)<br> jumlah : '.$result['qty'].' item</div>';
    }

    
}