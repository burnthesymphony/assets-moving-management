   <!--<script src="<?php echo base_url('assets/js/jquery.js')?>"></script>
        <link rel="stylesheet" href="<?php echo base_url('assets/ui/themes/base/jquery.ui.all.css') ?>">
        <script src="<?php echo base_url('assets/ui/jquery.ui.core.js')?>"></script>
        <script src="<?php echo base_url('assets/ui/jquery.ui.widget.js')?>"></script>
        <script src="<?php echo base_url('assets/ui/jquery.ui.datepicker.js?v=rand()')?>"></script>
        <script>
                 $(function() {
              init_tanggal();
       
    });

                function init_tanggal(){
                  alert('aaa');
                     $( ".datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd' 
        });
                }
            </script>-->
  <tr>
              <td><?php echo form_input($form_['frm_nama_perusahaan'])?></td>
              <td><?php echo form_textarea($form_['frm_alamat_kerja'])?></td>
              <td><?php echo form_input($form_['frm_position'])?></td>
              <td><?php echo form_input($form_['frm_mulai_kerja'])?> - <?php echo form_input($form_['frm_akhir_kerja'])?>  </td>
              <td><?php echo form_textarea($form_['frm_reason_to_leave'])?></td>
              <td><?php echo form_input($form_['frm_contact_number'])?> </td>
          </tr>
      