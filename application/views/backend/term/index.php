<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h4 class="m-0 text-dark">Terms</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/index'); ?>">Home</a></li>
              <li class="breadcrumb-item active">terms</li>
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
                <div class="card-header">
                    <a class="text-secondary text-sm float-right" href="<?php echo base_url('admin/term/store'); ?>">
                        <i class="fa fa-plus"></i>  ADD NEW TERM
                    </a>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Term</th>
                            <th>Date created</th>
                            <th></th> 
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($terms as $key => $term): ?>
                        <tr>
                            <td class="py-1"><?php echo $key + 1;?></td>
                            <td><?php echo word_limiter($term['term'],3);?></td>
                            <td><?php echo date("M d, Y h:i A", strtotime($term['date_created']));?></td>
                            <td>
                                <a href="<?php echo base_url('/admin/'.$term['slug'].'/term');?>" class="btn btn-light btn-sm text-muted"><i class="fa fa-pencil-alt text-muted"></i></a>
                                <a href="#delete<?php echo $term['slug'];?>" class="btn btn-light btn-sm text-muted"  data-toggle="modal"><i class="fa fa-trash text-danger"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>  
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Term</th>
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
<?php foreach($terms as $key=>$term): ?>
        <div class="modal" id="delete<?php echo $term['slug'];?>">
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
                  Do you really want to delete the term <strong><?php echo $term['term'];?></strong>?
                  <br> 
                  This process cannot be undone.
                </p>
            </div>
            <div class="modal-footer justify-content-center">
              <?php echo form_open_multipart('admin/term/'.$term['term_id'].'/delete');?>
                  <input type="hidden" name="term_id" value="<?php echo $term['term_id'];?>">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </div>
            </div>
          </div>
        </div>
    <?php endforeach;?>
<script src="<?php echo base_url("assets/backend/plugins/jquery/jquery.min.js");?>"></script>