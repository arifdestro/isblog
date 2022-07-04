<?= $this->session->flashdata('message') ?>
<!-- Basic features section-->
<section class="mt-5">
    <div class="container px-5">
        <div class="row gx-5 align-items-center justify-content-center justify-content-lg-between">
            <div class="col-sm-12 col-md-6">
                <h2 class="display-7 lh-1 mb-4 font-alt">
                    <img src="<?= base_url() ?>assets/img/logo_1.svg" alt="logo" width="50" height="44" class="mb-2 v1">
                    <img src="<?= base_url() ?>assets/img/logo_2.svg" alt="logo" width="50" height="44" class="mb-2 v2">
                    Kang Dongeng
                </h2>
                <p class="lead fw-normal text-muted mb-4">Platform ini dibuat hanya untuk gabut semata, silahkan jika berminat untuk melihat-lihat.</p>
                <div class="d-flex flex-column flex-lg-row mb-lg-0">
                    <a class="me-lg-3 mb-4 mb-lg-0 btn btn-primary" href="#category">Pilih Postingan <i class="fas fa-chevron-down"></i></a>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 text-center">
                <div class="px-3 px-sm-0"><img class="card-img-top rounded" id="imgHead" src="<?= base_url() ?>assets/img/programer.gif" alt="gambar-header section" /></div>
                <div class="px-4 px-sm-0"><img class="img-fluid rounded" id="imgHead2" src="<?= base_url() ?>assets/img/sleep v2.gif" alt="gambar-header section" /></div>
            </div>
        </div>
    </div>
</section>
<section id="category">
    <div class="container px-5">
        <div class="row gx-5 align-items-center justify-content-center justify-content-lg-between">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <span class="badge bg-dark lh-1 mb-2">Kategori</span>
                <p class="lead fw-normal mb-4">Terdapat beberapa kategori pilihan di bawah ini.</p>
                <ul class="nav">
                    <?php $all = $this->db->get_where('post', ['status_post' => 1])->num_rows(); ?>
                    <li class="nav-item me-1 ms-0">
                        <a class="me-lg-3 mb-4 mb-lg-0 btn btn-sm btn-danger" href="<?= base_url() ?>">Semua (<?= $all ?>) <i class="fas fa-chevron-down"></i></a>
                    </li>
                    <?php foreach ($kategori->result() as $k) { ?>
                        <li class="nav-item me-1 ms-0">
                            <a class="me-lg-3 mb-4 mb-lg-0 btn btn-sm btn-secondary" href="<?= base_url('kategori/' . strtolower($k->permalink_kt)) ?>"><?= $k->nama_kategori ?> (<?= $k->jumlah ?>) <i class="fas fa-chevron-right"></i></a>
                        </li>
                    <?php } ?>
                    <li class="nav-item me-1 ms-0">
                        <a class="me-lg-3 mb-4 mb-lg-0 btn btn-sm btn-primary" href="<?= base_url('kategori') ?>">Selengkapnya <i class="fas fa-chevron-right"></i></a>
                    </li>
                </ul>
            </div>
            <div class="col-sm-12 mt-5">
                <div class="row">
                    <?php foreach ($post as $p) { ?>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                            <div class="card shadow">
                                <div class="img-hover-zoom rounded">
                                    <a href="<?= base_url('post/detail/' . $p->permalink) ?>">
                                        <?php
                                        $imgPost = base_url('assets/dist/img/no-image.png');
                                        if ($p->gambar_post !== '') {
                                            $imgPost = base_url('assets/img/thumb/' . $p->gambar_post);
                                        }
                                        ?>
                                        <img src="<?= $imgPost ?>" class="card-img-top cover" alt="gambar_<?= $p->judul_post ?>">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="<?= base_url('post/detail/' . $p->permalink) ?>" class="text-decoration-none fw-bold card-judul">
                                            <?= $p->judul_post ?>
                                        </a>
                                    </h5>
                                    <p class="fs-6"><?= word_limiter(strip_tags(htmlspecialchars_decode($p->konten_post)), 15) ?></p>
                                </div>
                                <div class="card-footer">
                                    <small class="card-text text-muted float-start"><a class="badge bg-success lh-1 mb-2 text-decoration-none" href="<?= base_url('kategori/' . strtolower($p->permalink_kt)) ?>">
                                            <?= $p->nama_kategori ?>
                                        </a></small>
                                    <small class="card-text text-muted float-end"><?= mediumdate_indo($p->tanggal_post) ?></small>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?= $halaman; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>