  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1 class="m-0">Beranda</h1>
                  </div><!-- /.col -->
              </div><!-- /.row -->
          </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
          <div class="container-fluid">
              <!-- Small boxes (Stat box) -->
              <div class="row justify-content-center">
                  <div class="col-sm-12">
                      <?= $this->session->flashdata('pesan') ?>
                      <?php if ($this->session->userdata('role') == 'Admin') { ?>
                          <div class="alert alert-primary shadow alert-sm" role="alert">
                          <?php } else { ?>
                              <div class="alert alert-light shadow alert-sm" role="alert">
                              <?php } ?>
                              <div class="row">
                                  <div class="col-lg-2 col-md-3 col-sm-4 text-center">
                                      <?php if ($this->session->userdata('role') == 'Admin') { ?>
                                          <img src="<?= base_url('assets/dist/img/logo v2.svg') ?>" width="100" alt="halo" />
                                      <?php } else { ?>
                                          <img src="<?= base_url('assets/dist/img/logo.svg') ?>" width="100" alt="halo" />
                                      <?php } ?>
                                  </div>
                                  <div class="col-lg-10 col-md-9 col-sm-8 p-4">
                                      <h6 class="alert-heading">Selamat Datang di
                                          <b>Panel KD-ADMIN</b>
                                      </h6>
                                      <p><i class="fas fa-hand-paper text-warning"></i> Halo, anda login sebagai <?= $user['akses'] ?>.
                                      </p>
                                  </div>
                              </div>
                              </div>
                          </div>
                          <div class="<?php if ($this->session->userdata('role') == 'Admin') {
                                            echo 'col-lg-3';
                                        } else {
                                            echo 'col-lg-4';
                                        } ?> col-6">
                              <!-- small box -->
                              <div class="small-box bg-light shadow">
                                  <div class="inner">
                                      <h3><?= $post ?></h3>
                                      <p>Jumlah Post</p>
                                  </div>
                                  <div class="icon">
                                      <i class="fas fa-list"></i>
                                  </div>
                                  <a href="<?= base_url('admin/post') ?>" class="small-box-footer">Lebih Detail <i class="fas fa-arrow-circle-right"></i></a>
                              </div>
                          </div>
                          <!-- ./col -->
                          <!-- ./col -->
                          <div class="<?php if ($this->session->userdata('role') == 'Admin') {
                                            echo 'col-lg-3';
                                        } else {
                                            echo 'col-lg-4';
                                        } ?> col-6">
                              <!-- small box -->
                              <div class="small-box bg-light shadow">
                                  <div class="inner">
                                      <h3><?= $kategori ?></h3>

                                      <p>Kategori</p>
                                  </div>
                                  <div class="icon">
                                      <i class="fas fa-edit"></i>
                                  </div>
                                  <a href="<?= base_url('admin/category') ?>" class="small-box-footer">Lebih Detail <i class="fas fa-arrow-circle-right"></i></a>
                              </div>
                          </div>
                          <div class="<?php if ($this->session->userdata('role') == 'Admin') {
                                            echo 'col-lg-3';
                                        } else {
                                            echo 'col-lg-4';
                                        } ?> col-6">
                              <!-- small box -->
                              <div class="small-box bg-light shadow">
                                  <div class="inner">
                                      <h3><?= $tag['tag'] ?></h3>

                                      <p>Tag</p>
                                  </div>
                                  <div class="icon">
                                      <i class="fas fa-tags"></i>
                                  </div>
                                  <a href="<?= base_url('admin/tags') ?>" class="small-box-footer">Lebih Detail <i class="fas fa-arrow-circle-right"></i></a>
                              </div>
                          </div>
                          <!-- ./col -->
                          <!-- ./col -->
                          <?php if ($this->session->userdata('role') == 'Admin') { ?>
                              <div class="col-lg-3 col-6">
                                  <!-- small box -->
                                  <div class="small-box bg-light shadow">
                                      <div class="inner">
                                          <h3><?= count($users) ?></h3>

                                          <p>Jumlah User</p>
                                      </div>
                                      <div class="icon">
                                          <i class="fas fa-users"></i>
                                      </div>
                                      <a href="<?= base_url('admin/user') ?>" class="small-box-footer">Lebih Detail <i class="fas fa-arrow-circle-right"></i></a>
                                  </div>
                              </div>
                          <?php } ?>
                  </div>
              </div>
      </section>
  </div>