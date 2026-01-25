<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>BPJS | LOGIN</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Rubik:wght@400;500;600;700&display=swap" rel="stylesheet" />

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
    <style>
        .img-fluid {
            max-width: 100%;
            object-fit: cover;
            height: 100%;
        }

    </style>
</head>

<body>
    {{-- <div class="container-fluid p-0"> --}}
    {{-- <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand"><img src="{{ asset('assets/image/bpjs/bg aman.png') }}" width="120px"></a>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item">
                <a class="nav-link {{ $title == 'Dashboard' ? 'active' : '' }}" aria-current="page" href="{{ route('dashboard') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $title == 'Find Job' || $title == 'Job Details' ? 'active' : '' }}" href="{{ route('findjob') }}">Find Jobs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $title == 'Webinar' ? 'active' : '' }}" href="{{ route('webinar') }}">Webinar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $title == 'News' ? 'active' : '' }}" href="{{ route('news') }}">News</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $title == 'Tracer Study' ? 'active' : '' }}" href="{{ route('alumni/form-kuesioner') }}">Tracer Study</a>
            </li>
        </ul>
    </div>
    </div>
    </nav> --}}
    {{-- <div class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100 responsive" src="{{ asset('assets/image/bpjs/.jpg') }}" alt="Image" />
    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
        <div class="p-3">
            <form method="POST" action="{{ route('check-login') }}">
                @csrf
                @csrf
                @if (\Session::has('error'))
                $msg = Session::get('error');
                <div style="margin-bottom: 10px">
                    <span style="font-weight: bold; color: white; background-color: maroon;padding: 5px">
                        {{ $msg }} </span>
                </div>
                @php \Session::forget('success') @endphp
                @php \Session::forget('error') @endphp
                @endif
                <div class="text-center mb-3">
                    <div class="card-header">
                        <h2>LOGIN</h2>
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="loginName">Email</label>
                        <input type="text" id="loginName" name="username" class="form-control" required />

                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="loginPassword">Password</label>
                        <input type="password" name="password" id="loginPassword" class="form-control" required />
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>
                    <div class="text-center">
                        <p>Don't have an alumni account yet? <a href="{{ route('alumni/register') }}" style="color: white">Register</a></p>
                    </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    </div> --}}

    <body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <div class="app-brand justify-content-center">
                            <span class="app-brand-logo demo">
                                <img src="" style="width:280px;"
                                    alt="">
                            </span>
                        </div>
                        <h4 class="mb-2">Welcome to BPJS System! 👋</h4>
                        <p class="mb-4">Please sign-in to your account</p>
                        @if (\Session::has('error'))
                            <div class="alert alert-danger d-flex alert-dismissible" role="alert">
                                <span
                                    class="badge badge-center rounded-pill bg-danger border-label-danger p-3 me-2">🙁</span>
                                <div class="d-flex flex-column ps-1">
                                    <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Oops!</h6>
                                    <span>{{ Session::get('error') }}</span>
                                </div>
                            </div>
                        @endif
                        <form id="formAuthentication" class="mb-3" action="{{ route('check-user') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email or Username</label>
                                <input type="text" class="form-control" id="email" name="username"
                                    placeholder="Enter your email or username" autofocus />
                            </div>
                            {{-- <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    <a href="auth-forgot-password-basic.html">
                                        <small>Forgot Password?</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password" required
                                        aria-describedby="password" placeholder="Enter your password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div> --}}
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    <a href="auth-forgot-password-basic.html" class="text-muted">
                                        <small>Forgot Password?</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="Enter your password" oninput="hiddenscript()"
                                        aria-describedby="password" required />
                                    <span class="input-group-text cursor-pointer">
                                        <a class="purple-head hover-black wrapper" class="eyeicon" id="myBtn">
                                            <i class="fas fa-eye" id="eye" onclick="Showfunction()"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
    {{-- </div> --}}
    {{-- <div class="container-fluid text-white" style="background: maroon">
        <div class="container text-center">
            <div class="row justify-content-end">
                <div class="col-lg-12 col-md-6">
                    <div class="d-flex align-items-center justify-content-center" style="height: 75px">
                        <p class="mb-0">
                            &copy;
                            2022  Jakarta 
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('assets/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>
