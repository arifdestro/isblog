<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Komentar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                        <li class="breadcrumb-item active">Komentar</li>
                    </ol>
                </div>
            </div>
            <?= $this->session->flashdata('pesan') ?>
        </div>
    </section>

    <section class="content">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <?= anchor('admin/comment', 'Publik', ['class' => 'nav-link ' . ($current === 'publik' ? 'active' : '')]) ?>
                    </li>
                    <li class="nav-item" role="presentation">
                        <?= anchor('admin/comment/pending', 'Pending', ['class' => 'nav-link ' . ($current === 'pending' ? 'active' : '')]) ?>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="myTabContent">
                    <?php if ($komentar->num_rows() > 0) { ?>
                        <div class="list-group">
                            <?php foreach ($komentar->result() as $komen) { ?>
                                <div class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100">
                                        <?php
                                        $grav_url = 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($komen->email))) . '?d=mp&s=50';
                                        $pClass   = 'warning';
                                        $pText    = 'Terbitkan';
                                        if ($komen->status == '1') {
                                            $pClass = 'success';
                                            $pText  = 'Batal Terbit';
                                        }
                                        ?>
                                        <img style="width: 50px; height: 50px;" src="<?= $grav_url ?>" alt="" class="rounded-circle img-fluid mr-3 border" />
                                        <div class="w-100">
                                            <h5 class="mb-1"><?= $komen->nama ?> ( <?= $komen->email ?> )</h5>
                                            <small class="d-block border-bottom mb-2 pb-2"><?= $komen->tanggal_komentar ?></small>
                                            <div class="mb-3"><?= $komen->pesan ?></div>
                                            <div class="btn-toolbar" role="group">
                                                <?php if ($komen->status === '1') { ?>
                                                    <div class="btn-group mr-2" role="group">
                                                        <?= anchor('showpost?id=' . $komen->id_post, '<i class="fas fa-eye"></i> Lihat', ['class' => 'btn btn-outline-success', 'target' => '_blank']) ?>
                                                    </div>
                                                <?php } ?>
                                                <div class="btn-group mr-2" role="group">
                                                    <!-- <? //= form_button([
                                                            //'data-toggle'  => 'modal',
                                                            //'content'      => '<i class="fas fa-edit"></i> Ubah',
                                                            //'data-target'  => '#ubahKomen',
                                                            //'class'        => 'btn btn-outline-dark',
                                                            //'data-content' => htmlspecialchars(json_encode(['id' => $komen->id_komentar, 'nama' => $komen->nama, 'email' => $komen->email, 'isi' => strip_tags($komen->pesan)])),
                                                            //'onclick'      => 'ubahKomentar(this);',
                                                            //]) 
                                                            ?> -->
                                                    <?= anchor('admin/comment/terbit/' . $komen->id_komentar . '/' . ($komen->status == '1' ? '0' : '1'), '<i class="fas fa-check-circle"></i> ' . $pText, ['class' => 'btn btn-outline-' . $pClass . ' publikasiKomen']) ?>

                                                    <?php if ($komen->status === '1') { ?>
                                                    <?php } ?>
                                                    <?= anchor('admin/comment/delete/' . $komen->id_komentar, '<i class="fas fa-trash"></i> Hapus', ['class' => 'btn btn-outline-danger del']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-warning">Belum ada data.</div>
                    <?php } ?>

                    <div class="my-3">
                        <?= $paginasi ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal edit -->
<div class="modal fade" id="ubahKomen" tabindex="-1" aria-labelledby="ubahKomenLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahKomenLabel">Ubah Komentar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('comment/update', [], ['id' => '', 'redirect' => uri_string() . '?' . $_SERVER['QUERY_STRING']]) ?>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <?= form_label('Nama', 'nama') ?>
                    <?= form_input([
                        'name'        => 'nama',
                        'class'       => 'form-control',
                        'id'          => 'nama',
                        'placeholder' => 'nama komentator',
                        'required'    => '',
                    ]) ?>
                </div>

                <div class="form-group mb-3">
                    <?= form_label('Email', 'email') ?>
                    <?= form_input([
                        'name'        => 'email',
                        'class'       => 'form-control',
                        'id'          => 'email',
                        'placeholder' => 'email komentator',
                        'type'        => 'email',
                        'required'    => '',
                    ]) ?>
                </div>
                <div class="form-group mb-3">
                    <?= form_label('Komentar', 'isi') ?>
                    <?= form_textarea([
                        'name'        => 'isi',
                        'class'       => 'form-control',
                        'id'          => 'isi',
                        'placeholder' => 'isi komentator',
                        'rows'        => '4',
                        'required'    => '',
                    ]) ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>