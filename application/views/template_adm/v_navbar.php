    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <!-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= base_url(); ?>" target="_blank" class="nav-link"><i class="fas fa-external-link-alt"></i></a>
                </li> -->
        </ul>
        <!-- </nav> -->
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-comment-alt"></i>
                    <span class="badge badge-danger navbar-badge"><?= countPendingComment() ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <!-- <img src="<?= base_url() ?>assets/dist/img/user_blank.png" alt="User Avatar" class="img-size-50 mr-3 img-circle"> -->
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Jumlah komentar tersedia
                                    <span class="float-right text-md text-danger">
                                        <h6 class="fw-bold"><?= countPendingComment() ?></h6>
                                    </span>
                                </h3>
                                <!-- <p class="text-sm">Call me whenever you can...</p> -->
                                <p class="text-sm text-muted">Untuk melakukan moderasi silahkan klik link dibawah ini</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="<?= base_url('admin/comment/pending') ?>" class="dropdown-item dropdown-footer">Lihat Seluruh Pesan</a>
                </div>
            </li>
            <?php if ($this->session->userdata('role') == 'Admin') { ?>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-envelope"></i>
                        <span class="badge badge-warning navbar-badge">
                            <?= countPesan() ?>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <?php $notif = $this->db->query('SELECT * FROM pesan WHERE read_msg="0" ORDER BY id_pesan DESC LIMIT 3')->result(); ?>
                        <?php if ($notif == null) : ?>
                            <div class="col-md">
                                <div class="card-body text-center mt-4">
                                    <img src="<?= base_url('assets/dist/icon/notify.svg'); ?>" alt="noData" class="img-rounded img-responsive img-fluid" width="200">
                                </div>
                                <div class="card-body pt-0 mt-4">
                                    <h5 class="text-center text-bold text-muted">Belum terdapat notif terbaru</h6>
                                </div>
                            </div>
                        <?php else : ?>
                            <?php foreach ($notif as $feedback) :
                                $grav_url = 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($feedback->email))) . '?d=mp&s=70';
                            ?>
                                <a href="<?= base_url('admin/message/detail/' . $feedback->id_pesan) ?>" class="dropdown-item">
                                    <!-- Message Start -->
                                    <div class="media">
                                        <img src="<?= $grav_url ?>" alt="User Avatar" class="img-size-50 mr-1 img-circle">
                                        <div class="media-body">
                                            <?php if ($feedback->read_msg === '0') {
                                                $rclass = 'warning';
                                                $gtext  = 'Belum dibaca';
                                            } else {
                                                $rclass = 'success';
                                                $gtext  = 'Sudah dibaca';
                                            } ?>
                                            <span class="badge badge-sm badge-<?= $rclass ?>"><?= $gtext ?></span>
                                            <h3 class="dropdown-item-title">
                                                <?= $feedback->nama ?>
                                            </h3>
                                            <small class="text-muted">
                                                <?= $feedback->email ?>
                                            </small>
                                            <p class="text-sm"><?php
                                                                $string = strip_tags($feedback->isi);
                                                                if (strlen($string) > 50) {

                                                                    // truncate string
                                                                    $stringCut = substr($string, 0, 50);
                                                                    $endPoint  = strrpos($stringCut, ' ');

                                                                    //if the string doesn't contain any space then it will cut without word basis.
                                                                    $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                                    $string .= '...';
                                                                }
                                                                echo $string;
                                                                ?></p>
                                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> <?= $feedback->tanggal ?></p>
                                        </div>
                                    </div>
                                    <!-- Message End -->
                                </a>
                                <div class="dropdown-divider"></div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <a href="<?= base_url('admin/message') ?>" class="dropdown-item dropdown-footer">Lihat Seluruh Pesan</a>
                    </div>
                </li>
            <?php } ?>
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown user-menu">

                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="<?= base_url('assets/dist/img/user/' . $user['foto_user']); ?>" class="user-image img-circle elevation-2" alt="User Image">
                    <span class="d-none d-md-inline"><?= $user['nama_user'] ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-primary">
                        <img src="<?= base_url('assets/dist/img/user/' . $user['foto_user']); ?>" class="img-circle elevation-2" alt="User Image" />
                        <p>
                            <small><span title="admin" class="badge badge-warning"><?= $user['akses'] ?></span></small>
                            <?= obfuscate_email($user['email']) ?>
                        </p>
                    </li>
                    <!-- Menu Body -->
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <a href="<?= base_url('admin/profile') ?>" class="btn btn-outline-primary"><i class="fas fa-user"></i> Profil</a>
                        <button type="button" class="btn btn-outline-danger float-right" data-toggle="modal" data-target="#modal-sm">Keluar</button>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- <ul class="navbar-nav ml-auto">

    </ul> -->
    </nav>
    <!-- /.navbar -->

    <!-- Modal Logout -->
    <div class="modal fade" id="modal-sm" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Logout</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="<?= base_url() ?>assets/dist/icon/logout.svg" width="100%" alt="gambar-logout">
                    <p class="text-center mt-2">Apakah anda yakin ingin logout?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-close"></i> Tidak</button>
                    <a href="<?= base_url('auth/logout'); ?>" class="btn btn-danger">Ya <i class="fas fa-check-circle"></i></a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->