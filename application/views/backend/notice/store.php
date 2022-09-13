<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h4 class="m-0 text-dark">Create notice</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=site_url('admin/index'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Create notice</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="col-md-12">
            <?=$this->session->flashdata('message');?>
            <?php if (validation_errors()) { ?>
                <div class="alert alert-danger">
                    <span> <?php echo validation_errors(); ?> </span>
                </div>
            <?php } ?>
            <div class="card">
              <div class="card-header">New notice</div>
              <div class="card-body">
                <form
                  action="<?=site_url('admin/notices/store'); ?>"
                  method="POST" autocomplete="off">

                  <div class="col-md-12">
                      <div class="form-group ">
                          <label>Title <span class="text-danger">*</span> </label>
                          <input
                            type="text"
                            name="title"
                            value="<?=set_value('title');?>"
                            class="form-control" placeholder="Enter notice title"  required>
                      </div>

                      <div class="form-group ">
                          <label>Body <span class="text-danger">*</span></label>
                          <textarea
                            type="text"
                            name="body"
                            rows="4"
                            class="form-control" required><?=set_value('title') ?></textarea>
                      </div>

                      <div class="form-group ">
                          <label>Expiry Date <span class="text-danger">*</span> </label>
                          <input
                            type="text"
                            class="form-control datepicker"
                            name="expires_on"
                            value="<?=set_value('expires_on'); ?>"
                            required readonly>
                      </div>

                      <div class="form-group">
                          <button type="submit" class="btn btn-primary btn-block btn-flat col-md-2">Save changes</button>
                      </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </section>
</div>
<script src="<?=base_url("assets/backend/plugins/jquery/jquery.min.js");?>"></script>