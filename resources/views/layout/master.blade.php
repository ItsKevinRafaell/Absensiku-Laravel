<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Absensi Siswa</title>

  <!-- Custom fonts for this template-->
  <link href="assets/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../../assets/admin/css/sb-admin-2.min.css" rel="stylesheet">

  <style>
    .bg-gradient-primary {
      background-color: #37517e;
      background-image: linear-gradient(180deg,#6d56cb 10%,#b751c2 100%);
      background-size: cover;
    }
    .shadow {
      box-shadow: 0 .15rem .6rem 0 rgba(58,59,69,.15)!important;
    }
    .mb-4, .my-4 {
      margin-bottom: 2.7rem!important;
    }
    nav {
      background-color: #6d56cb;
    }
    .fa-user-circle {
      color: #6d56cb;
    }

    .pagination{
      background-color: #F8F9FC;
      border-radius: 0px;
    }
  </style>
  <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
  <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>



</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-text mx-3">Absensi Siswa</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Home
      </div>

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="/dashboard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Data
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url()->previous() }}" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Data Dasar</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ url('data-absen') }}">Data Absen</a>
            <a class="collapse-item" href="{{ url('siswa') }}">Data Siswa</a>
            <a class="collapse-item" href="{{ url('guru') }}">Data Guru</a>
          </div>
        </div>
           <li class="nav-item">
            @if(auth()->user()->role_id != 1)
            <a class="nav-link" href="{{url('profile', auth()->user()->id)}}" >
                <i class="fas fa-user fa-sm fa-fw mb-2"></i>
                <span>Profile</span>
            </a>
            @endif
        </li>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Actions
      </div>

      <!-- Nav Item - Login -->
      <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>{{ __('Logout') }}</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      @if(request()->is('guru') || request()->is('siswa') || request()->is('data-absen') || request()->is('dashboard'))
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
      @endif

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

        <!-- Sidebar Toggle (Topbar) -->       
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-search fa-fw"></i>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                    aria-labelledby="searchDropdown">
                    <form class="form-inline mr-auto w-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small"
                                placeholder="Search for..." aria-label="Search"
                                aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <!-- <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-3 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                    <i class="fas fa-user-circle"></i>
                </a> -->
                <!-- Dropdown - User Information -->
                <!-- <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="userDropdown">
                    @if(Auth::user()->role_id != 1)
                    <a class="dropdown-item" href=" {{url('profile', auth()->user()->id)}}">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    @endif
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li> -->
        </ul>

        </nav>
        <!-- End of Topbar -->

        <div class="container">
          <section class="content">
            @yield('content')
          </section>
        </div>
      </div>

      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white shadow">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; by Kevin Rafael
              <script>
                document.write(new Date().getFullYear())
              </script>
            </span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="#" data-target="#logoutModal" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
        </div>
      </div>
    </div>
  </div>


  <!-- Bootstrap core JavaScript-->
  <!-- <script src="assets/admin/vendor/jquery/jquery.min.js"></script>
  <script src="assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
  <!-- <script src="{{ asset('assets/admin/vendor/jquery/jquery.min.js') }}"></script> -->
  <script src="{{ asset('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>


  <!-- Core plugin JavaScript-->
  <!-- <script src="assets/admin/vendor/jquery-easing/jquery.easing.min.js"></script> -->
  <!-- <script src="{{ asset('assets/admin/vendor/jquery-easing/jquery.easing.min.j') }}"></script> -->


  <!-- Custom scripts for all pages-->
  <!-- <script src="assets/admin/js/sb-admin-2.min.js"></script> -->
  <script src="{{ asset('assets/admin/js/sb-admin-2.min.js') }}"></script>


  <!-- Page level plugins -->
  <script src="assets/admin/vendor/chart.js/Chart.min.js"></script>
  <script src="{{ asset('assets/admin/vendor/chart.js/Chart.min.js') }}"></script>


  <!-- Page level custom scripts -->
  <!-- <script src="assets/admin/js/demo/chart-area-demo.js"></script>
  <script src="assets/admin/js/demo/chart-pie-demo.js"></script> -->
  <script src="{{ asset('assets/admin/js/demo/chart-area-demo.js') }}"></script>
  <script src="{{ asset('assets/admin/js/demo/chart-pie-demo.js') }}"></script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>
