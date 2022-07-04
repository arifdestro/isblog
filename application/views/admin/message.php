<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pesan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('beranda') ?>">Beranda</a></li>
                        <li class="breadcrumb-item active">Pesan</li>
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
                <?php if ($pes == null) : ?>
                    <button class="btn btn-sm btn-primary disabled">
                        <i class="fas fa-check-double"></i> Tandai Seluruh Notifikasi Terbaca</button>
                <?php else : ?>
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalReadAll">
                        <i class="fas fa-check-double"></i> Tandai Seluruh Notifikasi Terbaca</button>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="notif" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($pes as $s) {
                                ?>
                                    <tr class="text-center">
                                        <td width="100px"><?= $no++ ?></td>
                                        <td><?= $s->nama ?></td>
                                        <td><?= $s->email ?></td>
                                        <td><?= $s->tanggal ?></td>
                                        <?php if ($s->read_msg == '0') {
                                            $badge = 'warning';
                                            $isi = 'Belum Dibaca';
                                        } else {
                                            $badge = 'success';
                                            $isi = 'Terbaca';
                                        } ?>
                                        <td><span class="badge badge-<?= $badge ?>"><?= $isi ?></span></td>
                                        <td class="text-center" width="150px"><a href="<?= base_url('admin/message/detail/' . $s->id_pesan) ?>" class="btn btn-sm btn-info m-1">
                                                <b>Detail</b></a></td>
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
<!-- Modal Baca Seluruh Notifikasi -->
<div class="modal fade" id="modalReadAll">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Tandai Seluruh Notifikasi Sudah Dibaca</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/message/all'); ?>" method="POST">
                <div class="modal-body">
                    <div class="text-center">
                        <img class="mt-2 mb-2" src="<?= base_url(); ?>assets/dist/icon/read.svg" width=80% alt="delete-img">
                        <h4 class="mb-4">Apakah anda yakin untuk menandai seluruh notifikasi telah terbaca?</h4>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-primary">Iya <i class="fas fa-check-double"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>