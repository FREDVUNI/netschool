<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h4 class="m-0 text-dark">Subscriptions</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/index'); ?>">Home</a></li>
              <li class="breadcrumb-item active">subscriptions</li>
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
                            <th>Email</th>
                            <th>status</th>
                            <th></th> 
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($subscriptions as $key => $subscription): ?>
                        <tr>
                            <td class="py-1 text-center">
                                <img src="<?php echo base_url('assets/backend/images/uploads/students/default.png');?>"  alt="image" class="profile-pic rounded-circle" width="35px" height="35px">
                            </td>
                            <td><?php echo $subscription['email'];?></td>
                            <td>
                                <?php if($subscription['verify'] == TRUE):?>
                                    <span class="badge badge-success">Verified</span>
                                <?php else:?>
                                    <span class="badge badge-danger">Pending</span>
                                <?php endif;?>
                            </td>
                            <td class="text-center">
                                <a href="#delete<?php echo $subscription['id'];?>" class="btn btn-light btn-sm text-muted" data-toggle="modal"><i class="fa fa-trash text-danger"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>  
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>status</th>
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
<?php foreach($subscriptions as $key=>$subscription): ?>
        <div class="modal" id="delete<?php echo $subscription['id'];?>">
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
                  Do you really want to delete the subscription <strong><?php echo word_limiter($subscription['email'],2);?></strong>?
                  <br> 
                  This process cannot be undone.
                </p>
            </div>
            <div class="modal-footer justify-content-center">
              <?php echo form_open_multipart('admin/subscription/'.$subscription['id'].'/delete');?>
                  <input type="hidden" name="id" value="<?php echo $subscription['id'];?>">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </div>
            </div>
          </div>
        </div>
    <?php endforeach;?>
<script src="<?php echo base_url("assets/backend/plugins/jquery/jquery.min.js");?>"></script>