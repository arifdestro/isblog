<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tambah Post</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/beranda') ?>">Beranda</a></li>
                        <li class="breadcrumb-item active">Tambah Post</li>
                    </ol>
                </div>
            </div>
            <div class="px-2">
                <?= $this->session->flashdata('pesan');
                ?>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card-header">
                <div class="text-center">
                    <a class="btn btn-secondary btn-sm" href="<?= base_url('admin/post') ?>">
                        <i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-primary card-outline">
                        <?= form_open_multipart('admin/post/create'); ?>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="judul"><i class="fas fa-pencil-alt"></i> Judul</label>
                                <input value="<?= set_value('judul', $this->session->userdata('form_title')) ?>" type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan Judul Konten">
                                <small class="form-text text-muted">Berisi keterangan berupa judul konten, contoh: " Workshop pada masa pandemi covid-19 "</small>
                                <?= form_error('judul'); ?>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi"><i class="fas fa-list"></i> Deskripsi</label>
                                <textarea class="form-control" rows="4" id="deskripsi" name="deskripsi" placeholder="Masukkan Deskripsi Post"><?= set_value('deskripsi', $this->session->userdata('form_description')) ?></textarea>
                                <small class="form-text text-muted">Bisa di isi deskripsi singkat postingan, boleh juga untuk dikosongi</small>
                                <?= form_error('deskripsi'); ?>
                            </div>
                            <div class="form-group">
                                <label for="isi"><i class="fas fa-paragraph"></i> Isi Konten</label>
                                <textarea class="textarea" name="konten" id="konten" placeholder="Isi Konten"><?= set_value('konten', $this->session->userdata('form_content')) ?></textarea>
                                <small class="form-text text-muted">Bisa di isi konten postingan</small>
                                <?= form_error('konten'); ?>
                            </div>
                            <button type="reset" class="btn btn-info" id="btn-reset" value="reset"><i class="fas fa-eraser"></i> Reset</button>
                        </div>
                    </div>
                    <div class="button p-3">
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img src="<?= base_url('assets/dist/icon/image.svg') ?>" onClick="triggerClick()" id="imageDisplay" width="200px">
                                <?= form_error('image', '<small class="text-danger pl-3">', '</small>'); ?>
                                <h3 class="profile-username text-center text-bold">
                                    </span>
                                    <div class="form-group">
                                        <label for="image">Unggah Thumbnail</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="custom-file">
                                                <input type="file" name="foto" class="form-control" value="<?= $user['foto_user']; ?>" onChange="displayImage(this)" id="profileImage" accept=".png, .jpg, .jpeg" aria-describedby="inputGroupFileAddon01">
                                            </div>
                                        </div>
                                    </div>
                                </h3>
                            </div>
                            <div class="text text-center">
                                <small class="text-danger text-center text-bold">(Ukuran file gambar max 2 mb.)</small>
                            </div>
                            <label for="kategori"><i class="fas fa-list"></i> Kategori</label>
                            <select class="form-control" name="kategori" id="kategori">
                                <option selected disable value="">-- Pilih Kategori --</option>
                                <?php $tes = $this->db->get('kategori')->result_array();

                                foreach ($tes as $t) {
                                    $nama = $t['nama_kategori']; ?>
                                    <option value="<?= $t['id_kategori']; ?>"><?= $t['nama_kategori']; ?></option>
                                <?php
                                } ?>
                            </select>
                            <small class="form-text text-muted mb-2">Pilih Kategori</small>
                            <?= form_error('kategori'); ?>
                            <label for="tag"><i class="fas fa-check-square"></i> Tag</label>
                            <select name="tag_id[]" class="select_tag" multiple="multiple" data-placeholder="Pilih tag" style="width: 100%;">
                                <?php $tag = $this->db->get('tag')->result();
                                foreach ($tag as $tg) { ?>
                                    <option value="<?= $tg->id_tag; ?>"><?= $tg->nama_tag; ?></option>
                                <?php } ?>
                            </select>
                            <small class="form-text text-muted mb-2">Pilih Tag (Tidak Wajib)</small>
                            <label for="kategori"><i class="fas fa-list"></i> Status</label>
                            <select class="form-control" id="status" name="status">
                                <option selected value="" disable>-- Pilih Status --<i class="bi bi-eye"></i></option>
                                <option value="1">Publish <i class="bi bi-eye"></i></option>
                                <option value="0">Draft <i class="bi bi-eye-slash"></i></option>
                            </select>
                            <small class="form-text text-muted">Pilih Status</small>
                            <?= form_error('status'); ?>
                            <button type="submit" class="btn btn-primary btn-block mt-3"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                        <?= form_close() ?>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        <!-- /.col -->
    </section>
</div>