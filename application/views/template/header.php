<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?= $judul ?></title>
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() ?>assets/img/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>assets/img/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>assets/img/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url() ?>assets/img/favicon_io/site.webmanifest">
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google fonts-->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,wght@0,600;1,600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,300;0,500;0,600;0,700;1,300;1,500;1,600;1,700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,400;1,400&amp;display=swap" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="<?= base_url() ?>assets/css/styles.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/ca0b438cb2.js" crossorigin="anonymous"></script>

    <!-- Google Recaptcha -->
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=6156e9646a41fc001a0acfdb&product=inline-share-buttons" async="async"></script>

    <style>
        .bt {
            text-align: center;
        }

        .Sidebar.sticky-top {
            top: 90px
        }

        #btn-back-to-top {
            position: fixed;
            bottom: 20px;
            right: 10px;
            display: none;
            z-index: 9999;
        }

        .img-hover-zoom {
            overflow: hidden;
        }

        .img-hover-zoom img {
            transition: transform .5s ease;
        }

        .img-hover-zoom:hover img {
            transform: scale(1.1);
        }

        .cover {
            width: 100%;
            height: 15vw;
            object-fit: cover;
        }

        .page-link a {
            text-decoration: none;
            color: gray;
        }

        .site-banner {
            padding-top: 2%;
            padding-left: 2%;
            padding-right: 2%;
        }

        ul #ket li .nav-item {
            font-size: 10px;
        }

        /* Mobile */
        @media screen and (max-width: 540px) {
            #img_l {
                width: 300px !important;
            }

            #ket {
                font-size: .9rem;
            }

            .cover {
                width: 100%;
                height: 48vw;
                object-fit: cover;
            }

            #btn-back-to-top {
                right: 10px;
            }

            .site-banner {
                padding-top: 10%;
                padding-left: 0%;
                padding-right: 0%;
            }

            .site-banner #deskripsi img {
                width: 100%;
            }
        }

        /* Tablets */
        @media screen and (min-width: 540px) and (max-width: 596px) {
            #img_l {
                width: 300px !important;
            }

            #avt {
                width: 40px !important;
                height: 40px !important;
            }

            ul #ket li .nav-item a,
            i {
                margin-right: 0.20rem !important;
                margin-left: 0.20rem !important;
            }

            #ket {
                width: 18rem;
            }

            #logo-name {
                width: 0.1rem !important;
                font-size: medium;
            }

            #foto .card-body .card-title {
                padding: 3rem !important;
            }

            .cover {
                width: 100%;
                height: 50vw;
                object-fit: cover;
            }

            .site-banner #deskripsi img {
                width: 100%;
            }

        }

        @media screen and (min-width: 597px) and (max-width: 718px) {
            .cover {
                width: 100%;
                height: 40vw;
                object-fit: cover;
            }

            .site-banner #deskripsi img {
                width: 100%;
            }
        }

        @media screen and (min-width: 720px) and (max-width: 991px) {
            .cover {
                width: 100%;
                height: 40vw;
                object-fit: cover;
            }

            .site-banner #deskripsi img {
                width: 100%;
            }
        }

        @media screen and (min-width: 768px) and (max-width: 986px) {
            .cover {
                width: 100%;
                height: 20vw;
                object-fit: cover;
            }

            .site-banner #deskripsi img {
                width: 100%;
            }
        }

        /* Laptop atau PC */
        @media screen and (min-width: 992px) {

            .cover {
                width: 100%;
                height: 12vw;
                object-fit: cover;
            }

            ul #ket li .nav-item a,
            i {
                margin-right: 0.10rem !important;
                margin-left: 0.20rem !important;
            }

            ul #ket li .nav-item a,
            i {
                margin-right: 0.10rem !important;
                margin-left: 0.20rem !important;
            }

            #foto .card-body .card-title {
                padding: 5rem !important;
            }

            .site-banner #deskripsi img {
                width: 100%;
            }

            /* img #imgHead {
                width: 1px;
            } */
        }
    </style>
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm" id="mainNav">
        <div class="container px-5">
            <a class="navbar-brand fw-bold" href="<?= base_url() ?>">
                <img src="<?= base_url() ?>assets/img/logo.svg" id="log1" alt="logo" width="30">
                <img src="<?= base_url() ?>assets/img/logo v2.svg" id="log2" alt="logo" width="30">
            </a>
            <button class="navbar-toggler" id="togl" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="bi-list"></i>
            </button>
            <div class="collapse navbar-collapse text-center" id="navbarResponsive">
                <ul class="navbar-nav ms-auto me-4 my-3 my-lg-0">
                    <li class="nav-item"><a class="nav-link me-lg-3" data-bs-toggle="modal" data-bs-target="#search"><i class="bi-search" id="search_btn"></i></a></li>
                    <button onclick="window.location.href='<?= base_url('auth') ?>'" class="btn btn-secondary btn-sm rounded me-1 ms-1 mb-2 mb-lg-0">
                        <span class="d-flex align-items-center px-3">
                            <i class="bi bi-box-arrow-in-right"></i> <span class="small text-center"> Masuk</span>
                        </span>
                    </button>
                    <button class="btn btn-primary btn-sm rounded me-1 ms-1 mb-2 mb-lg-0" data-bs-toggle="modal" data-bs-target="#feedbackModal">
                        <span class="d-flex align-items-center px-3">
                            <i class="bi-chat-text-fill"></i> <span class="small"> Kirim Pesan</span>
                        </span>
                    </button>
                    <button class="btn btn-light btn-sm rounded p-2 me-1 ms-1 mb-2 mb-lg-0">
                        <span class="d-flex align-items-center px-3">
                            <i class="fas fa-moon text-center" id="switch-id"></i> <span class="small"> Mode</span>
                        </span>
                    </button>
                </ul>
            </div>
        </div>
    </nav>