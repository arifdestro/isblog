</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
    <strong>Copyright &copy; <?= date('Y'); ?> <a href="<?= base_url() ?>">KD-ADMIN</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> Test
    </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url() ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- SweetAlert2 -->
<script src="<?= base_url(); ?>assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?= base_url() ?>assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?= base_url() ?>assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?= base_url() ?>assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url() ?>assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?= base_url() ?>assets/plugins/moment/moment.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url() ?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?= base_url() ?>assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url() ?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>assets/dist/js/adminlte.js"></script>

<script src="<?= base_url(); ?>assets/plugins/select2/js/select2.full.min.js"></script>

<!-- DataTables  & Plugins -->
<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Drop Image -->
<script src="<?= base_url() ?>assets/dist/js/app.js"></script>

<script>
    $(function() {

        //-------------
        //- LINE CHART -
        //--------------
        var areaChartData = {
            labels: <?= $month; ?>,
            datasets: [{
                label: "Pengunjung",
                backgroundColor: 'rgba(60,141,188,0.4)',
                borderColor: 'rgba(60,141,188,1)',
                pointRadius: 5,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                tension: 0.1,
                data: <?= $value; ?>
            }]
        }

        var areaChartOptions = {
            //Boolean - If we should show the scale at all
            showScale: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: true,
            //String - Colour of the grid lines
            scaleGridLineColor: 'rgba(0,0,0,.05)',
            //Number - Width of the grid lines
            scaleGridLineWidth: 0,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - Whether the line is curved between points
            bezierCurve: true,
            //Number - Tension of the bezier curve between points
            bezierCurveTension: 0.3,
            //Boolean - Whether to show a dot for each point
            pointDot: true,
            //Number - Radius of each point dot in pixels
            pointDotRadius: 4,
            //Number - Pixel width of point dot stroke
            pointDotStrokeWidth: 1,
            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius: 2,
            //Boolean - Whether to show a stroke for datasets
            datasetStroke: true,
            //Number - Pixel width of dataset stroke
            tooltipCornerRadius: 2,
            //Tooltip - Pixel width of dataset stroke
            datasetStrokeWidth: 2,
            //Boolean - Whether to fill the dataset with a color
            datasetFill: true,
            //String - A legend template
            legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: false
        }

        var lineChartCanvas = $('#chart_view').get(0).getContext('2d')
        var lineChart = new Chart(lineChartCanvas, {
            type: 'line',
            data: areaChartData,
            options: lineChartOptions
        })
        var lineChartOptions = areaChartOptions
        lineChartOptions.datasetFill = false
        // lineChart.Line(areaChartData, lineChartOptions)
    })
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.select_tag').select2({
            theme: 'bootstrap4'
        });
    });
</script>

