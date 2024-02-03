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
        /* Notification */
        ul {
            list-style: none;
            margin: 0;
            padding: 0;
          }

          .notification-drop {
            font-family: 'Ubuntu', sans-serif;
            color: #444;
          }
          .notification-drop .item {
            padding: 10px;
            font-size: 18px;
            position: relative;
            border-bottom: 1px solid #ddd;
          }
          .notification-drop .item:hover {
            cursor: pointer;
          }
          .notification-drop .item i {
            margin-left: 10px;
          }
          .notification-drop .item ul {
            display: none;
            position: absolute;
            top: 100%;
            background: #fff;
            left: -200px;
            right: 0;
            z-index: 1;
            border-top: 1px solid #ddd;
          }
          .notification-drop .item ul li {
            font-size: 16px;
            padding: 15px 0 15px 25px;
          }
          .notification-drop .item ul li:hover {
            background: #ddd;
            color: rgba(0, 0, 0, 0.8);
          }

          @media screen and (min-width: 500px) {
            .notification-drop {
              display: flex;
              justify-content: flex-end;
            }
            .notification-drop .item {
              border: none;
            }
          }
          .notification-bell{
            font-size: 20px;
          }

          .btn__badge {
            background: #FF5D5D;
            color: white;
            font-size: 12px;
            position: absolute;
            top: 0;
            right: 0px;
            padding:  3px 10px;
            border-radius: 50%;
          }

          .pulse-button {
            box-shadow: 0 0 0 0 rgba(255, 0, 0, 0.5);
            -webkit-animation: pulse 1.5s infinite;
          }

          .pulse-button:hover {
            -webkit-animation: none;
          }

          @-webkit-keyframes pulse {
            0% {
              -moz-transform: scale(0.9);
              -ms-transform: scale(0.9);
              -webkit-transform: scale(0.9);
              transform: scale(0.9);
            }
            70% {
              -moz-transform: scale(1);
              -ms-transform: scale(1);
              -webkit-transform: scale(1);
              transform: scale(1);
              box-shadow: 0 0 0 50px rgba(255, 0, 0, 0);
            }
            100% {
              -moz-transform: scale(0.9);
              -ms-transform: scale(0.9);
              -webkit-transform: scale(0.9);
              transform: scale(0.9);
              box-shadow: 0 0 0 0 rgba(255, 0, 0, 0);
            }
          }

          .notification-text{
            font-size: 14px;
            font-weight: bold;
          }

          .notification-text span{
            float: right;
          }
    </style>

</head>
<body>
    <nav class="sb-topnav navbar navbar-expand" style="background-color: #005c65;">
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
          <ul class="notification-drop">
            <li class="item">
              <i class="fa fa-bell fa-lg notification-bell" aria-hidden="true"></i> <span class="btn__badge pulse-button " id = "lowstock"></span>     
              <ul id = "notificationlist">
              </ul>
            </li>
        </ul>
    </nav>
    <script>
        var navbarDropdown = document.getElementById('navbarDropdown');

    
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
