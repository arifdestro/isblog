<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kategori</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/beranda') ?>">Beranda</a></li>
                        <li class="breadcrumb-item active">Kategori</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
        <div>
            <?= $this->session->flashdata('pesan') ?>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="card-header">
            <div class="text-center">
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-tambah">
                    <i class="fas fa-plus-circle"></i> Kategori</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="kat" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama Kategori</th>
                                    <th>Permalink</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($kategori as $ktg) {
                                ?>
                                    <tr>
                                        <td class="text-center" width="100px"><?= $no++ ?></td>
                                        <td><?= $ktg->nama_kategori ?></td>
                                        <td><?= $ktg->permalink_kt ?></td>
                                        <td class="text-center" width="250px">
                                            <button class="btn btn-sm btn-warning m-1" data-toggle="modal" data-target="#modal-edit<?= $ktg->id_kategori ?>"><b><i class="fas fa-edit"></i>
                                                    Edit</b></button>
                                            <a href="<?= base_url("admin/category/hapus/$ktg->id_kategori") ?>" class="btn btn-sm btn-danger m-1 del"><i class="fas fa-trash-alt"></i>
                                                <b>Hapus</b></a>
                                        </td>
                                    </tr>
                                <?php
                                } ?>
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

<?php
foreach ($kategori as $ktg) { ?>

    <!-- Modal edit kategori -->
    <div class="modal fade" id="modal-edit<?= $ktg->id_kategori ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title title-1" id="myModalLabel">Edit Kategori</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="<?= base_url('admin/category/update_kategori'); ?>">
                    <div class="modal-body">
                        <input type="hidden" name="id_kategori" value="<?= $ktg->id_kategori ?>" class="form-control">
                        <div class="form-group">
                            <input type="text" name="nama_kategori1" id="nama_kategori<?= $ktg->permalink_kt; ?>" class="form-control" autocomplete="off" value="<?= $ktg->nama_kategori; ?>">
                            <small id=" nama_kategori<?= $ktg->permalink_kt; ?>" class="form-text text-muted">Masukkan nama kategori tidak boleh menggunakan karakter spesial.</small>
                            <?= form_error('nama_kategori1'); ?>
                        </div>
                        <div class="form-group">
                            <label for="email">Permalink</label>
                            <input type="text" id="edit-link<?= $ktg->permalink_kt; ?>" name="link" class="form-control" value="<?= $ktg->permalink_kt; ?>" style="background-color: #F8F8F8;outline-color: none;border:0;color:blue;">
                            <?= form_error('link'); ?>
                            <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $('#nama_kategori<?= $ktg->permalink_kt; ?>').keyup(function() {
                                        var title = $(this).val().toLowerCase().replace(/[\/\\#^, +()$~%.'":*?<>{}]/g, '-');
                                        $('#edit-link<?= $ktg->permalink_kt; ?>').val(title);
                                    });
                                })
                            </script>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="save-btn" class="btn btn-primary btn-block"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
} ?>

<!-- Modal tambah kategori -->
<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title title-1" id="myModalLabel">Tambah Kategori</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?= base_url('admin/category/tambah_kategori'); ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" autocomplete="off" placeholder="Masukkan Nama Kategori . ." aria-describedby="namakategori" maxlength="100" onkeypress="return event.charCode < 48 || event.charCode  >57">
                        <small id=" nama_kategori" class="form-text text-muted">Masukkan nama kategori tidak boleh menggunakan karakter spesial.</small>
                        <?= form_error('nama_kategori'); ?>
                    </div>
                    <div class="form-group">
                        <label for="email">Permalink</label>
                        <input type="text" id="link" name="link" class="form-control" style="background-color: #F8F8F8;outline-color: none;border:0;color:blue;">
                        <?= form_error('link'); ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="save-btn" class="btn btn-primary btn-block"><i class="fas fa-save"></i> Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>