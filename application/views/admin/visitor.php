<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Pengunjung</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="home">Beranda</a></li>
                        <li class="breadcrumb-item active">Pengunjung</li>
                    </ol>
                </div>
            </div><!-- /.row -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-sm-7 m-1 card">
                    <div class="card-header">
                        <h4 class="card-title">Pengunjung Bulan Ini</h4>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="chart_view" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 card m-1">
                    <div class="card-header">
                        <h4 class="card-title">Media Browser</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li>Google Chrome atau Microsoft Edge<div class="text-primary pull-right"><?= number_format($chrome_visitor, 2); ?>%</div>
                            </li>
                            <li>Firefox<div class="text-primary pull-right"><?= number_format($firefox_visitor, 2); ?>%</div>
                            </li>
                            <li>Internet Explorer<div class="text-primary pull-right"><?= number_format($explorer_visitor, 2); ?>%</div>
                            </li>
                            <li>Safari<div class="text-primary pull-right"><?= number_format($safari_visitor, 2); ?>%</div>
                            </li>
                            <li>Opera<div class="text-primary pull-right"><?= number_format($opera_visitor, 2); ?>%</div>
                            </li>
                            <li>Robots<div class="text-primary pull-right"><?= number_format($robot_visitor, 2); ?>%</div>
                            </li>
                            <li>Others<div class="text-primary pull-right"><?= number_format($other_visitor, 2); ?>%</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 mt-2">
                <div class="panel panel-white">
                    <div class="panel-heading">
                        <h4 class="panel-title">Top 5 Halaman Populer</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive project-stats">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Judul halaman</th>
                                        <th style="text-align: right;">Pengunjung</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;

                                    foreach ($top_five_articles->result() as $row) :
                                        $no++;
                                    ?>
                                        <tr>
                                            <th scope="row"><?= $no; ?></th>
                                            <td><?= $row->judul_post; ?></td>
                                            <td style="text-align: right;"><?= number_format($row->pengunjung_post); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>