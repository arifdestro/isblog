<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('beranda') ?>">Beranda</a></li>
                        <li class="breadcrumb-item active">Data User</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
        <div>
            <?= $this->session->flashdata('pesan'); ?>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="card-header">
            <div class="text-center">
                <button class="btn btn-primary m-1 btn-sm" data-toggle="modal" data-target="#modal-tambah">
                    <i class="fas fa-plus-circle"></i> User</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="user" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Hak Akses</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($_user as $s) {
                                ?>
                                    <tr class="text-center">
                                        <td><?= $no++ ?></td>
                                        <td width="200px"><?= $s->nama_user ?></td>
                                        <td><?= $s->akses ?></td>
                                        <td><?php
                                            if ($s->status == 1) {
                                                $kon = 'Aktif';
                                                $ico = 'success';
                                            } elseif ($s->status == 0) {
                                                $kon = 'Tidak Aktif';
                                                $ico = 'secondary';
                                            } else {
                                                $kon = 'Akun Diblokir';
                                                $ico = 'danger';
                                            } ?>

                                            <span class="badge badge-<?= $ico ?>"><?= $kon ?></span>
                                        </td>
                                        <td class="text-center" width="400px">
                                            <button class="btn btn-sm btn-info m-1" data-toggle="modal" data-target="#modal-info<?= $s->id_user ?>"><b><i class="fas fa-eye"></i>
                                                    Info</b></button>
                                            <button class="btn btn-sm btn-warning m-1" data-toggle="modal" data-target="#modal-edit<?= $s->id_user ?>"><b><i class="fas fa-edit"></i>
                                                    Edit</b></button>
                                            <a href="<?= site_url('delete_u/' . $s->id_user) ?>" class="btn btn-sm btn-danger m-1 del"><i class="fas fa-trash-alt"></i>
                                                <b>Hapus</b></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?= form_open('admin/user/tambah_akun', 'autocomplete="off"') ?>
<div class="modal fade" id="modal-tambah" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Data Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="Nama">Nama Akun</label>
                    <input type="text" class="form-control" name="nama" id="nama" aria-describedby="namaHelp">
                    <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
                    <small id="namaHelp" class="form-text text-muted">Masukkan Nama Pengguna.</small>
                </div>
                <div class="form-group">
                    <label for="Email">Email Aktif</label>
                    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
                    <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                    <small id="emailHelp" class="form-text text-muted">Masukkan Email Aktif.</small>
                </div>
                <div class="form-group">
                    <label for="Pass">Sandi Akun</label>
                    <input type="password" class="form-control" name="pass_akun" id="pass_akun" aria-describedby="passHelp">
                    <?= form_error('pass_akun', '<small class="text-danger">', '</small>'); ?>
                    <small id="passHelp" class="form-text text-muted">Masukkan Kata Sandi.</small>
                </div>
                <?php if ($user['akses'] == 'Admin') { ?>
                    <div class="form-group">
                        <label for="jenis">Hak Akses</label>
                        <select class="form-control" name="jenis" id="jenis">
                            <option value="">-- Pilih Jenis Akses --</option>
                            <?php
                            $get = $this->db->query("SELECT * FROM akses WHERE akses != '{$user['akses']}'")->result();
                            foreach ($get as $k) {
                            ?>
                                <option value="<?= $k->id_role ?>"><?= $k->akses ?></option>
                            <?php } ?>
                        </select>
                    </div>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-block btn-primary">Simpan <i class="fas fa-save"></i></button>
            </div>
        </div>
    </div>
</div>
<?= form_close() ?>

<?php
$id_user = $this->session->userdata('id_usr');
$ket = $this->db->query("SELECT * FROM `user`, `akses` WHERE user.id_role = akses.id_role")->result();
foreach ($ket as $x) { ?>
    <div class="modal fade" id="modal-info<?= $x->id_user ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Info Akun <?= $x->nama_user ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img" src="<?= base_url() ?>assets/dist/img/user/<?= $x->foto_user ?>" alt="User profile picture">
                            </div>

                            <p class="text-muted text-center"><span class="badge badge-primary"><?= $x->akses ?></span>
                                <?php if ($x->status == 0) {
                                    $text = 'Tidak Aktif';
                                    $ic = 'secondary';
                                } elseif ($x->status == 1) {
                                    $text = 'Aktif';
                                    $ic = 'success';
                                } else {
                                    $text = 'Diblokir';
                                    $ic = 'danger';
                                } ?>
                                <span class="badge badge-<?= $ic ?>"><?= $text ?></span>
                            </p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Nama Akun</b> <a class="float-right">
                                        <small><?= $x->nama_user ?></small>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email Akun</b> <a class="float-right">
                                        <small><?= $x->email ?></small>
                                    </a>
                                </li>
                                <?php if ($x->ubah != '0000-00-00') {
                                    $date = date_indo($x->ubah);
                                } else {
                                    $date = 'Belum Pernah Merubah';
                                } ?>
                                <li class="list-group-item">
                                    <b>Ubah Info Akun</b> <a class="float-right">
                                        <small><?= $date ?></small>
                                    </a>
                                </li>
                                <?php if ($x->ubah_tanggal != '0000-00-00') {
                                    $date_pass = date_indo($x->ubah_tanggal);
                                } else {
                                    $date_pass = 'Belum Pernah Merubah';
                                } ?>
                                <li class="list-group-item">
                                    <b>Ubah Password</b> <a class="float-right"><small><?= $date_pass ?></small></a>
                                </li>
                            </ul>

                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-block btn-secondary" data-dismiss="modal" aria-label="Close">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <?= form_open('admin/user/ubah_akun', 'autocomplete="off"') ?>
    <div class="modal fade" id="modal-edit<?= $x->id_user ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Ubah Data Akun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Nama">Nama User</label>
                        <input type="text" class="form-control" name="nama" id="nama" value="<?= $x->nama_user ?>" aria-describedby="namaHelp">
                        <small id="namaHelp" class="form-text text-muted">Masukkan Nama Pengguna.</small>
                    </div>
                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?= $x->email ?>" aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted">Masukkan Email Aktif.</small>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" aria-describedby="passwordHelp">
                        <small id="passwordHelp" class="form-text text-muted">Masukkan Kata Sandi.</small>
                    </div>
                    <div class="form-group">
                        <label for="status">Hak Akses</label>
                        <select class="form-control" name="status" id="status">
                            <option value="">-- Pilih Jenis Akses --</option>
                            <option value="0" <?= $x->status == 0 ? 'selected' : '' ?>>Tidak Aktif</option>
                            <option value="1" <?= $x->status == 1 ? 'selected' : '' ?>>Aktif</option>
                            <option value="2" <?= $x->status == 2 ? 'selected' : '' ?>>Diblokir</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id_user" value="<?= $x->id_user ?>">
                    <button type="submit" class="btn btn-block btn-primary">Simpan <i class="fas fa-save"></i></button>
                </div>
            </div>
        </div>
    </div>
    <?= form_close() ?>
<?php } ?>