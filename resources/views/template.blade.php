<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ $title }} | BPJS</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link rel="icon" href="https://BPJS.ac.id/images/BPJS-logo-no-bintang-02---logo-only.png">

    <!-- Google Web Fonts -->
    <link href="https://fonts.cdnfonts.com/css/segoe-ui-variable-static-display" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/lib/owlcarousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lib/animate/animate.min.css') }}">

    <!-- Customized Bootstrap Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- Template Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- UI KIT -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.15.10/dist/css/uikit.min.css" /> --}}

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @section('css')
    <style type="text/css">
        .search-nav {
            padding-top: 40px;
            height: 38px;
            border-radius: 8px;
            outline-color: maroon;
            border-color: maroon;
        }

        .button-nav {
            background-color: maroon;
            border: none;
            color: white;
            padding: 7px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 8px;
        }

        .dropdown-item.active,
        .dropdown-item:active {
            color: #fff;
            text-decoration: none;
            background-color: maroon;
        }

        .w-100 {
            width: 100% !important;
            height: 100vh;
        }

        body {
            overflow-x: hidden;
        }

        .dropdown-menu {
            max-width: 240px;
            overflow-x: hidden;
        }

        .dropdown-menu-end {
            right: 0 !important;
            left: auto !important;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            inset: auto 0 auto auto !important;
            transform: translateX(-10px) !important;
        }

        html,
        body {
            max-width: 100%;
            overflow-x: hidden !important;
        }



        /* .responsive {
                    width: 100%;
                    max-width: auto;
                    height: auto;
                } */

    </style>
    @show
</head>

