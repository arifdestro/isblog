<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $judul ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/beranda') ?>">Beranda</a></li>
                        <li class="breadcrumb-item active"><?= $judul ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="row justify-content-center">
            <?php foreach ($pesan as $detAng) { ?>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-6 text-start">
                                    <?php $grav_url = 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($detAng->email))) . '?d=mp&s=70'; ?>
                                    <img src="<?= $grav_url ?>" alt="User Avatar" class="img-size-50 mr-1 img-circle">
                                    (<?= $detAng->nama ?>) <?= $detAng->email ?>
                                </div>
                                <div class="col-lg-6 text-center pt-2">
                                    Tanggal: <?= $detAng->tanggal ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            [Isi Pesan] </br>
                            <?= $detAng->isi ?>
                        </div>
                        <div class="card-footer">
                            <a class="btn btn-secondary px-3 mr-1" href="<?= base_url('admin/message') ?>">Kembali</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
</div>
</section>
</div>