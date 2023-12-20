<!doctype html>
<html lang="en">
  <head>
    <title>LSHS-IMS LOGIN</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="admintemplate/assets/img/round.png">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="{{ asset('login/css/style.css') }}">

    </head>
    <style>
  a.learn-more {
    position: relative;
    color: #2C4B5F;
    text-decoration: none;
    overflow: hidden;
    transition: color 0.3s ease-in-out, background-color 0.3s ease-in-out;
  }

  a.learn-more:before {
    content: "";
    position: absolute;
    width: 100%;
    height: 2px;
    bottom: 0;
    left: 0;
    background-color: #2C4B5F;
    visibility: hidden;
    transform: scaleX(0);
    transition: all 0.3s ease-in-out;
  }
  body {
    width: 100vw;
    height: 100vh;
    background:    linear-gradient(
          rgba(0, 0, 0, 0.7), 
          rgba(0, 0, 0, 0.7)
        ),url('admintemplate/assets/img/b.jpg');
    background-size: cover;
  }
  a.learn-more:hover {
    color: #2C4B5F;
  }

  a.learn-more:hover:before {
    visibility: visible;
    transform: scaleX(1);
  }
</style>
    <body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="wrap">
                        <div class="img" style="background-image: url(login/images/happy.gif);"></div>
                        <div class="login-wrap p-4 p-md-5">
                    <div class="d-flex">
                        <div class="w-100">
                            <h3 class="mb-4">Sign In</h3>
                        </div>
                          <div class="w-100">
                            <p class="social-media d-flex justify-content-end">
                                <a class="social-icon d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('admintemplate/assets/img/round.png') }}" alt="LSHS Logo" width="110" height="110">
                                </a>
                            </p>
                        </div>
                    </div>
                            <form method = "post"  action="{{ route('user.login') }}">
                            @csrf
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" value="{{ old('username') }}" autocomplete="off" name="username"required>
                            <label class="form-control-placeholder" for="username">Username</label>
                              @error('username')
                                        <span class="badge badge-danger">{{ $message }}</span>
                                        @enderror
                        </div>
                    <div class="form-group">
                      <input id="password-field" name = "password"  value="{{ old('password') }}" type="password" class="form-control" required>
                      <label class="form-control-placeholder" for="password">Password</label>
                      <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                      @error('password')
                                        <span class="badge badge-danger">{{ $message }}</span>
                                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
                    </div>
                    @error('Error')
                    <span class="badge badge-danger">
                        {{ $message }}
                    </span>
                    @enderror
                    <!-- <div class="form-group d-md-flex justify-content-left">
                        <div class="w-30 text-md-left text-left">
                            <a class="learn-more" href="https://www.facebook.com/LugaitSHS" target="_blank">Learn More</a>
                        </div>
                        </div> -->
                  </form>
                </div>
              </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('login/js/jquery.min.js') }}"></script>
  <script src="{{ asset('login/js/popper.js') }}"></script>
  <script src="{{ asset('login/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('login/js/main.js') }}"></script>

    </body>
</html>