<script>
    function triggerClick(b) {
        document.querySelector('#profileImage').click();
    }

    function displayImage(b) {
        if (b.files[0]) {
            var reader = new FileReader();
            reader.onload = function(b) {
                document.querySelector('#imageDisplay').setAttribute('src', b.target.result);
            }
            reader.readAsDataURL(b.files[0]);
        }
    }

    function triggerClick2(b) {
        document.querySelector('#profileImage2').click();
    }

    function displayImage2(b) {
        if (b.files[0]) {
            var reader = new FileReader();
            reader.onload = function(b) {
                document.querySelector('#imageDisplay2').setAttribute('src', b.target.result);
            }
            reader.readAsDataURL(b.files[0]);
        }
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#konten').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']],
                ['misc', ['codeview']],
            ],
            height: "300px",
            callbacks: {
                onImageUpload: function(image) {
                    uploadImage(image[0]);
                },
                onMediaDelete: function(target) {
                    deleteImage(target[0].src);
                }
            }
        });

        $('#konten2').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']],
                ['misc', ['codeview']],
            ],
            height: "300px",
            callbacks: {
                onImageUpload: function(image) {
                    uploadImage2(image[0]);
                },
                onMediaDelete: function(target) {
                    deleteImage2(target[0].src);
                }
            }
        });

        $('#isi').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']],
                ['misc', ['codeview']],
            ],
            height: "300px",
            callbacks: {
                onImageUpload: function(image) {
                    uploadImage3(image[0]);
                },
                onMediaDelete: function(target) {
                    deleteImage3(target[0].src);
                }
            }
        });

        function uploadImage(image) {
            var data = new FormData();
            data.append("image", image);
            $.ajax({
                url: "<?php echo site_url('admin/post/upload_image') ?>",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "POST",
                success: function(url) {
                    $('#konten').summernote("insertImage", url);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function uploadImage2(image) {
            var data = new FormData();
            data.append("image", image);
            $.ajax({
                url: "<?php echo site_url('admin/post/upload_image') ?>",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "POST",
                success: function(url) {
                    $('#konten2').summernote("insertImage", url);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function uploadImage3(image) {
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
                    $('#isi').summernote("insertImage", url);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function deleteImage(src) {
            $.ajax({
                data: {
                    src: src
                },
                type: "POST",
                url: "<?php echo site_url('admin/post/delete_image') ?>",
                cache: false,
                success: function(response) {
                    console.log(response);
                }
            });
        }

        function deleteImage2(src) {
            $.ajax({
                data: {
                    src: src
                },
                type: "POST",
                url: "<?php echo site_url('admin/post/delete_image') ?>",
                cache: false,
                success: function(response) {
                    console.log(response);
                }
            });
        }

        function deleteImage3(src) {
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

<script>
    $(function() {
        $("#notif").DataTable({
            "responsive": true,
            "autoWidth": false
        }).buttons().container().appendTo('#notif_wrapper .col-md-6:eq(0)');
        $("#user").DataTable({
            "responsive": true,
            "autoWidth": false
        }).buttons().container().appendTo('#user_wrapper .col-md-6:eq(0)');
        $("#post").DataTable({
            "responsive": true,
            "autoWidth": false
        }).buttons().container().appendTo('#post_wrapper .col-md-6:eq(0)');
        $("#kat").DataTable({
            "responsive": true,
            "autoWidth": false
        }).buttons().container().appendTo('#kat_wrapper .col-md-6:eq(0)');
        $("#tag").DataTable({
            "responsive": true,
            "autoWidth": false
        }).buttons().container().appendTo('#tag_wrapper .col-md-6:eq(0)');
        $("#policy").DataTable({
            "responsive": true,
            "autoWidth": false
        }).buttons().container().appendTo('#policy_wrapper .col-md-6:eq(0)');
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#pesan").fadeTo(4000, 500).slideUp(500, function() {
            $("#pesan").slideUp(500);
        });

        $('#nama_kategori').keyup(function() {
            var title = $(this).val().toLowerCase().replace(/[&\/\\#^, +()$~%.'":*?<>{}]/g, '-');
            $('#link').val(title);
        });

        $('#nama_tag').keyup(function() {
            var title = $(this).val().toLowerCase().replace(/[&\/\\#^, +()$~%.'":*?<>{}]/g, '-');
            $('#link').val(title);
        });

        $('#nama_kb').keyup(function() {
            var title = $(this).val().toLowerCase().replace(/[&\/\\#^, +()$~%.'":*?<>{}]/g, '-');
            $('#link').val(title);
        });
    })
</script>

<script>
    $('.del').on('click', function(e) {
        e.preventDefault();
        var form = $(this).parents('form');

        Swal.fire({
            title: 'Anda yakin mau menghapus?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = this.href;
            }
        })
    });
    $('.del2').on('click', function(e) {
        e.preventDefault();
        var form = $(this).parents('form');

        Swal.fire({
            title: 'Anda yakin mau menghapus seluruh Data?',
            text: "Data yang dihapus adalah seluruh data pada tabel!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = this.href;
            }
        })
    });
</script>

</body>

</html>