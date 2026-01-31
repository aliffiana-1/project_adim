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

        html,
        body {
            height: 100%;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f5f6fa;
            /* bebas ganti */
        }

        .authentication-wrapper.authentication-basic .authentication-inner {
            max-width: 820px !important;
        }




        .authentication-inner .card {
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .15);
        }

        /* Biar card tetap gaya finance */
        .card {
            border-radius: 0.5rem;
            border: 0;
        }

        /* INI yang bikin besar */
        .authentication-inner {
            max-width: 520px;
            /* default finance ±360, ini kita gedein */
            width: 100%;
        }

        /* Kasih nafas ke dalam */
        .card-body {
            padding: 2.5rem 2.5rem;
            /* default 1.5rem, kita gedein */
        }

        /* Input & button lebih tinggi */
        .form-control {
            height: 48px;
            font-size: 15px;
        }

        .btn {
            height: 48px;
            font-size: 16px;
        }

    </style>
</head>

<body>


    <body>
        <div class="login-wrapper">
            <div class="authentication-wrapper authentication-basic">
                <div class="authentication-inner">

                    <div class="card">
                        <div class="card-body">
                            <div class="app-brand justify-content-center">
                                <span class="app-brand-logo demo">
                                    <img src="" style="width:280px;" alt="">
                                </span>
                            </div>
                            <h4 class="mb-2">BPJS System</h4>
                            <p class="mb-4">Please sign-in to your account</p>
                            @if (\Session::has('error'))
                            <div class="alert alert-danger d-flex alert-dismissible" role="alert">
                                <span class="badge badge-center rounded-pill bg-danger border-label-danger p-3 me-2">🙁</span>
                                <div class="d-flex flex-column ps-1">
                                    <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Oops!</h6>
                                    <span>{{ Session::get('error') }}</span>
                                </div>
                            </div>
                            @endif
                            <form action="{{ route('register_store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label>Username</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>Full Name</label>
                                    <input type="text" name="full_name" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>NIP</label>
                                    <input type="text" name="nip" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>

                                <button class="btn btn-primary w-100">Register</button>

                                <div class="text-center mt-3">
                                    Sudah punya akun? <a href="{{ route('login') }}">Login</a>
                                </div>
                            </form>

                        </div>


                    </div>
                </div>
            </div>
    </body>

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
