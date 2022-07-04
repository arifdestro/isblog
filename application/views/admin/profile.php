<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User Profil</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('beranda') ?>">Home</a></li>
                        <li class="breadcrumb-item active">User Profil</li>
                    </ol>
                </div>
            </div>
            <div class="px-2">
                <?= $this->session->flashdata('pesan') ?>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img" src="<?= base_url() ?>assets/dist/img/user/<?= $user['foto_user'] ?>" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center"><?= $user['nama_user'] ?></h3>

                            <p class="text-muted text-center"><span class="badge badge-primary"><?= $user['akses'] ?></span></p>
                            <a style="cursor: pointer;" id="btn-edit" class="btn btn-primary btn-block" data-toggle="modal" data-target="#edit-gambar"><b>Edit Gambar <i class="fas fa-edit"></i></b></a>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <?php if ($user['ubah'] != '0000-00-00') {
                                        $date = date_indo($user['ubah']);
                                    } else {
                                        $date = 'Belum Pernah Merubah';
                                    } ?>
                                    <b>Ubah Akun</b> <a class="float-right">
                                        <small><?= $date ?></small>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <?php if ($user['ubah_tanggal'] != '0000-00-00') {
                                        $date_pass = date_indo($user['ubah']);
                                    } else {
                                        $date_pass = 'Belum Pernah Merubah';
                                    } ?>
                                    <b>Ubah Sandi</b> <a class="float-right"><small><?= $date_pass ?></small></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Status Akun <i class="text-success <?= $user['status'] = '1' ? 'far fa-check-circle' : 'fas fa-lock' ?>"></i></b> <a class="float-right">
                                        <?= $user['status'] = '1' ? 'Aktif' : 'Tidak Aktif' ?>
                                    </a>
                                </li>
                            </ul>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <!-- <div class="active tab-pane" id="settings"> -->
                                <form class="form-horizontal" autocomplete="off" method="post" action="<?= base_url('admin/profile/edit') ?>">
                                    <div class="form-group row">
                                        <label for="inputUsername" class="col-sm-3 col-form-label">Nama Akun <?php if ($user['status'] != 1) { ?><span class="text-success"><i class="far fa-check-circle"></i></span><?php } ?></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="username" name="nama_akun" pattern="[^()/><\][\\\x22,;|]+" minlength="4" title="Nama Akun minimal 4 huruf dan angka (atau simbol underscore), contoh '_user9'." placeholder="<?= $user['nama_user'] == null ? 'Username Akun Kosong' :  $user['nama_user'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-3 col-form-label">Email Akun <?php if ($user['status'] != 1) { ?><span class="text-success"><i class="far fa-check-circle"></i><?php } ?></span></label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" id="email" name="email" pattern="^[a-z0-9._%+-]+@gmail\.com$" title="Masukkan email dengan gmail.com, contoh 'axxx@gmail.com'." placeholder="<?= $user['email'] == null ? 'Email Akun Kosong' :  obfuscate_email($user['email']) ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-3 col-sm-6">
                                            <button type="submit" class="btn btn-primary">Simpan <i class="fas fa-save"></i></button>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <form class="form-horizontal" action="<?= base_url('Profil/ubah_pas') ?>" method="post">
                                    <div class="form-group row">
                                        <label for="pas_lama" class="col-sm-3 col-form-label">Sandi Lama</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" id="pas_lama" name="pas_lama" title="Masukkan Sandi Lama." placeholder="Sandi Lama">
                                            <?= form_error('pas_lama', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-3 col-form-label">Sandi Baru</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" id="pas_baru" name="pas_baru" title="Masukkan Sandi Baru." placeholder="Sandi Baru">
                                            <?= form_error('pas_baru', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName2" class="col-sm-3 col-form-label">Verifikasi Sandi Baru</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" id="pas_baru2" name="pas_baru2" title="Lakukan Verifikasi Ulang Sandi Baru." placeholder="Verifikasi Sandi Baru">
                                            <?= form_error('pas_baru2', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-3 col-sm-10">
                                            <button type="submit" class="btn btn-warning">Simpan <i class="fas fa-save"></i></button>
                                        </div>
                                    </div>
                                </form>

                                <!-- </div> -->
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<!-- Modal -->
<?= form_open_multipart('admin/profile/image') ?>
<div class="modal fade" id="edit-gambar" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Gambar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <!-- <div class="container"> -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Unggah Gambar</label>
                                <div class="preview-zone hidden">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <div><b>Pratinjau</b></div>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-danger btn-xs remove-preview">
                                                    <i class="fa fa-times"></i> Ulang
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body"></div>
                                    </div>
                                </div>
                                <div class="dropzone-wrapper">
                                    <div class="dropzone-desc">
                                        <i class="glyphicon glyphicon-download-alt"></i>
                                        <div>Pilih file gambar atau seret gambar kesini. (*Maks 2MB)</div>
                                    </div>
                                    <input type="file" name="image" class="dropzone" accept=".png, .jpg, .jpeg" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->
                    <?= form_error('image', '<small class="text-danger col-md">', '</small>'); ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan <i class="fas fa-save"></i></button>
            </div>
        </div>
    </div>
</div>
<?= form_close() ?>