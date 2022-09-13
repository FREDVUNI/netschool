<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h4 class="m-0 text-dark">Notices</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=site_url('admin/index'); ?>">Home</a></li>
              <li class="breadcrumb-item active">notices</li>
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
                <?=$this->session->flashdata('message');?>
                <div class="card">
                <div class="card-header">
                    <a class="text-secondary text-sm float-right" href="<?=site_url('admin/notices/store'); ?>">
                        <i class="fa fa-plus"></i>  ADD NEW NOTICE
                    </a>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Expires on</th>
                            <th>Date created</th>
                            <th></th> 
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach($notices as $key => $notice): ?>
                        <tr>
                            <td class="py-1"><?=$key + 1;?></td>
                            <td><?=$notice['title'];?></td>
                            <td><?=$notice['expires_on'];?></td>
                            <td><?=date("M d, Y h:i A", strtotime($notice['created_at']));?></td>
                            <td>
                                <a
                                  href="<?=site_url('/admin/notices/'.$notice['id'].'/edit');?>"
                                  class="btn btn-light btn-sm text-muted">
                                    <i class="fa fa-pencil-alt text-muted"></i>
                                </a>
                                <a
                                  href="#delete<?=$notice['id'];?>"
                                  class="btn btn-light btn-sm text-muted"
                                  data-toggle="modal">
                                  <i class="fa fa-trash text-danger"></i>
                                </a>
                            </td>
                        </tr>
                      <?php endforeach; ?>  
                    </tbody>
                      <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Expires On</th>
                            <th>Date created</th>
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

<?php foreach($notices as $notice1){ ?>
    <div class="modal" id="delete<?=$notice1['id'];?>">
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
                Do you really want to delete the notice <strong><?=$notice1['title'];?></strong>?
                <br> 
                This process cannot be undone.
              </p>
          </div>
          <div class="modal-footer justify-content-center">
            <form method="post" action="<?=site_url('admin/notices/'.$notice1['id'].'/delete')?>">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
          </div>
        </div>
      </div>
    </div>
<?php } ?>
<script src="<?php echo base_url("assets/backend/plugins/jquery/jquery.min.js");?>"></script>