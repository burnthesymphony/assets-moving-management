    </aside><!-- /.right-side -->
        </div>
        <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title"></h4>

            </div>
            <div class="modal-body"><div class="te"></div></div>
         
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
  
  <script type="text/javascript" src="<?php echo base_url('assets/js/form-validator/jquery.form-validator.min.js') ?>"></script>
  <script>
    $.validate();
    function confirm_delete(url){
    	var r =confirm('Apa Anda Yakin Delete Data?');
    	if(r==true)
    		location.href=url;
    	else
    		return false;
    }
   </script>
<script src="<?php echo base_url('assets/js/jquery-ui-1.10.3.min.js')?>" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url('assets/js/bootstrap.min.js')?>" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/js/AdminLTE/app.js')?>" type="text/javascript"></script>