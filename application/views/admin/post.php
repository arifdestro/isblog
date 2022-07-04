<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Post</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/beranda') ?>">Beranda</a></li>
                        <li class="breadcrumb-item active">Data Post</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="px-2">
                <?= $this->session->flashdata('pesan');
                ?>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="card-header">
            <div class="text-center">
                <a class="btn btn-primary btn-sm" href="<?= base_url('admin/post/tambah') ?>">
                    <i class="fas fa-plus-circle"></i> Postingan</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link <?= $tab === 'publish' ? 'active' : '' ?>" href="<?= site_url('admin/post?page=publish') ?>">Dipublikasikan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= $tab === 'draft' ? 'active' : '' ?>" href="<?= site_url('admin/post?page=draft') ?>">Draft</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <table id="post" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Penulis</th>
                                    <th>Kategori</th>
                                    <th>Tanggal</th>
                                    <th>Gambar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($post as $ktg) {
                                ?>
                                    <tr>
                                        <td class="text-center" width="50px"><?= $no++ ?></td>
                                        <td>
                                            <?= word_limiter(strip_tags(htmlspecialchars_decode($ktg->judul_post)), 5) ?>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <i class="fas fa-eye"></i> <a href="javascript:void(0)"></a> <?= $ktg->pengunjung_post ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= $ktg->nama_user ?></td>
                                        <td><?= $ktg->nama_kategori ?></td>
                                        <td><?= mediumdate_indo($ktg->tanggal_post) ?></td>
                                        <td>
                                            <?php
                                            $img = base_url('assets/dist/img/no-image.png');
                                            if ($ktg->gambar_post !== '') {
                                                $img = base_url('assets/img/post/' . $ktg->gambar_post);
                                            }
                                            ?>
                                            <img src="<?= $img ?>" width="100px" alt="<?= $ktg->judul_post ?>">
                                        </td>
                                        <td class="text-center" width="250px">
                                            <a href="<?= base_url("post/detail/$ktg->permalink") ?>" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-external-link-alt"></i> <b>Lihat</b></a>
                                            <a href="<?= base_url("admin/post/get-edit/$ktg->id_post") ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> <b>Edit</b></a>
                                            <a class="btn btn-sm btn-danger del" href="<?= base_url("admin/post/delete/$ktg->id_post") ?>"><i class="fas fa-trash-alt"></i> <b>Hapus</b></a>
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