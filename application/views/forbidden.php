<?= $this->session->flashdata('message') ?>
<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <img src="<?= base_url('assets/dist/img/blockv2.gif') ?>" alt="" class="img-rounded img-responsive img-fluid" width="400" />
                <div class="error-template">
                    <h1>403, Halaman yang anda tuju tidak dapat diakses!</h1>
                    <h2><i class="fas fa-info-circle text-primary"></i> Akses tidak diijinkan.</h2>
                    <div class="error-details">
                        Anda mungkin mengetahui beberapa url terkait akses halaman, tapi user akses anda tidak diperuntukkan untuk akses halaman tersebut.
                    </div>
                    <div class="error-actions mt-5">
                        <div class="row justify-content-center">
                            <div class="col-md-6 text-center">
                                <?php if ($this->session->userdata('loggedIn') != true) { ?>
                                    <a onclick="history.go(-1)" class="btn btn-outline-primary rounded-pill"><i class="fas fa-arrow-left"></i> kembali ke Sebelumnya</a>
                                    <a href="<?= site_url('beranda') ?>" class="btn btn-outline-primary rounded-pill"><i class="fas fa-sign-in-alt"></i> kembali ke Beranda</a>
                                <?php } else { ?>
                                    <a onclick="history.go(-1)" class="btn btn-outline-primary rounded-pill"><i class="fas fa-arrow-left"></i> kembali ke Sebelumnya</a>
                                    <a href="<?= site_url('admin/beranda') ?>" class="btn btn-outline-primary rounded-pill"><i class="fas fa-sign-in-alt"></i> kembali ke Dashboard</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>