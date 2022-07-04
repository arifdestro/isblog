<?= $this->session->flashdata('message') ?>
<!--  ======================= Start Main Area ================================ -->
<main class="site-main mt-5 mb-5">

    <!--  ======================= Start Main Content ================================ -->
    <section class="site-banner mt-8">
        <!-- <div class="container shadow"> -->
        <div class="card border-0 px-4 py-lg-5">
            <div class="row pt-3">
                <div class="col-md-8 col-sm-12 mb-5">
                    <div class="col-md-12 mb-5">
                        <div class="card border-0 justify-content-center">
                            <div class="card-header bg-transparent border-0">
                                <p class="mb-2"><?= $post->nama_kategori ?> / <?= $post->judul_post ?></p>
                                <h3 class="card-title fw-bold"><?= $post->judul_post ?></h3>
                                <ul id="ket" class="nav float-start">
                                    <li class="nav-item">
                                        <i class="text-secondary fas fa-stopwatch"></i> <?= longdate_indo($post->tanggal_post) ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="text-center mt-2 mb-2">
                                <?php
                                $imgPost = base_url('assets/dist/img/no-image.png');
                                if ($post->gambar_post !== '') {
                                    $imgPost = base_url('assets/img/post/' . $post->gambar_post);
                                }
                                ?>
                                <img class="img-fluid w-100 rounded shadow-sm" src="<?= $imgPost ?>" alt="gambar-post <?= $post->judul_post ?>" />
                                <br />
                                <small class="text-dark-50"><?= $post->deskripsi_post ?></small>
                            </div>
                            <div class="card-body">
                                <div id="deskripsi">
                                    <div><?= htmlspecialchars_decode($post->konten_post) ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 mt-2 mb-2 text-center">
                                        <?php if ($post->tags == null) : ?>
                                        <?php else : ?>
                                            <?php
                                            $id_post = $post->id_post;
                                            if ($post->tags !== null) {
                                                $tag = explode(',', $post->tags);
                                                foreach ($tag as $t) { ?>
                                                    <?php $tg = $this->db->get_where('tag', ['id_tag' => $t])->row() ?>
                                                    <a class="card-judul" style="text-decoration: none;" href="<?= base_url('tag/' . strtolower($tg->permalink_tg)) ?>">
                                                        <span class="badge bg-secondary">#<?= $tg->nama_tag ?></span>
                                                    </a>
                                            <?php }
                                            } ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-sm-6 mt-2 mb-2 text-center">
                                        <a class="card-judul" style="text-decoration: none;" href="<?= base_url('kategori/' . strtolower($post->permalink_kt)) ?>">
                                            <span class="badge bg-success"> <?= $post->nama_kategori; ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr />
                    <div class="bagikan mb-4">
                        <p class="font-weight-bold"><i class="text-primary fas fa-share-alt-square"></i> Bagikan postingan</p>
                        <!-- ShareThis BEGIN -->
                        <div class="sharethis-inline-share-buttons"></div>
                        <!-- ShareThis END -->
                    </div>

                    <div class="komentar" id="komen">
                        <h4 class="h6 font-weight-bold mb-4"><i class="text-primary fas fa-comments"></i> Komentar (<?= $komen ?>)</h4>

                        <?= $komentar ?>

                        <p class="notice error text-center">
                            <?= $this->session->has_userdata('loggedIn') == true ? '' : $this->session->flashdata('error_msg');
                            ?></p><br />
                        <div id="info_balas"></div>

                        <?= form_open('beranda/add_comment', ['id' => 'form_komentar', 'name' => 'Komentar', 'class' => 'row g-3 butuh-validasi', 'novalidate' => ''], ['parent_id' => '', 'id_post' => $post->id_post, 'url' => current_url()])
                        ?>
                        <!-- <form action="<?= base_url('kirim_komentar') ?>" id="form_komentar" name="Komentar" class="row g-3 needs-validation" method="post" novalidate> -->
                        <div class="mb-3">
                            <label for="comment_body" class="form-label">Komentar</label>
                            <textarea placeholder="isi komentar Anda" rows="5" type="text" class="form-control" name="comment_body" id="comment_body" required></textarea>
                            <div id="errorisi" class="invalid-feedback"></div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-sm-6">
                                <label class="form-label" for="name">Nama</label>
                                <input class="form-control" placeholder="nama Anda" type="text" name="comment_name" id="name" value="<?= set_value('comment_name', ($this->session->has_userdata('name') == true ? $this->session->userdata('name') : $this->session->userdata('cnama'))) ?>" <?= $this->session->has_userdata('name') == true ? 'readonly' : '' ?> required />
                                <div id="errornama" class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3 col-sm-6">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control" type="email" placeholder="email Anda" name="comment_email" id="email" value="<?= set_value('comment_email', ($this->session->has_userdata('email') == true ? $this->session->userdata('email') : $this->session->userdata('cemail'))) ?>" <?= $this->session->has_userdata('email') == true ? 'readonly' : '' ?> required />
                                <div id="erroremail" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="form-group col-sm-12">
                                <div class="g-recaptcha" name="g-recaptcha-response" data-sitekey="<?= $get['recaptcha_site'] ?>"></div>
                                <?= form_error('g-recaptcha-response'); ?>

                                <div id="captc" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div id="submit_button" class="mt-3">
                            <button class="btn btn-info rounded" type="submit"> <i class="fas fa-paper-plane"></i> Tambah Komentar</button>
                        </div>
                        <?= form_close()
                        ?>
                        <!-- </form> -->
                    </div>

                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="sticky-top Sidebar">
                        <div class="card mb-4 shadow-sm" id="side-post">
                            <div class="card-header border-0 fs-5 fw-bold"><i class="fas fa-fire-alt text-danger"></i> Artikel Terbaru</div>
                            <div class="card-body">
                                <?php foreach ($list as $ls) { ?>
                                    <div class="border-bottom mb-3 pb-2">
                                        <span class="badge bg-success"><?= $ls->nama_kategori ?></span>
                                        <div class="tp d-flex">
                                            <h6>
                                                <?= anchor('post/detail/' . $ls->permalink, word_limiter($ls->judul_post, 15), ['class' => 'text-decoration-none fw-bold card-judul'], ['title' => $ls->judul_post]) ?>
                                            </h6>
                                        </div>
                                        <div class="text-start">
                                            <?= word_limiter(strip_tags(htmlspecialchars_decode($ls->konten_post)), 15) ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- </div> -->
    </section>
    <!--  ======================== End Main Content ==============================  -->
</main>

<script>
    (function() {
        'use strict'

        var forms = document.querySelectorAll('.butuh-validasi')
        var errCaptcha = document.getElementById('captc')
        var errEmail = document.getElementById('erroremail')
        var errIsi = document.getElementById('errorisi')
        var errNama = document.getElementById('errornama')
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    var response = grecaptcha.getResponse()
                    var l = response.length
                    var mail_format = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                    var nama = document.Komentar.comment_name.value;
                    var email = document.Komentar.comment_email.value;
                    var isi = document.Komentar.comment_body.value;

                    if (!form.checkValidity() || l == 0 || nama == "" || email == "" || isi == "") {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    if (l == 0) {
                        errCaptcha.innerHTML =
                            "Klik reCaptcha diperlukan";
                        errCaptcha.classList.add('d-block')
                    } else {
                        errCaptcha.classList.remove('d-block')
                        errCaptcha.innerHTML = " ";
                    }

                    if (nama == "") {
                        errNama.innerHTML =
                            "Silahkan isi nama anda";
                        errNama.classList.add('d-block')
                    } else {
                        errNama.classList.remove('d-block')
                        errNama.innerHTML = " ";
                    }

                    if (email == "") {
                        errEmail.innerHTML =
                            "Silahkan isi email anda";
                        errEmail.classList.add('d-block')
                    } else if (email.match(mail_format)) {
                        errEmail.innerHTML = " ";
                        errEmail.classList.remove('d-block')
                    } else {
                        event.preventDefault()
                        event.stopPropagation()
                        // email.classList.add('mail')
                        errEmail.innerHTML =
                            "Mohon untuk memasukkan Format Email yang benar";
                        errEmail.classList.add('d-block')
                    }

                    if (isi == "") {
                        errIsi.innerHTML =
                            "Silahkan isi komentar";
                        errIsi.classList.add('d-block')
                    } else {
                        errIsi.classList.remove('d-block')
                        errIsi.innerHTML = " ";
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>