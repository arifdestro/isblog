<?= $this->session->flashdata('message') ?>
<section class="mt-3" id="category">
    <div class="container px-5">
        <div class="row gx-5 align-items-center justify-content-center justify-content-lg-between">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <span class="badge bg-dark lh-1 mb-2">Kata Kunci : <?= $cari ?></span>
                <?php if ($hasil == 'Tidak ditemukan') : ?>
                    <p class="lead fw-normal mb-4">Tidak ditemukan data terkait hasil pencarian <b><?= $cari ?></b>.</p>
                <?php else : ?>
                    <p class="lead fw-normal mb-4">Beberapa postingan terkait hasil pencarian <b class="fw-bolder"><?= $cari ?></b>.</p>
                <?php endif ?>
            </div>
            <div class="col-sm-12 mt-5">
                <div class="row">
                    <?php if ($hasil == 'Tidak ditemukan') : ?>
                        <!-- Jika Belum Terdapat data -->
                        <div class="col-md justify-content-center">
                            <div class="card-body text-center mt-4">
                                <img src="<?= base_url('assets/dist/icon/noList.svg'); ?>" alt="noData" class="img-rounded img-responsive img-fluid" width="100">
                            </div>
                            <div class="card-body pt-0 mt-4 text-center">
                                <h4 class="text-center text-bold text-muted">Data Tidak Ditemukan</h4>
                                <a href="<?= base_url(); ?>" class="btn btn-primary text-center mt-3"><i class="fas fa-arrow-left"></i> Kembali</a>
                            </div>
                        </div>
                    <?php else : ?>
                        <?php foreach ($value as $p) { ?>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                <div class="card shadow">
                                    <div class="img-hover-zoom rounded">
                                        <a href="<?= base_url('post/detail/' . $p->permalink) ?>">
                                            <?php
                                            $imgPost = base_url('assets/dist/img/no-image.png');
                                            if ($p->gambar_post !== '') {
                                                $imgPost = base_url('assets/img/post/' . $p->gambar_post);
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
                                        <small class="card-text text-muted float-start">
                                            <a class="badge bg-success lh-1 mb-2 text-decoration-none" href="<?= base_url('kategori/' . strtolower($p->permalink_kt)) ?>">
                                                <?= $p->nama_kategori ?>
                                            </a></small>
                                        <small class="card-text text-muted float-end"><?= mediumdate_indo($p->tanggal_post) ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>