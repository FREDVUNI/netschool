<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h4 class="m-0 text-dark">Teachers / instructors</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/index'); ?>">Home</a></li>
              <li class="breadcrumb-item active">teachers</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <style>

    </style>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <?php echo $this->session->flashdata('message');?>
                <div class="card">
                <div class="card-header">
                    <a class="text-secondary float-right text-sm" href="<?php echo base_url('admin/teacher/create'); ?>">
                        <i class="fa fa-plus"></i>  ADD NEW TEACHER
                    </a>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>First name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th></th> 
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($teachers as $teacher): ?>
                        <tr>
                            <td class="py-1 text-center">
                                <img src="<?php echo base_url('assets/backend/images/uploads/teachers/').$teacher['image'];?>"  alt="image" class="profile-pic rounded-circle" width="35px" height="35px">
                            </td>
                            <td><?php echo $teacher['firstname'];?></td>
                            <td><?php echo $teacher['email'];?></td>
                            <td><?php echo $teacher['phone'];?></td>
                            <td class="text-center">
                                <?php if($teacher['status'] == FALSE):?>
                                <form action="<?php echo base_url('admin/teacher/status');?>" method="post">
                                    <a href="<?php echo base_url('/admin/'.$teacher['slug'].'/teacher');?>" class="btn btn-light btn-sm text-muted"><i class="fa fa-pencil-alt text-muted"></i></a>
                                    <a href="#delete<?php echo $teacher['slug'];?>" class="btn btn-light btn-sm text-muted"  data-toggle="modal"><i class="fa fa-trash text-danger"></i></a>
                                    <button type="submit" class="btn btn-light btn-sm text-danger">
                                    <input type="hidden" name="teacher_id" value="<?php echo $teacher['teacher_id'];?>">
                                    <input type="hidden" name="status" value="1">
                                    <i class="fa fa-ban"></i> Block
                                    </button>
                                </form>
                                <?php else: ?>
                                <form action="<?php echo base_url('admin/teacher/status');?>" method="post">
                                    <a href="<?php echo base_url('/admin/'.$teacher['slug'].'/teacher');?>"><i class="fa fa-pencil-alt text-dark fa-sm"></i></a>
                                    <a href="#delete<?php echo $teacher['slug'];?>" class="btn btn-light btn-sm text-muted"  data-toggle="modal"><i class="fa fa-trash ml-3 fa-sm text-danger"></i></a>
                                    <button type="submit" class="btn text-danger">
                                    <input type="hidden" name="teacher_id" value="<?php echo $teacher['teacher_id'];?>">
                                    <input type="hidden" name="status" value="0">
                                    <i class="fa fa-ban"></i> Unblock
                                    </button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>  
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>First name</th>
                            <th>Email</th>
                            <th>Phone</th>
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
    <?php foreach($teachers as $key=>$teacher): ?>
        <div class="modal" id="delete<?php echo $teacher['slug'];?>">
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
                  Do you really want to delete the teacher <strong><?php echo $teacher['firstname'];?></strong>?
                  <br> 
                  This process cannot be undone.
                </p>
            </div>
            <div class="modal-footer justify-content-center">
              <?php echo form_open_multipart('admin/teacher/'.$teacher['teacher_id'].'/delete');?>
                  <input type="hidden" name="teacher_id" value="<?php echo $teacher['teacher_id'];?>">
                  <input type="hidden" name="old_image" value="<?php echo $teacher['image']; ?>">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </div>
            </div>
          </div>
        </div>
    <?php endforeach;?>
<script src="<?php echo base_url("assets/backend/plugins/jquery/jquery.min.js");?>"></script>