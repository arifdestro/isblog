<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>API dan SMTP</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/beranda') ?>">Beranda</a></li>
                        <li class="breadcrumb-item active">API dan SMTP</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
        <div class="px-2">
            <?= $this->session->flashdata('pesan') ?>
        </div>
    </div>
    <?= form_open('admin/setting/update', 'autocomplete="off"') ?>
    <section class="content">
        <div class="card">
            <div class="card-header text-right">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-5 m-2">
                                <div class="card">
                                    <div class="card-header"><i class="fas fa-info-circle text-primary"></i> Recaptcha Key Setting</div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="site"><i class="fas fa-key"></i> Kode Recaptcha Site</label>
                                            <input class="form-control" type="text" name="site" id="site" value="<?= $data['recaptcha_site'] ?>">
                                            <small class="form-text text-muted">Recaptcha Site Key</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="secret"><i class="fas fa-key"></i> Kode Recaptcha Secret</label>
                                            <input class="form-control" type="text" name="secret" id="secret" value="<?= $data['recaptcha_secret'] ?>">
                                            <small class="form-text text-muted">Recaptcha Secret Key</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5 m-2">
                                <div class="card">
                                    <div class="card-header"><i class="fas fa-info-circle text-primary"></i> SMTP Mail Setting</div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="mail"><i class="fas fa-envelope"></i> SMTP Mail Server</label>
                                            <input class="form-control" type="text" name="mail" id="mail" value="<?= $data['smtp_mail'] ?>">
                                            <small class="form-text text-muted">Mail untuk SMTP</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="password"><i class="fas fa-lock"></i> SMTP Sandi</label>
                                            <input class="form-control" type="text" name="password" id="password" value="<?= $data['smtp_password'] ?>">
                                            <small class="form-text text-muted">Sandi SMTP Mail</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="id_edit" value="<?= $data['id_pengaturan'] ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?= form_close() ?>
</div>