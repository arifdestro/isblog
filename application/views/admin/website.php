<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Backup DB</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Backup DB</li>
                    </ol>
                </div>
            </div>
            <?= $this->session->flashdata('pesan'); ?>
        </div>
    </section>

    <section class="content">
        <div class="alert alert-warning" role="alert">
            <i class="fas fa-info-circle"></i> Fitur Restore Data belum berfungsi dengan baik. karena masih terlalu
            rawan terhadap simbol-simbol
        </div>
        <div id="main-wrapper">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">BackUp DB</h3>
                            <!-- <div class="card-tools">
                            </div> -->
                        </div>
                        <div class="card-body text-center">
                            <div class="gambar">
                                <img src="<?= base_url(); ?>assets/dist/img/backup.svg" width="200" alt="halo">
                                <p class="card-text text-sucess mb-5">Backup DB dapat digunakan untuk membuat backup
                                    database terkini.</p>
                            </div>
                            <button href="<?= base_url('admin/website/backup_db'); ?>" class="btn btn-primary" data-toggle="modal" data-target="#modal"><i class="fas fa-file-download"></i> Backup
                                DB</button>
                        </div>
                        <!-- /.card-body -->
                        <!-- <div class="card-footer">
                            The footer of the card
                        </div> -->
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Restore DB</h3>
                            <!-- <div class="card-tools">
                            </div> -->
                        </div>
                        <div class="card-body text-center">
                            <form action="<?php echo base_url('admin/website/import'); ?>" method="post" enctype="multipart/form-data">
                                <div class="gambar">
                                    <img src="<?= base_url(); ?>assets/dist/img/restore.svg" width="200" alt="halo">
                                    <p class="card-text text-sucess mt-3 mb-4">Restore DB dapat digunakan meng-upload
                                        atau
                                        mengganti database.</p>
                                    <div class="form-group">
                                        <label for="file">Upload database (.sql)</label>
                                        <input type="file" name="data" class="form-control-file" id="file" accept=".sql">
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-file-upload"></i>
                                        Restore DB</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                        <!-- <div class="card-footer">
                            The footer of the card
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Backup Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img src="<?= base_url(); ?>assets/dist/icon/download.svg" width="200" alt="halo">
                    <h4 class="mb-4">Apakah anda ingin mengunduh database?</h4>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                <a href="<?= base_url('admin/website/backup_db'); ?>" class="btn btn-primary"><i class="fas fa-file-download"></i> Iya</a>
            </div>
        </div>
    </div>
</div>