<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?php echo base_url("admin/index"); ?>" class="brand-link">
      <img src="<?php echo base_url('assets/backend/images/icon.png');?>" alt="net school logo" class="brand-image" style="opacity: .9">
      <span class="brand-text font-weight-light">Netschool Ug</span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url('assets/backend/images/uploads/admins/').$user['image'];?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?php echo base_url("admin/profile"); ?>" class="d-block"><?php echo $user['username']; ?></a>
        </div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?php echo base_url("admin/index"); ?>" class="nav-link <?php echo (current_url() == base_url("admin/index"))?"active":"";?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url("admin/payments"); ?>" class="nav-link <?php echo (current_url() == base_url("admin/payments"))?"active":"";?>">
              <i class="nav-icon far fa-money-bill-alt"></i>
              <p>
                Payments
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url("admin/teachers"); ?>" class="nav-link <?php echo (current_url() == base_url("admin/teachers"))?"active":"";?>">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>
                Team Members
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="<?php echo base_url("admin/students"); ?>" class="nav-link <?php echo (current_url() == base_url("admin/students"))?"active":"";?>">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                Students
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="<?php echo base_url("admin/topics"); ?>" class="nav-link <?php echo (current_url() == base_url("admin/topics"))?"active":"";?>">
              <i class="nav-icon fa fa-bookmark"></i>
              <p>
                Topics
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="<?php echo base_url("admin/lessons"); ?>" class="nav-link <?php echo (current_url() == base_url("admin/lessons"))?"active":"";?>">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Lessons
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="<?php echo base_url("admin/samplevideos"); ?>" class="nav-link <?php echo (current_url() == base_url("admin/samplevideos"))?"active":"";?>">
              <i class="nav-icon fas fa-play"></i>
              <p>
                Sample videos
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="<?php echo base_url("admin/levels"); ?>" class="nav-link <?php echo (current_url() == base_url("admin/levels"))?"active":"";?>">
              <i class="nav-icon fas fa-sticky-note"></i>
              <p>
                Classes
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="<?php echo base_url("admin/terms"); ?>" class="nav-link <?php echo (current_url() == base_url("admin/term"))?"active":"";?>">
              <i class="nav-icon fas fa-calendar"></i>
              <p>
                Terms
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a
              href="<?=site_url("admin/subjects"); ?>"
              class="nav-link <?=(current_url() == site_url("admin/subjects")) ? "active" : "";?>">
                <i class="nav-icon fas fa-clipboard"></i> Subjects
              </a>
          </li>
          <li class="nav-item">
            <a
              href="<?=site_url("admin/notices"); ?>"
              class="nav-link <?=(current_url() == site_url("admin/notices")) ? "active" : "" ;?>">
                <i class="nav-icon fas fa-clipboard"></i> Notices
              </a>
          </li>
          <li class="nav-item">
          <a href="<?php echo base_url("admin/faqs"); ?>" class="nav-link <?php echo (current_url() == base_url("admin/faqs"))?"active":"";?>">
              <i class="nav-icon fas fa-clipboard"></i>
              <p>
                FAQs
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="<?php echo base_url("admin/messages"); ?>" class="nav-link <?php echo (current_url() == base_url("admin/messages"))?"active":"";?>">
              <i class="nav-icon far fa-comments"></i>
              <p>
                Mailbox
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="<?php echo base_url("admin/subscriptions"); ?>" class="nav-link <?php echo (current_url() == base_url("admin/subscriptions"))?"active":"";?>">
              <i class="nav-icon fas fa-bell"></i>
              <p>
                Subscriptions
              </p>
            </a>
          </li>
          </li>
          <li class="nav-item">
          <a href="<?php echo base_url("admin/users"); ?>" class="nav-link <?php echo (current_url() == base_url("admin/users"))?"active":"";?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Admins
              </p>
            </a>
          </li>
          <hr>
        </ul>
      </nav>
    </div>
  </aside>