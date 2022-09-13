<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h4 class="m-0 text-dark">Frequently Asked questions</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/index'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Frequently Asked questions</li>
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
                    <a class="text-secondary text-sm float-right" href="<?php echo base_url('admin/faq/store'); ?>">
                        <i class="fa fa-plus"></i>  ADD NEW QUESTION
                    </a>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Date created</th>
                            <th></th> 
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($faqs as $key => $faq): ?>
                        <tr>
                            <td class="py-1"><?php echo $key + 1;?></td>
                            <td><?php echo word_limiter($faq['question'],2);?></td>
                            <td><?php echo word_limiter($faq['answer'],2);?></td>
                            <td><?php echo date("M d, Y h:i A", strtotime($faq['date_created']));?></td>
                            <td>
                                <a href="<?php echo base_url('/admin/'.$faq['slug'].'/faq');?>" class="btn btn-light btn-sm text-muted"><i class="fa fa-pencil-alt text-muted"></i></a>
                                <a href="#delete<?php echo $faq['slug'];?>" class="btn btn-light btn-sm text-muted"  data-toggle="modal"><i class="fa fa-trash text-danger"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>  
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Question</th>
                        <th>Answer</th>
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
<?php foreach($faqs as $key=>$faq): ?>
        <div class="modal" id="delete<?php echo $faq['slug'];?>">
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
                  Do you really want to delete the question <strong><?php echo $faq['question'];?></strong>?
                  <br> 
                  This process cannot be undone.
                </p>
            </div>
            <div class="modal-footer justify-content-center">
              <?php echo form_open_multipart('admin/faq/'.$faq['id'].'/delete');?>
                  <input type="hidden" name="id" value="<?php echo $faq['id'];?>">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </div>
            </div>
          </div>
        </div>
    <?php endforeach;?>
<script src="<?php echo base_url("assets/backend/plugins/jquery/jquery.min.js");?>"></script>