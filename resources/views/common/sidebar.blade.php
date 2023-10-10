<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('home')}}">
        <div class="sidebar-brand-icon ">
            <img class="img-profile" width="60" height="60"
                    src="{{asset('admin/img/TMC-logo.jpg')}}">
        </div>
        <div class="sidebar-brand-text mx-3">TMC</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{route('home')}}">
            <i class="fas fa-fw fa-home"></i>
            <span>Home</span></a>
    </li>

    

    <!-- Nav Item - Pages Collapse Menu -->
    @if (auth()->user()->role === 'admin')
    <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-bars"></i>
                <span>Masters</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{route('list.users')}}">Users Registration </a>
                    <a class="collapse-item" href="{{route('list.department')}}">Departments</a>
                    <a class="collapse-item" href="{{route('list.visiting_purpose')}}">Purpose Of Visit</a>
                    <a class="collapse-item" href="{{route('list.pass_for')}}">Pass Made For</a>
                    <a class="collapse-item" href="{{route('list.pass_validity')}}">Pass Validity</a>
                </div>
            </div>
        </li>
    @endif
    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item active">
        <a class="nav-link" href="{{route('entrylist.visitor')}}">
            <i class="fas fa-angle-double-right"></i>
            <span>Visitor Entry</span></a>
    </li>

    @if (auth()->user()->role !== 'staff')
        <li class="nav-item active">
            <a class="nav-link" href="{{route('specialpass')}}">
                <i class="fas fa-ticket-alt"></i>
                <span>Visitor Special Pass</span></a>
        </li>

        <li class="nav-item active">
            <a class="nav-link" href="{{route('pending.special_pass')}}">
                <i class="fas fa-hourglass-half"></i>
                <span>Pending Special Pass</span></a>
        </li>
    @endif

    <li class="nav-item active">
        <a class="nav-link" href="{{route('exitlist.visitor')}}">
            <i class="fas fa-angle-double-left"></i>
            <span>Visitor Exit</span></a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="{{route('exitedlist.visitor')}}">
            <i class="fas fa-angle-double-left"></i>
            <span>Exited Visitor List</span></a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="{{route('term.condition')}}">
            <i class="fas fa-file-contract"></i>
            <span>T & C</span></a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="{{route('password.change')}}">
            <i class="fas fa-unlock-alt"></i>
            <span>Change Password</span></a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="{{route('privacy.policy')}}">
            <i class="fas fa-shield-alt"></i>
            <span>Privacy Policy</span></a>
    </li>

    

    <!-- Heading -->
    {{-- <div class="sidebar-heading">
        Masters
    </div> --}}

    

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <!-- <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Utilities</span> -->
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="utilities-color.html">Colors</a>
                <a class="collapse-item" href="utilities-border.html">Borders</a>
                <a class="collapse-item" href="utilities-animation.html">Animations</a>
                <a class="collapse-item" href="utilities-other.html">Other</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    {{-- <div class="sidebar-heading">
        Addons
    </div> --}}

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        {{-- <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Menu</span>
        </a> --}}
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Login Screens:</h6> -->
                <!-- <a class="collapse-item" href="login.html">Login</a> -->
                <!-- <a class="collapse-item" href="register.html">Register</a> -->
                <!-- <a class="collapse-item" href="forgot-password.html">Forgot Password</a> -->
                <!-- <div class="collapse-divider"></div> -->
                <!-- <h6 class="collapse-header">Other Pages:</h6> -->
                <!-- <a class="collapse-item" href="404.html">404 Page</a> -->
                <!-- <a class="collapse-item" href="blank.html">Blank Page</a> -->
            </div>
        </div>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <!-- <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a> -->
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <!-- <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a> -->
    </li>

    <!-- Divider -->
    {{-- <hr class="sidebar-divider d-none d-md-block"> --}}

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <!-- <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
        <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
    </div> -->

</ul>