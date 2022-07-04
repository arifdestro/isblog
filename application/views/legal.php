<!-- Page Content -->
<div class="mb-2 mt-5 ms-3 me-3 rounded">
    <div class="card border-0 justify-content-center">
        <div class="content shadow pt-5 ps-3 pe-3">
            <div class="row">
                <div class="float-start">
                    <button class="bg-info border-0 text-underline-none" onclick="window.location.href='<?= base_url('beranda') ?>'">
                        Beranda </button> | <button class="bg-secondary border-0" onclick="window.location.href='<?= base_url('legal/' . $terms->permalink_kb) ?>'"><?= $terms->nama_kb ?></button>
                </div>
                <div class="col-md-12 mb-5">
                    <div class="text-center p-3">
                        <img class="card-img" id="img_l" src="<?= base_url('assets/dist/img/kebijakan/') . $terms->gambar_kb; ?>" style="width: 400px;" alt="gambar-kebijakan">
                    </div>
                    <div class="card-header text-center" id="side-post">
                        <h4 class="card-title"><?= $terms->nama_kb ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="deskripsi">
                            <p><?= htmlspecialchars_decode($terms->isi_kb) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#2937f0" fill-opacity="1" d="M0,128L480,128L960,128L1440,128L1440,0L960,0L480,0L0,0Z"></path>
    </svg>
</div>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="#2937f0" fill-opacity="1" d="M0,256L48,229.3C96,203,192,149,288,154.7C384,160,480,224,576,218.7C672,213,768,139,864,128C960,117,1056,171,1152,197.3C1248,224,1344,224,1392,224L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
    </path>
</svg>