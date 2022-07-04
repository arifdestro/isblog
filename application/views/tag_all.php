<?= $this->session->flashdata('message') ?>
<section class="mt-3" id="category">
    <div class="container px-5">
        <div class="row gx-5 align-items-center justify-content-center justify-content-lg-between">
            <div class="col-sm-12">
                <span class="badge bg-dark lh-1 mb-2">Semua Tag</span>
                <p class="lead fw-normal">Pilihan tag yang tersedia.</p>
                <ul class="nav mb-4">
                    <?php $all = $this->db->get_where('post', ['status_post' => 1])->num_rows(); ?>
                    <li class="nav-item me-1 ms-0">
                        <a class="me-lg-3 mb-4 mb-lg-0 btn btn-sm btn-secondary" href="<?= base_url() ?>">Semua (<?= $all ?>) <i class="fas fa-chevron-right"></i></a>
                    </li>
                    <?php
                    $tag = $this->db->query('SELECT * FROM `tag` ORDER BY nama_tag ASC')->result();
                    foreach ($tag as $t) {
                    ?>
                        <?php $tg = $this->db->query("SELECT * FROM post WHERE post.status_post = 1 AND tags LIKE '%$t->id_tag%'")->num_rows() ?>
                        <li class="nav-item me-1 ms-0">
                            <a class="me-lg-3 mb-4 mb-lg-0 btn btn-sm btn-danger" href="<?= base_url('tag/' . strtolower($t->permalink_tg)) ?>">#<?= $t->nama_tag ?> (<?= $tg ?>)</a>
                        </li>
                    <?php } ?>
                </ul>
                <p>Jika kamu tidak menemukan topik yang dicari, kamu bisa minta kami untuk menambahkannya.</p>
            </div>
            <div class="col-sm-12 mt-5">
                <div class="row align-items-center justify-content-center">
                    <div class="col-sm-12 col-md-8 shadow p-5" id="side-post">
                        <h2 class="display-7 lh-1 mb-4 font-alt">
                            <img src="<?= base_url() ?>assets/img/logo_1.svg" alt="logo" width="50" height="44" class="mb-2 v1">
                            <img src="<?= base_url() ?>assets/img/logo_2.svg" alt="logo" width="50" height="44" class="mb-2 v2">
                            Kang Dongeng
                        </h2>
                        <p class="lead fw-normal text-muted mb-4">Silahkan buat request agar kami bisa menambahkan. </p>
                        <div class="d-grid gap-2">
                            <button class="mb-4 btn btn-primary p-2" data-bs-toggle="modal" data-bs-target="#feedbackModal"><i class="bi-chat-text-fill"></i> Kirim Pesan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>