   <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h4 class="m-0 text-dark">Payment</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/index'); ?>">Home</a></li>
              <li class="breadcrumb-item active">payments</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <?php echo $this->session->flashdata('message');?>
                <div class="card">
                <div class="card-body">
                    <table id="example1" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>First name</th>
                            <th>Transaction ID</th>
                            <th>Payment</th>
                            <th>Phone</th>
                            <th>Class</th>
                            <th></th> 
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($payments as $key => $payment): ?>
                        <tr>
                            <td class="py-1"><?php echo $key +1;?></td>
                            <td><?php echo $payment['firstname'];?></td>
                            <td><?php echo $payment['transaction_id'];?></td>
                            <td><?php echo $payment['plan'];?></td>
                            <td><?php echo $payment['phone'];?></td>
                            <td><?php echo $payment['class'];?></td>
                            <td class="d-flex">
                                <?php if($payment['payment_status'] == 0): ?>
                                <form method="POST" action="<?php echo base_url('admin/payment/status');?>">
                                    <input type="hidden" name="id" value="<?php echo $payment["id"];?>">
                                    <input type="hidden" name="payment_status" value="1">
                                    <button type="submit" class="btn btn-light btn-sm text-muted">
                                        <i class="fa fa-check text-muted"></i>
                                    </button>
                                </form>
                                <?php else:?>
                                <form method="POST" action="<?php echo base_url('admin/payment/status');?>">
                                    <input type="hidden" name="id" value="<?php echo $payment["id"];?>">
                                    <input type="hidden" name="payment_status" value="0">
                                    <button type="submit" class="btn btn-light btn-sm text-muted">
                                        <i class="fa fa-ban text-muted"></i>
                                    </button>
                                </form>
                                <?php endif; ?>  
                                <a href="#delete<?php echo $payment['id'];?>" class="btn btn-light btn-sm text-muted"  data-toggle="modal"><i class="fa fa-trash fa-sm text-danger"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>  
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>First name</th>
                        <th>Transaction ID</th>
                        <th>Payment</th>
                        <th>Phone</th>
                        <th>Class</th>
                        <th></th> 
                        </tr>
                    </tfoot>
                    </table>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>
</div>
<?php foreach($payments as $key=>$payment): ?>
        <div class="modal" id="delete<?php echo $payment['id'];?>">
          <div class="modal-dialog modal-confirm" role="document">
            <div class="modal-content">
            <div class="modal-header flex-column">
                <div class="icon-box">
					<i class="fa fa-exclamation"></i>
				</div>                      
                <h4 class="modal-title w-100">Are you sure?</h4>    
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>
                  Do you really want to delete the payment by student <strong><?php echo word_limiter($payment['firstname'],2);?></strong>?
                  <br> 
                  This process cannot be undone.
                </p>
            </div>
            <div class="modal-footer justify-content-center">
              <?php echo form_open_multipart('admin/student/'.$payment['id'].'/delete');?>
                  <input type="hidden" name="id" value="<?php echo $payment['id'];?>">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </div>
            </div>
          </div>
        </div>
    <?php endforeach;?>
<script src="<?php echo base_url("assets/backend/plugins/jquery/jquery.min.js");?>"></script>