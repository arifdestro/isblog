<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Post</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/beranda') ?>">Beranda</a></li>
                        <li class="breadcrumb-item active">Edit Post</li>
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
            <?= form_open_multipart('admin/post/edit'); ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="judul"><i class="fas fa-pencil-alt"></i> Judul</label>
                                <input value="<?= $data['judul_post'] ?>" type="text" class="form-control" id="judul2" name="judul2" placeholder="Masukkan Judul Konten">
                                <small class="form-text text-muted">Berisi keterangan berupa judul konten, contoh: " Workshop pada masa pandemi covid-19 "</small>
                                <?= form_error('judul2'); ?>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi"><i class="fas fa-list"></i> Deskripsi</label>
                                <textarea class="form-control" rows="4" id="deskripsi2" name="deskripsi2" placeholder="Masukkan Deskripsi Post"><?= $data['deskripsi_post'] ?></textarea>
                                <small class="form-text text-muted">Bisa di isi deskripsi singkat postingan, boleh juga untuk dikosongi</small>
                                <?= form_error('deskripsi2'); ?>
                            </div>
                            <div class="form-group">
                                <label for="isi"><i class="fas fa-paragraph"></i> Isi Konten</label>
                                <textarea class="textarea" name="konten2" id="konten2" placeholder="Isi Konten"><?= $data['konten_post'] ?></textarea>
                                <small class="form-text text-muted">Bisa di isi konten postingan</small>
                                <?= form_error('konten2'); ?>
                            </div>
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
                                <?php
                                if ($data['gambar_post'] !== '') {
                                    $img = base_url('assets/img/thumb/' . $data['gambar_post']);
                                } else {
                                    $img = base_url('assets/dist/icon/image.svg');
                                }
                                ?>
                                <img src="<?= $img ?>" onClick="triggerClick2()" id="imageDisplay2" width="200px">
                                <?php if (!empty($data['gambar_post'])) : ?>
                                    <a href="<?= site_url('admin/post/delete_foto/' . $data['id_post']) ?>" class="my-2 btn btn-danger btn-sm del">Hapus Foto</a>
                                <?php endif; ?>
                                <h3 class="profile-username text-center text-bold">
                                    </span>
                                    <div class="form-group">
                                        <label for="image">Unggah Thumbnail</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="custom-file">
                                                <input type="file" name="foto2" class="form-control" onChange="displayImage2(this)" id="profileImage2" accept=".png, .jpg, .jpeg" aria-describedby="inputGroupFileAddon01">
                                            </div>
                                        </div>
                                    </div>
                                </h3>
                            </div>
                            <div class="text text-center">
                                <small class="text-danger text-center text-bold">(Ukuran file gambar max 2 mb.)</small>
                            </div>
                            <label for="kategori"><i class="fas fa-list"></i> Kategori</label>
                            <select class="form-control" name="kategori2" id="kategori2">
                                <option selected disable value="">-- Pilih Kategori --</option>
                                <?php $tes = $this->db->get('kategori')->result_array();

                                foreach ($tes as $t) {
                                    $nama = $t['nama_kategori']; ?>
                                    <option value="<?= $t['id_kategori']; ?>" <?= $t['id_kategori'] == $data['id_kategori'] ? 'selected' : '' ?>><?= $t['nama_kategori']; ?></option>
                                <?php
                                } ?>
                            </select>
                            <small class="form-text text-muted mb-2">Pilih Kategori</small>
                            <?= form_error('kategori2'); ?>
                            <?php
                            $tg = $this->db->get('tag')->result_array();
                            // $post_id = $data['id_post'];
                            $post_tag = $data['tags'];
                            $strtag = explode(",", $post_tag);
                            $selisih = count($tg) - count($strtag);
                            for ($j = 0; $j < $selisih; $j++) {
                                $ta[] = '';
                            }

                            $array = array_merge($strtag, $ta);
                            ?>
                            <label for="tag"><i class="fas fa-check-square"></i> Tag</label>
                            <select name="tag_id_edit[]" class="select_tag" multiple="multiple" data-placeholder="Pilih tag" style="width: 100%;">
                                <?php
                                for ($i = 0; $i < count($tg); $i++) { ?>
                                    <option value="<?= $tg[$i]['id_tag'] ?>" <?php if (in_array($tg[$i]['id_tag'], $array)) {
                                                                                    echo 'selected';
                                                                                } ?>><?= $tg[$i]['nama_tag']; ?></option>
                                <?php } ?>
                            </select>
                            <small class="form-text text-muted mb-2">Pilih Tag (Tidak Wajib)</small>
                            <label for="kategori"><i class="fas fa-list"></i> Status</label>
                            <select class="form-control" id="status2" name="status2">
                                <option selected value="" disable>-- Pilih Status --<i class="bi bi-eye"></i></option>
                                <option value="1" <?= $data['status_post'] === '1' ? 'selected' : '' ?>>Publish</option>
                                <option value="0" <?= $data['status_post'] === '0' ? 'selected' : '' ?>>Draft</option>
                            </select>
                            <small class="form-text text-muted">Pilih Status</small>
                            <?= form_error('status2'); ?>
                            <input type="hidden" name="id_edit" value="<?= $data['id_post'] ?>">
                            <button type="submit" class="btn btn-primary btn-block mt-3"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <?= form_close() ?>
        </div>
        <!-- /.col -->
    </section>
</div>