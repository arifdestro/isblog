  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1>Kebijakan</h1>
                  </div>
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="#">Home</a></li>
                          <li class="breadcrumb-item active">Kebijakan></li>
                      </ol>
                  </div>
              </div>
          </div><!-- /.container-fluid -->
          <div>
              <?= $this->session->flashdata('pesan'); ?>
          </div>
      </section>

      <!-- Main content -->
      <section class="content">
          <div class="card-header">
              <div class="text-center">
                  <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAdd">
                      <i class="fas fa-plus-circle"></i> Kebijakan</button>
              </div>
          </div>
          <div class="row">
              <div class="col-12">
                  <div class="card">
                      <!-- /.card-header -->
                      <div class="card-body">
                          <table id="policy" class="table table-bordered table-striped">
                              <thead>
                                  <tr class="text-center">
                                      <th>No</th>
                                      <th>Nama</th>
                                      <th>Gambar</th>
                                      <th>Link</th>
                                      <th>Aksi</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php $no = 1; ?>
                                  <?php foreach ($data as $p) :
                                        $id = $p['id_kb'];
                                        $nama = $p['nama_kb'];
                                        $img = $p['gambar_kb'];
                                        $link = $p['permalink_kb'];
                                        $isi = $p['isi_kb'];
                                    ?>
                                      <tr>
                                          <td class="text-center" width="100px"><?= $no; ?></td>
                                          <td><?= $nama; ?></td>
                                          <td class="text-center"><img src="<?= base_url(); ?>assets/dist/img/kebijakan/<?= $img; ?>" width="100"></td>
                                          <td><?= $link; ?></td>
                                          <td class="text-center" width="270px">
                                              <a class="btn btn-sm btn-info" target="_blank" href="<?= base_url('legal/' . $link); ?>"><i class="fas fa-external-link-alt"></i>
                                                  Pratinjau</a>
                                              <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEdit<?= $id; ?>"><i class="fas fa-edit"></i>
                                                  <b>Edit</b></button>
                                              <a class="btn btn-sm btn-danger del" href="<?= base_url('admin/policy/delete/' . $id) ?>"><i class="fas fa-trash-alt"></i>
                                                  <b>Hapus</b></a>
                                          </td>
                                      </tr>
                                      <?php $no++; ?>
                                  <?php endforeach; ?>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </section>
  </div>

  <!-- Modal Tambah -->
  <div class="modal fade" id="modalAdd" tabindex="-1">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Tambah Kebijakan</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form action="<?php echo base_url() . 'admin/policy/insert' ?>" method="post" enctype="multipart/form-data">
                  <div class="modal-body">
                      <div class="form-group">
                          <label for="nama">Judul</label>
                          <input type="text" id="nama_kb" name="nama_kb" class="form-control" placeholder="Nama Menu">
                          <small class="form-text text-muted">Contoh: Kebijakan Pribadi(Privacy Policy)</small>
                          <?= form_error('nama', '<small class="text-danger col-md">', '</small>'); ?>
                      </div>
                      <div class="form-group">
                          <label for="icon">Gambar</label>
                          <div class="container">
                              <div class="row">
                                  <div class="col-md-12">
                                      <div class="form-group">
                                          <label class="control-label">Unggah Gambar</label>
                                          <div class="preview-zone hidden">
                                              <div class="box box-solid">
                                                  <div class="box-header with-border">
                                                      <div><b>Pratinjau</b></div>
                                                      <div class="box-tools pull-right">
                                                          <button type="button" class="btn btn-danger btn-xs remove-preview">
                                                              <i class="fa fa-times"></i> Ulang
                                                          </button>
                                                      </div>
                                                  </div>
                                                  <div class="box-body"></div>
                                              </div>
                                          </div>
                                          <div class="dropzone-wrapper">
                                              <div class="dropzone-desc">
                                                  <i class="glyphicon glyphicon-download-alt"></i>
                                                  <div>Pilih file gambar atau seret gambar kesini .</div>
                                              </div>
                                              <input type="file" name="image" class="dropzone" />
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <?= form_error('image', '<small class="text-danger col-md">', '</small>'); ?>
                      </div>
                      <div class="form-group">
                          <label for="link">Link</label>
                          <input type="text" id="link" name="link" class="form-control" placeholder="Link Pintasan" style="background-color: #F8F8F8;outline-color: none;border:0;color:blue;">
                          <small class="form-text text-muted">Contoh: <?= base_url('legal'); ?><b class="text-success">/terms-and-conditions</b></small>
                          <?= form_error('link', '<small class="text-danger col-md">', '</small>'); ?>
                      </div>
                      <div class="form-group">
                          <label for="isi">Isi Konten</label>
                          <textarea class="textarea" id="isi" name="isi" placeholder="Isi Konten" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                          <small class="form-text text-muted">Berisi keterangan kebijakan</small>
                          <?= form_error('isi', '<small class="text-danger col-md">', '</small>'); ?>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> Simpan</button>
                  </div>
              </form>
          </div>
      </div>
  </div>


  <?php foreach ($data as $p) :
        $id = $p['id_kb'];
        $nama = $p['nama_kb'];
        $img = $p['gambar_kb'];
        $link = $p['permalink_kb'];
        $isi = $p['isi_kb'];
    ?>

      <div class="modal fade" id="modalEdit<?= $id; ?>" tabindex="-1">
          <div class="modal-dialog modal-xl">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title">Ubah Kebijakan</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <form action="<?php echo base_url() . 'admin/policy/update' ?>" method="post" enctype="multipart/form-data">
                      <div class="modal-body">
                          <div class="form-group">
                              <label for="nama">Judul</label>
                              <input type="text" id="edit_kb<?= $id ?>" name="nama_kb" value="<?= $nama; ?>" class="form-control" placeholder="Nama Menu">
                              <small class="form-text text-muted">Contoh: Kebijakan Pribadi(Privacy Policy)</small>
                              <?= form_error('nama', '<small class="text-danger col-md">', '</small>'); ?>
                          </div>
                          <div class="form-group">
                              <label for="icon">Gambar</label>
                              <div class="container">
                                  <div class="row">
                                      <div class="col-md-5">
                                          <div class="card">
                                              <img src="<?= base_url(); ?>assets/dist/img/kebijakan/<?= $img; ?>" class="card-img-top" alt="gambar-foto">
                                              <div class="card-body">
                                                  <h6 class="card-title"><?= $img; ?></h6>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-md-7">
                                          <div class="form-group">
                                              <label class="control-label">Unggah Gambar</label>
                                              <div class="preview-zone hidden">
                                                  <div class="box box-solid">
                                                      <div class="box-header with-border">
                                                          <div><b>Pratinjau</b></div>
                                                          <div class="box-tools pull-right">
                                                              <button type="button" class="btn btn-danger btn-xs remove-preview">
                                                                  <i class="fa fa-times"></i> Ulang
                                                              </button>
                                                          </div>
                                                      </div>
                                                      <div class="box-body"></div>
                                                  </div>
                                              </div>
                                              <div class="dropzone-wrapper">
                                                  <div class="dropzone-desc">
                                                      <i class="glyphicon glyphicon-download-alt"></i>
                                                      <div>Pilih file gambar atau seret gambar kesini .</div>
                                                  </div>
                                                  <input type="file" name="image" value="<?= $img; ?>" class="dropzone" />
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <?= form_error('image', '<small class="text-danger col-md">', '</small>'); ?>
                          </div>
                          <div class="form-group">
                              <label for="link">Link</label>
                              <input type="text" id="edit_link<?= $id; ?>" name="link" value="<?= $link; ?>" class="form-control" placeholder="Link Pintasan" style="background-color: #F8F8F8;outline-color: none;border:0;color:blue;">
                              <small class="form-text text-muted">Contoh:
                                  <?= base_url('legal'); ?><b class="text-success">/terms-and-conditions</b></small>
                              <?= form_error('link', '<small class="text-danger col-md">', '</small>'); ?>

                              <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
                              <script type="text/javascript">
                                  $(document).ready(function() {
                                      $('#edit_kb<?= $id ?>').keyup(function() {
                                          var title = $(this).val().toLowerCase().replace(/[\/\\#^, +()$~%.'":*?<>{}]/g, '-');
                                          $('#edit_link<?= $id ?>').val(title);
                                      });
                                  })
                              </script>
                          </div>
                          <div class="form-group">
                              <label for="isi">Isi Konten</label>
                              <textarea class="textarea" name="isi" id="isi_edit<?= $id ?>" placeholder="Isi Konten" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?= $isi; ?></textarea>
                              <small class="form-text text-muted">Berisi keterangan kebijakan</small>
                              <?= form_error('isi', '<small class="text-danger col-md">', '</small>'); ?>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <input type="hidden" name="id_edit" value="<?= $id; ?>" required>
                          <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> Simpan</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>

      <script type="text/javascript">
          $(document).ready(function() {
              $('#isi_edit<?= $id ?>').summernote({
                  height: "300px",
                  callbacks: {
                      onImageUpload4: function(image) {
                          uploadImage(image[0]);
                      },
                      onMediaDelete4: function(target) {
                          deleteImage(target[0].src);
                      }
                  }
              });

              function uploadImage4(image) {
                  var data = new FormData();
                  data.append("image", image);
                  $.ajax({
                      url: "<?php echo site_url('admin/policy/upload_image') ?>",
                      cache: false,
                      contentType: false,
                      processData: false,
                      data: data,
                      type: "POST",
                      success: function(url) {
                          $('#isi_edit<?= $id ?>').summernote("insertImage", url);
                      },
                      error: function(data) {
                          console.log(data);
                      }
                  });
              }

              function deleteImage4(src) {
                  $.ajax({
                      data: {
                          src: src
                      },
                      type: "POST",
                      url: "<?php echo site_url('admin/policy/delete_image') ?>",
                      cache: false,
                      success: function(response) {
                          console.log(response);
                      }
                  });
              }

          });
      </script>

      <!-- Modal Hapus Data -->
      <div class="modal fade" id="modalDelete<?= $id; ?>">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header bg-primary">
                      <h4 class="modal-title">Hapus Data</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <form action="<?= base_url('admin/kebijakan/delete'); ?>" method="POST">
                      <div class="modal-body">
                          <div class="text-center">
                              <img class="mt-2 mb-2" src="<?= base_url(); ?>assets/dist/img/hapus.svg" width=80% alt="delete-img">
                              <h4 class="mb-4">Apakah anda yakin untuk menghapus data <b><?= $nama; ?></b> ini?</h4>
                          </div>
                          <input type="hidden" name="id_delete" value="<?= $id; ?>">
                      </div>
                      <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                          <button type="submit" class="btn btn-danger">Ya</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  <?php endforeach; ?>