  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?= base_url('beranda') ?>" class="brand-link" target="_blank">
          <img src="<?= base_url() ?>assets/dist/img/logo v2.svg" alt="Logo Admin" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-bold">KD-ADMIN</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="<?= base_url('assets/dist/img/user/' . $user['foto_user']); ?>" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                  <a href="<?= base_url('admin/profile') ?>" class="d-block"><?= $user['nama_user'] ?></a>
              </div>
          </div>
          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <li class="nav-item">
                      <a href="<?= base_url('admin/home') ?>" class="nav-link
                      <?php if ($this->uri->segment(2) == "home") {
                            echo "active";
                        } else {
                            echo "";
                        } ?>
                      ">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Beranda
                          </p>
                      </a>
                  </li>
                  <li class="nav-header">Manajemen Postingan</li>
                  <li class="nav-item">
                      <a href="<?= base_url('admin/post') ?>" class="nav-link <?php if ($this->uri->segment(2) == "post") {
                                                                                    echo "active";
                                                                                } else {
                                                                                    echo "";
                                                                                } ?>">
                          <i class="nav-icon fab fa-blogger-b"></i>
                          <p>
                              Data Post
                          </p>
                      </a>
                  </li>
                  <li class="nav-item <?php if ($this->uri->segment(2) == "category" || $this->uri->segment(2) == "tags") {
                                            echo "menu-open";
                                        } else {
                                            echo "";
                                        } ?>">
                      <a href="#" class="nav-link <?php if ($this->uri->segment(2) == "category" || $this->uri->segment(2) == "tags") {
                                                        echo "active";
                                                    } else {
                                                        echo "";
                                                    } ?>">
                          <i class="nav-icon fas fa-edit"></i>
                          <p>
                              Kategori & Tag
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="<?= base_url('admin/category') ?>" class="nav-link <?php if ($this->uri->segment(2) == "category") {
                                                                                                echo "active";
                                                                                            } else {
                                                                                                echo "";
                                                                                            } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Data Kategori</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="<?= base_url('admin/tags') ?>" class="nav-link <?php if ($this->uri->segment(2) == "tags") {
                                                                                            echo "active";
                                                                                        } else {
                                                                                            echo "";
                                                                                        } ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Data Tag</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="<?= base_url('admin/comment') ?>" class="nav-link <?php if ($this->uri->segment(2) == "comment") {
                                                                                        echo "active";
                                                                                    } else {
                                                                                        echo "";
                                                                                    } ?>">
                          <i class="nav-icon fas fa-comment-alt"></i>
                          <p>
                              Data Komentar <span class="badge badge-danger"><?= countPendingComment() ?></span>
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="<?= base_url('admin/visitor') ?>" class="nav-link <?php if ($this->uri->segment(2) == "visitor") {
                                                                                        echo "active";
                                                                                    } else {
                                                                                        echo "";
                                                                                    } ?>">
                          <i class="nav-icon fas fa-chart-area"></i>
                          <p>
                              Pengunjung
                          </p>
                      </a>
                  </li>
                  <?php if ($this->session->userdata('role') == 'Admin') { ?>
                      <li class="nav-header">Data Master</li>
                      <li class="nav-item">
                          <?php if ($user['akses'] != 3) { ?>
                              <a href="<?= base_url('admin/user') ?>" class="nav-link 
                                      <?php if ($this->uri->segment(2) == "user") {
                                            echo "active";
                                        } else {
                                            echo "";
                                        } ?>">
                              <?php } ?>
                              <i class="nav-icon fas fa-user"></i>
                              <p>
                                  Data User
                              </p>
                              </a>
                      </li>
                      <li class="nav-item">
                          <?php if ($user['akses'] != 3) { ?>
                              <a href="<?= base_url('admin/message') ?>" class="nav-link 
                                      <?php if ($this->uri->segment(2) == "message") {
                                            echo "active";
                                        } else {
                                            echo "";
                                        } ?>">
                              <?php } ?>
                              <i class="nav-icon fas fa-envelope"></i>
                              <p>
                                  Data Pesan <span class="badge badge-warning"><?= countPesan() ?></span>
                              </p>
                              </a>
                      </li>
                      <li class="nav-header">Pengaturan</li>
                      <li class="nav-item <?php if ($this->uri->segment(2) == "setting" || $this->uri->segment(2) == "database" || $this->uri->segment(2) == "policy") {
                                                echo "menu-open";
                                            } else {
                                                echo "";
                                            } ?>">
                          <a href="#" class="nav-link <?php if ($this->uri->segment(2) == "setting" || $this->uri->segment(2) == "database" || $this->uri->segment(2) == "policy") {
                                                            echo "active";
                                                        } else {
                                                            echo "";
                                                        } ?>">
                              <i class="nav-icon fas fa-gear"></i>
                              <p>
                                  Setting
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="<?= base_url('admin/policy') ?>" class="nav-link <?php if ($this->uri->segment(2) == "policy") {
                                                                                                echo "active";
                                                                                            } else {
                                                                                                echo "";
                                                                                            } ?>">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Kebijakan</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="<?= base_url('admin/setting') ?>" class="nav-link <?php if ($this->uri->segment(2) == "setting") {
                                                                                                    echo "active";
                                                                                                } else {
                                                                                                    echo "";
                                                                                                } ?>">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>API dan SMTP</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="<?= base_url('admin/database') ?>" class="nav-link <?php if ($this->uri->segment(2) == "database") {
                                                                                                    echo "active";
                                                                                                } else {
                                                                                                    echo "";
                                                                                                } ?>">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Database</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  <?php } ?>
                  <hr>
                  <li class="nav-item bg-danger mb-4">
                      <a data-toggle="modal" data-target="#modal-sm" style="cursor: pointer;" class="nav-link">
                          <i class="nav-icon fas fa-sign-out-alt"></i>
                          <p>
                              Keluar
                          </p>
                      </a>
                  </li>
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>