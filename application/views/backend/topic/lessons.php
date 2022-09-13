<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h4 class="m-0 text-dark">Lessons (Topic: <?=$theTopic['topic'];?>)</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=site_url('admin/index'); ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?=site_url('admin/topics'); ?>">Topics</a></li>
              <li class="breadcrumb-item active">lessons</li>
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
                    <a
                        class="text-secondary text-sm float-right"
                        href="<?=site_url('admin/'.$theTopic['slug'].'/topic/lesson/store'); ?>">
                        <i class="fa fa-plus"></i>  ADD NEW LESSON
                    </a>
                </div>
                <div class="card-body">
                    <table id="lessons-datatable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th width="50px">Up</th>
                            <th width="50px">Down</th>
                            <th>Title</th>
                            <th>Topic</th>
                            <th>Level</th>
                            <th>Subject</th>
                            <th></th> 
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($lessons as $key => $lesson): ?>
                        <tr>
                            <td class="py-1 text-center">
                                <img src="<?php echo $lesson['image'];?>" alt="image" class="rounded-circle" width="35px" height="35px">
                            </td>
                            <td>
                                <a
                                    href="<?=site_url('admin/'.$theTopic['slug'].'/topic/lessonUp/'.$lesson['lesson_id']);?>"><i class="fa fa-arrow-up"></i></a>
                            </td>
                            <td>
                                <a href="<?=site_url('admin/'.$theTopic['slug'].'/topic/lessonDown/'.$lesson['lesson_id']);?>"><i class="fa fa-arrow-down"></i></a>
                            </td>
                            <td><?=$lesson['title'];?></td>
                            <td><?php echo word_limiter($lesson['topic'],2);?></td>
                            <td><?php echo $lesson['level'];?></td>
                            <td><?php echo $lesson['subject'];?></td>
                            <td>
                                <a
                                    href="<?=site_url('admin/'.$theTopic['slug'].'/topic/lessonEdit/'.$lesson['slug']);?>"
                                    class="btn btn-light btn-sm text-muted">
                                    <i class="fa fa-pencil-alt text-muted"></i>
                                </a>
                                <a href="#delete<?php echo $lesson['slug'];?>" class="btn btn-light btn-sm text-muted"  data-toggle="modal"><i class="fa fa-trash text-danger"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>  
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Up</th>
                        <th>Down</th>
                        <th>Title</th>
                        <th>Topic</th>
                        <th>Level</th>
                        <th>Subject</th>
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
<?php foreach($lessons as $key=>$lesson): ?>
        <div class="modal" id="delete<?php echo $lesson['slug'];?>">
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
                  Do you really want to delete the lesson <strong><?php echo word_limiter($lesson['topic'],2);?></strong>?
                  <br> 
                  This process cannot be undone.
                </p>
            </div>
            <div class="modal-footer justify-content-center">
              <?php echo form_open_multipart('admin/'.$theTopic['slug'].'/topic/lessonDelete/'.$lesson['lesson_id']);?>
                  <input type="hidden" name="lesson_id" value="<?php echo $lesson['lesson_id'];?>">
                  <input type="hidden" name="old_image" value="<?php echo $lesson['image']; ?>">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </div>
            </div>
          </div>
        </div>
    <?php endforeach;?>
<script src="<?php echo base_url("assets/backend/plugins/jquery/jquery.min.js");?>"></script>