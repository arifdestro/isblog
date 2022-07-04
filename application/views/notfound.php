<?= $this->session->flashdata('message') ?>
<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <img src="<?= base_url('assets/img/404v2.gif') ?>" alt="" class="img-rounded img-responsive img-fluid" width="400" />
                <div class="error-template">
                    <h1 class="font-alt">404, Halaman yang anda tuju tidak ada!</h1>
                    <h2 class="font-alt"><i class="fas fa-info-circle text-primary"></i> Halaman tidak ditemukan.</h2>
                    <div class="error-details">
                        Anda mungkin memasukkan url atau alamat pada pencarian dengan nama yang kurang benar. Pastikan untuk memasukkan nama yang sesuai.
                    </div>
                    <div class="error-actions mt-5">
                        <div class="row justify-content-center">
                            <div class="col-md-6 text-center">
                                <?php if ($this->session->userdata('loggedIn') != true) { ?>
                                    <a onclick="history.go(-1)" class="btn btn-outline-primary rounded-pill"><i class="fas fa-arrow-left"></i> ke laman Sebelumnya</a>
                                <?php } else { ?>
                                    <a onclick="history.go(-1)" class="btn btn-outline-primary rounded-pill mt-2 mb-2"><i class="fas fa-arrow-left"></i> kembali ke Sebelumnya</a>
                                    <a href="<?= site_url('admin/home') ?>" class="btn btn-outline-primary rounded-pill mt-2 mb-2"><i class="fas fa-sign-in-alt"></i> kembali ke Dashboard</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>