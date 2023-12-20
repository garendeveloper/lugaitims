<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>LSHS USER LOGIN</title>
    <link href="{{ asset('admintemplate/css/styles.css') }}" rel="stylesheet" />
    <script src="{{ asset('admintemplate/js/all.js') }}" crossorigin="anonymous"></script>
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://use.fontawesome.com/releases/v5.7.2/css/all.css' rel='stylesheet'>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <style>
        ::-webkit-scrollbar {
            width: 8px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        body {
            background-color: #fff;
            font-family: 'Karla', sans-serif;
        }

        h1 > a {
            text-decoration: none;
            color: #fff !important;
        }

        .hide-placeholder::placeholder {
            color: transparent;
        }

        .intro-section {
            background-image: url('admintemplate/assets/img/gif.gif'); /* Replace with your GIPHY GIF URL */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            padding: 75px 95px;
            min-height: 100vh;
            display: -webkit-box;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            flex-direction: column;
            color: #ffffff;
        }

        @media (max-width: 991px) {
            .intro-section {
                padding-left: 50px;
                padding-right: 50px;
            }
        }

        @media (max-width: 767px) {
            .intro-section {
                padding: 28px;
            }
        }

        @media (max-width: 575px) {
            .intro-section {
                min-height: auto;
            }
        }

        .brand-wrapper .logo {
                width: 200px; /* Adjust the width to your preferred size */
                height: 200px; /* Adjust the height to your preferred size */
                border-radius: 50%; /* Make the image circular */
                border: 3px solid #fff; /* Add a white border to the image */
            }

        @media (max-width: 767px) {
            .brand-wrapper {
                margin-bottom: 35px;
            }
        }

        .intro-content-wrapper {
            width: 410px;
            max-width: 100%;
            margin-top: auto;
            margin-bottom: auto;
        }

        .intro-content-wrapper .intro-title {
            font-size: 50px; /* Increase the font size to your preferred value */
        font-weight: bold;
        margin-bottom: 17px;
        }

        .intro-content-wrapper .intro-text {
            font-size: 24px; /* Increase the font size to your preferred value */
        line-height: 1.37;
        }

        .intro-content-wrapper .btn-read-more {
            background-color: #fff;
            padding: 13px 30px;
            border-radius: 20px;
            font-size: 16px;
            font-weight: bold;
            color: #000;
        }

        .intro-content-wrapper .btn-read-more:hover {
            background-color: transparent;
            border: 1px solid #fff;
            color: #fff;
        }

        @media (max-width: 767px) {
            .intro-section-footer {
                margin-top: 35px;
            }
        }

        .intro-section-footer .footer-nav a {
            font-size: 20px;
            font-weight: bold;
            color: inherit;
        }

        @media (max-width: 767px) {
            .intro-section-footer .footer-nav a {
                font-size: 14px;
            }
        }

        .intro-section-footer .footer-nav a + a {
            margin-left: 30px;
        }

        .form-section {
            display: -webkit-box;
            display: flex;
            -webkit-box-align: center;
            align-items: center;
            -webkit-box-pack: center;
            justify-content: center;
        }

        @media (max-width: 767px) {
            .form-section {
                padding: 35px;
            }
        }

        .login-wrapper {
        width: 300px;
        max-width: 100%;
        border: 1px solid #ccc;
        border-radius: 10px; /* Adjust the radius to your preference */
        padding: 20px;
        background-color: #fff;
    }

        @media (max-width: 575px) {
            .login-wrapper {
                width: 100%;
            }
        }

        .login-wrapper .form-control {
            border: 0;
            border-bottom: 1px solid #e7e7e7;
            border-radius: 0;
            font-size: 14px;
            font-weight: bold;
            padding: 15px 10px;
            margin-bottom: 7px;
        }

        .login-wrapper .form-control::-webkit-input-placeholder {
            color: #b0adad;
        }

        .login-wrapper .form-control::-moz-placeholder {
            color: #b0adad;
        }

        .login-wrapper .form-control:-ms-input-placeholder {
            color: #b0adad;
        }

        .login-wrapper .form-control::-ms-input-placeholder {
            color: #b0adad;
        }

        .login-wrapper .form-control::placeholder {
            color: #b0adad;
        }

        .login-title {
            font-size: 34px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .login-btn {
            padding: 13px 30px;
            background-color: #000;
            border-radius: 0;
            font-size: 20px;
            font-weight: bold;
            color: #fff;
        }

        .login-btn:hover {
            border: 1px solid #000;
            background-color: transparent;
            color: #000;
        }

        .login-wrapper-footer-text {
            font-size: 14px;
            text-align: center;
        }

        .hide-placeholder::placeholder {
            color: transparent;
        }

        /* Add the following CSS to apply curved borders to the login box */
        .login-wrapper {
            width: 300px;
            max-width: 100%;
            border: 1px solid #ccc;
            border-radius: 10px; /* Adjust the radius to your preference */
            padding: 20px;
            background-color: #fff;
        }

        /* Add the following CSS to apply border radius to input boxes */
        .login-wrapper .form-control {
            border: 1px solid #ccc;
            border-radius: 5px; /* Adjust the radius to your preference */
            font-size: 14px;
            font-weight: bold;
            padding: 15px 10px;
            margin-bottom: 7px;
        }

    </style>

<script>
        document.addEventListener("DOMContentLoaded", function() {
            const inputElements = document.querySelectorAll(".hide-placeholder");

            inputElements.forEach(function(inputElement) {
                inputElement.addEventListener("focus", function() {
                    inputElement.setAttribute("placeholder", "");
                });

                inputElement.addEventListener("blur", function() {
                    if (inputElement.value === "") {
                        inputElement.setAttribute("placeholder", ""); // Add your desired placeholder text
                    }
                });
            });
        });
    </script>

</head>
<body class="bg-info">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6 col-md-7 intro-section">
                        <div class="brand-wrapper">
                                    <!-- Add your logo here -->
                                    <img src="/admintemplate/assets/img/shs-logo.png" alt="Your Logo" class="logo">
                                </div>
                            <div class="intro-content-wrapper">
                                <h1 class="intro-title">Welcome to Lugait SHS ITEM MANAGEMENT SYSTEM !</h1>
                                <p class="intro-text">Welcome to our Items Management website – your inventory's best friend. Streamline, organize, and optimize with ease. Say goodbye to chaos, and hello to efficiency.</p>
                                <a href="https://www.facebook.com/LugaitSHS" class="btn btn-read-more" target="_blank">Learn more</a>
                            </div>
                            <div class="intro-section-footer">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-5 form-section">
                        <div class="login-wrapper" style="width: 550px; max-width: 100%; padding: 60px; background-color: #fff;">
                        <h2 class="login-title">
                            <span style="padding-right: 180px;">Sign in</span>
                            <a href="https://www.deped.gov.ph" target="_blank">
                                <img src="{{ asset('admintemplate/assets/img/deped.png') }}" alt="DepEd Logo" width="120">
                            </a>
                        </h2>
                                <form method="post" action="{{ route('user.login') }}">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input class="form-control hide-placeholder" id="inputEmail" value="{{ old('username') }}" name="username" type="text" placeholder="" autocomplete="off" />
                                        <label for="inputEmail">Username</label>
                                        @error('username')
                                        <span class="badge badge-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control hide-placeholder" id="inputPassword" value="{{ old('password') }}" name="password" type="password" placeholder="" autocomplete="off" />
                                        <label for="inputPassword">Password</label>
                                        @error('password')
                                        <span class="badge badge-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        @error('Error')
                                        <span class="badge badge-danger">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="d-flex align-items-center">
                                         <button class="btn btn-dark" type = "submit"><i class = "fa fa-sign-in"></i>&nbsp; Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="{{ asset('admintemplate/js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('admintemplate/js/scripts.js') }}"></script>
    @include('scripts.clock')
</body>
</html>
