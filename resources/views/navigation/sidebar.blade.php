<style>
     .nav a {
         border-bottom: 3px solid transparent;
         color: #333; /* Default text color */
         transition: all 0.3s ease; /* Smooth transition for all properties */
     }

     .nav a:hover {
         border-bottom-color:#2C4B5F; /* Highlight the bottom border on hover */
         background-color: #eee; /* Background color on hover */
         color: #338ecf; /* Text color on hover */
     }

     .nav a.active {
         border-bottom-color: #2C4B5F; /* Highlight the active link with the same color as hover */
         background-color: #eee; /* Background color for active link */
         color: #338ecf; /* Text color for active link */
     }
     
</style>

<nav class="sb-sidenav accordion sb-sidenav-success" id="sidenavAccordion" style = "background-color: #83b2b7" >
    <div class="sb-sidenav-menu">
        <div class="nav">
        <div class="sb-sidenav-menu-heading">Core</div>
        <a class="nav-link" id = "s_dashboard" href="{{ route('admin.home') }}" >
            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
            &nbsp;&nbsp;
            Dashboard
        </a>
        <a class="nav-link" id = "s_items" href="{{ route('items.index') }}" >
            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
            &nbsp;&nbsp;
            Manage Items&nbsp;&nbsp; 
        </a>
        <!-- <a class="nav-link" id = "s_reqs" href="{{ route('requisitions.index') }}" >
            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
            &nbsp;&nbsp;
            Requisition
        </a> -->
        <a class="nav-link" id = "s_ritems" href="{{ route('requestingitems.index') }}" >
            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
            &nbsp;&nbsp;
            Requested Items&nbsp;&nbsp; <span class = 'badge badge-primary' id = "notif" style ="display: none">0</span>
        </a>
        <a class="nav-link" id = "s_mr" href="{{ route('admin.monthlyreport') }}" >
            <div class="sb-nav-link-icon">&nbsp;<i class="fas fa-file"></i></div>
            &nbsp;&nbsp;
            Monthly Report
        </a>
        <div class="sb-sidenav-menu-heading">User</div>
            <a class="nav-link" id = "s_departments" href="{{ route('departments.index') }}" >
                <div class="sb-nav-link-icon"><i class="fas fa-building"></i></div>
                &nbsp;&nbsp;
                Departments
            </a>
            <a class="nav-link" id = "s_profiles" href="{{ route('users.adminprofile') }}" >
                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                &nbsp;&nbsp;
                My Profile
            </a>
            <a class="nav-link" href="#" id = "logout">
                <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                &nbsp;&nbsp;
                Logout
            </a>
        </div>
        </div>
        <div class="sb-sidenav-footer" style = "font-size: 13px">
        <div class="small">Logged in as: </div>
        <b>{{ Auth::user()->fullname }}</b>
    </div>
</nav>
