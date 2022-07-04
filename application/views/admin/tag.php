<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tag</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/beranda') ?>">Beranda</a></li>
                        <li class="breadcrumb-item active">Tag</li>
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
                    <i class="fas fa-plus-circle"></i> Tag</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tag" class="table table-bordered table-striped">
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
                                <?php foreach ($tag as $tg) {
                                ?>
                                    <tr>
                                        <td class="text-center" width="100px"><?= $no++ ?></td>
                                        <td><?= $tg->nama_tag ?></td>
                                        <td><?= $tg->permalink_tg ?></td>
                                        <td class="text-center" width="250px">
                                            <button class="btn btn-sm btn-warning m-1" data-toggle="modal" data-target="#modal-edit<?= $tg->id_tag ?>"><b><i class="fas fa-edit"></i>
                                                    Edit</b></button>
                                            <a href="<?= base_url("admin/tags/hapus/$tg->id_tag") ?>" class="btn btn-sm btn-danger m-1 del"><i class="fas fa-trash-alt"></i>
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
foreach ($tag as $t) { ?>

    <!-- Modal edit tag -->
    <div class="modal fade" id="modal-edit<?= $t->id_tag ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title title-1" id="myModalLabel">Edit Tag</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="<?= base_url('admin/tags/update_tag'); ?>">
                    <div class="modal-body">
                        <input type="hidden" name="id_tag" value="<?= $t->id_tag ?>" class="form-control">
                        <div class="form-group">
                            <input type="text" name="nama_tag1" id="nama_tag<?= $t->permalink_tg; ?>" class="form-control" autocomplete="off" value="<?= $t->nama_tag; ?>">
                            <small id=" nama_tag<?= $t->permalink_tg; ?>" class="form-text text-muted">Masukkan nama tag tidak boleh menggunakan karakter spesial.</small>
                            <?= form_error('nama_tag1'); ?>
                        </div>
                        <div class="form-group">
                            <label for="email">Permalink</label>
                            <input type="text" id="edit-link<?= $t->permalink_tg; ?>" name="link" class="form-control" value="<?= $t->permalink_tg; ?>" style="background-color: #F8F8F8;outline-color: none;border:0;color:blue;">
                            <?= form_error('link'); ?>
                            <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $('#nama_tag<?= $t->permalink_tg; ?>').keyup(function() {
                                        var title = $(this).val().toLowerCase().replace(/[\/\\#^, +()$~%.'":*?<>{}]/g, '-');
                                        $('#edit-link<?= $t->permalink_tg; ?>').val(title);
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
                <h4 class="modal-title title-1" id="myModalLabel">Tambah Tag</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?= base_url('admin/tags/tambah_tag'); ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="nama_tag" id="nama_tag" class="form-control" autocomplete="off" placeholder="Masukkan Nama Tag . ." aria-describedby="namatag" maxlength="100" onkeypress="return event.charCode < 48 || event.charCode  >57">
                        <small id=" nama_tag" class="form-text text-muted">Masukkan nama tag tidak boleh menggunakan karakter spesial.</small>
                        <?= form_error('nama_tag'); ?>
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