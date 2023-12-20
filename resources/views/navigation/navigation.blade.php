<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        #sidebarToggle .fa-bars {
            transform: rotate(0deg);
            transition: transform 0.3s ease;
        }
        #sidebarToggle .fa-bars:hover {
            transform: rotate(45deg);
        }
        #sidebarToggle.active .fa-bars,
        #sidebarToggle .fa-times:hover {
            transform: rotate(90deg);
        }
        .digital-clock {
            font-family: 'Digital', sans-serif;
            font-weight: bold;
            font-size: 36px;
            color: white;
            margin-right: 20px;
            padding: 10px;
        }
    </style>

</head>
<body>
    <nav class="sb-topnav navbar navbar-expand" style="background-color: #2C4B5F;">
    <a class="navbar-brand ps-4" href="#" style="color: white;">
        <img src="{{ asset('admintemplate/assets/img/round.png') }}" alt="Second Logo" style="width: 50px; height: 50px; margin-right: 10px;">
        <img src="{{ asset('admintemplate/assets/img/seal.png') }}" alt="Logo LSHS" style="width: 50px; height: 50px;">
    </a>

            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" style="color: black; background-color: #192d42;">
            <i class="fas fa-bars" style="color: white;"></i>
            </button>
          
        <div class="digital-clock ml-auto">
        <div id="time" style="text-align: right;"></div>
        </div>
    </nav>


    <script>
        var sidebarToggle = document.getElementById('sidebarToggle');

        sidebarToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            var icon = this.querySelector('i');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        });
    </script>
</body>
</html>