<body>
    <!-- Navbar & Carousel Start -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg navbar-dark" style="background: #ffffff">
            <div class="container-fluid">
                <a class="navbar-brand">
                </a>
                <button class="navbar-toggler" style="background-color: maroon" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link {{ $title == 'Dashboard' ? 'active' : '' }}" style="font-size: 14px;" aria-current="page" href="{{ route('dashboard') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $title == 'Article' ? 'active' : '' }}" style="font-size: 14px;" href="{{ route('article') }}">Article</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $title == 'About Us' ? 'active' : '' }}" style="font-size: 14px;" {{-- href="{{ route('aboutus') }}" --}}>About Us</a>
                        </li>

                        {{-- MENU KHUSUS LOGIN --}}
                        @if(session('is_login'))

                        {{-- PENULIS --}}
                        @if(session('role_name') == 'author')
                        <li class="nav-item">
                            <a style="font-size: 14px;" class="nav-link {{ $title == 'Article Center' ? 'active' : '' }}" href="{{ route('article_editor') }}">Article Center</a>
                        </li>
                        @endif

                        {{-- ADMIN --}}
                        @if(session('role_name') == 'admin')
                        <li class="nav-item">
                            <a style="font-size: 14px;" class="nav-link {{ $title == 'Article Center' ? 'active' : '' }}" href="{{ route('article_editor') }}">Article Center</a>
                        </li>
                        <li class="nav-item">
                            <a style="font-size: 14px;" class="nav-link {{ $title == 'Level' ? 'active' : '' }}" href="{{ route('level_editor') }}">Level Center</a>
                        </li>
                        <li class="nav-item">
                            {{-- <a style="font-size: 14px;" class="nav-link {{ $title == 'Category' ? 'active' : '' }}" href="{{ route('category_editor') }}">Category</a> --}}
                        </li>
                        <li class="nav-item">
                            <a style="font-size: 14px;" class="nav-link {{ $title == 'User' ? 'active' : '' }}" href="{{ route('user_editor') }}">User Center</a>
                        </li>
                        @endif
                        @endif
                    </ul>
                    @if ($title != '')
                    <div class="d-flex">
                        @elseif ($title == 'Dashboard' || $title == 'About Us')
                        <?php $link = 'dashboard'; ?>
                        @elseif ($title == 'Article')
                        <?php $link = 'article'; ?>
                        @elseif ($title == 'Article Center')
                        <?php $link = 'article_editor'; ?>
                        @elseif ($title == 'Article Details')
                        <?php $link = 'article_details'; ?>
                        @endif

                        <div class="d-flex align-items-center">

                            @if(session('is_login'))

                            <div class="dropdown">
                                <button class="btn btn-light dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">

                                    <i class="fa fa-user-circle fa-lg"></i>
                                </button>


                                <ul class="dropdown-menu dropdown-menu-end shadow" style="min-width:220px">

                                    <li class="px-3 py-2">
                                        <div class="fw-bold">{{ session('full_name') }}</div>
                                        <div class="text-muted" style="font-size:12px;">
                                            {{ session('role_name') ?? 'User' }}
                                        </div>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>
                                        <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                                            <i class="fa fa-sign-out-alt me-2"></i> Log Out
                                        </a>
                                    </li>

                                </ul>

                            </div>

                            @else

                            <a href="{{ route('login') }}" class="btn btn-dark ms-3">
                                <i class="fa fa-user me-2"></i>
                                Login
                            </a>

                            @endif
                        </div>

                    </div>
                </div>
        </nav>
    </div>

    @if ($title == 'Dashboard')
    <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100 responsive" src="{{ asset('assets/image/bpjs/bpjs-Seminar.png') }}" style="object-fit: cover; height: 710px;" alt="Image" />
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 900px">
                        <h5 class="text-white text-uppercase mb-3 animated slideInDown">
                            BPJS
                        </h5>
                        <h3 class="display-1 text-white mb-md-4 animated zoomIn">
                            SEMINAR
                        </h3>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="w-100 responsive" src="{{ asset('assets/image/bpjs/bpjs-Entrepreneurship.png') }}" style="object-fit: cover; height: 710px;" alt="Image" />
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 900px">
                        <h5 class="text-white text-uppercase mb-3 animated slideInDown">
                            BPJS
                        </h5>
                        <h3 class="display-1 text-white mb-md-4 animated zoomIn">

                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    @endif
    <!-- Navbar & Carousel End -->

    @if ($title == 'Dashboard')
    <!-- Service Start -->
    @yield('dashboard')
    <!-- Service End -->
    @endif
    @if ($title == 'Article')
    <!-- Service Start -->
    @yield('article')
    <!-- Service End -->
    @endif

    @if ($title == 'Article Center')
    <!-- Service Start -->
    @yield('article_editor')
    <!-- Service End -->
    @endif

    @if ($title == 'About Us')
    <!-- Service Start -->
    @yield('aboutus')
    <!-- Service End -->
    @endif

    @if ($title == 'Article Details')
    <!-- Webinar Start -->
    @yield('article-details')
    <!-- Webinar End -->
    @endif

    @if ($title == 'Level')
    @yield('level_editor')
    @endif

    @if ($title == 'User')
    @yield('user_editor')
    @endif


    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light mt-5 uk-animation-fade">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-8">
                    <div class="d-flex flex-column h-100 p-4">

                        <h2 class="m-0 text-white">
                            Tentang BPJS
                        </h2>
                        <p class="mt-3" style="text-align: justify">
                            VISI <br>

                            Menjadi badan penyelenggara yang dinamis, akuntabel, dan tepercaya untuk mewujudkan jaminan kesehatan yang berkualitas, berkelanjutan, berkeadilan, dan inklusif.

                            <br><br>
                            MISI
                            <br>
                            <ol>
                                <li>Meningkatkan kualitas layanan kepada peserta melalui layanan terintegrasi berbasis teknologi informasi.</li>
                                <li>Menjaga keberlanjutan Program JKN-KIS dengan menyeimbangkan antara dana jaminan sosial dan biaya manfaat yang terkendali.</li>
                                <li>Memberikan jaminan kesehatan yang berkeadilan dan inklusif mencakup seluruh penduduk Indonesia.</li>
                                <li>Memperkuat engagement dengan meningkatkan sinergi dan kolaborasi pemangku kepentingan dalam mengimplementasikan program JKN-KIS.</li>
                                <li>Meningkatkan kapabiltas Badan dalam menyelenggarakan Program JKN-KIS secara efisien dan efektif yang akuntabel, berkehati-hatian dengan prinsip tata kelola yang baik, SDM yang produktif, mendorong transformasi digital serta inovasi yang berkelanjutan.</li>
                            </ol>

                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row gx-5">
                        <div class="col-lg-12 mb-5 p-4">
                            <div class="position-relative pb-3">
                                <h3 class="text-light mb-0">Hubungi Kami</h3>
                            </div>
                            <div class="link-animated d-flex flex-column" style="text-decoration: none; ">
                                <a style="text-decoration: none; list-style:none;" target="_blank" class="text-light">
                                    <h2>021 421 2938</h2>
                                </a>
                                <a style="text-decoration: none; list-style:none;" class="text-light mt-2"><i class="far fa-envelope me-2">
                                    </i>infobpjs@bpjs.ac.id
                                </a>
                                <a style="text-decoration:none" class="text-light mt-3" target="_blank" href="https://maps.google.com/?q=Jl. Letjen Suprapto Kav. 20 No.14
    Jakarta Pusat 10510, Telp. 021 421 2938"><i class="fas fa-map-marker-alt "></i> Jl. Letjen Suprapto Kav. 20 No.14
                                    Jakarta Pusat 10510, Telp. 021 421 2938
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid text-white" style="background: maroon">
        <div class="container text-center">
            <div class="row justify-content-end">
                <div class="col-lg-12 col-md-6">
                    <div class="d-flex align-items-center justify-content-center" style="height: 75px">
                        <p class="mb-0">
                            &copy;
                            {{ date('Y') }} BINUS
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <script>
        document.addEventListener('shown.bs.dropdown', function(e) {
            const menu = e.target.querySelector('.dropdown-menu');
            if (!menu) return;

            const rect = menu.getBoundingClientRect();
            const overflowRight = rect.right - window.innerWidth;

            if (overflowRight > 0) {
                menu.style.transform = `translateX(-${overflowRight + 10}px)`;
            } else {
                menu.style.transform = '';
            }
        });

    </script>


</body>
<!-- UI KIT -->
{{-- <script src="https://cdn.jsdelivr.net/npm/uikit@3.15.10/dist/js/uikit.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.15.10/dist/js/uikit-icons.min.js"></script> --}}

<!-- JavaScript Libraries -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/lib/wow/wow.min.js') }}"></script>
<script src="{{ asset('assets/lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('assets/lib/waypoints/waypoints.min.js') }}"></script>
<script src="{{ asset('assets/lib/counterup/counterup.min.js') }}"></script>
<script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>

<!-- Template Javascript -->
<script src="{{ asset('assets/js/main.js') }}"></script>
@section('js')
@show

</html>
