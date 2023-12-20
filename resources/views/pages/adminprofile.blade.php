@include('navigation/header')
    <body class="sb-nav-fixed">
       @include('navigation/navigation')
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                @include('navigation/sidebar')
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-6">
                        <h1></h1>
                        <div class="card ">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <i class="fas fa-user"></i>
                                                Information
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-md-12">
                                            <table class = "table  table-bordered table-stripped">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th>NAME</th>
                                                        <th>{{ $profile[0]->fullname }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>POSITION</th>
                                                        <td>{{ $profile[0]->position }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>DEPARTMENT</th>
                                                        <td>{{ $profile[0]->department_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>EMAIL</th>
                                                        <td>{{ $profile[0]->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>CONTACT NUMBER</th>
                                                        <td>{{ $profile[0]->contact_number }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>ROLE</th>
                                                        <td>{{ $profile[0]->role == 1 ? "ADMIN" : "PURCHASER" }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>USERNAME</th>
                                                        <td>{{ $profile[0]->username }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <i class="fas fa-user"></i>
                                               Login Credentials
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body ">
                                        <div class  ="col-md-12">
                                            @if(Session::get('success'))
                                                <div class="alert alert-success">
                                                    {{ Session::get('success') }}
                                                </div>
                                            @endif
                                            @if(Session::get('PasswordError'))
                                                <div class="alert alert-danger">
                                                    {{ Session::get('PasswordError') }}
                                                </div>
                                            @endif
                                            @if(Session::get('NPasswordError'))
                                                <div class="alert alert-danger">
                                                    {{ Session::get('NPasswordError') }}
                                                </div>
                                            @endif
                                            <form method = "post" action="{{ route('users.admin_changePass') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="username">Username</label>
                                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#username-msg').html('');" type="text" name = "username"  value = "{{ old('username') }}" class="form-control" id="username" placeholder="Enter your username">
                                                    @error('username')
                                                        <span class="badge badge-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Current Password</label>
                                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#currpwd-msg').html('');" type="password" name = "currpwd" class="form-control" id="currpwd" placeholder="Enter your current password">
                                                    @error('currpwd')
                                                        <span class="badge badge-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">New Password</label>
                                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#newpwd-msg').html('');" type="password" name = "newpwd" class="form-control" id="newpwd" placeholder="Enter your new password">
                                                    @error('newpwd')
                                                        <span class="badge badge-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Confirm Password</label>
                                                    <input autocomplete="off" onkeyup="$(this).removeClass('is-invalid'); $('#conpwd-msg').html('');" type="password" name = "conpwd" class="form-control" id="conpwd" placeholder="Enter your confirm password">
                                                    @error('conpwd')
                                                        <span class="badge badge-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <p></p><p></p>
                                                <div class="form-group">
                                                   <button type="submit" class = "btn btn-success btn-block"><i class = "fas fa-save"></i>&nbsp;Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" style = "text-align:center">
                                    <div class="img-responsive">
                                        <img src="{{ asset('admintemplate/assets/img/shs-logo.png') }}" alt=""  style = "width: 350px; height: 350px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

    @include('navigation/footer')
    <script  type="text/javascript">
        $(document).ready(function(){
            $("#s_profiles").addClass('active');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token':$("input[name=_token").val()
                }
            })
        });
    </script>