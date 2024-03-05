   <!-- Sidebar -->
   <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

       <!-- Sidebar - Brand -->
       <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
           <div class="sidebar-brand-icon rotate-n-15">

               {{-- <img src="{{ asset('img/undraw_profile.svg') }}" alt=""> --}}
           </div>
           <div class="sidebar-brand-text mx-3" style="font-size: 15px">Sistem Informasi Kepegawaian <sup>V.1.0</sup>
           </div>
       </a>

       <!-- Divider -->
       <hr class="sidebar-divider my-0">

       <!-- Nav Item - Dashboard -->
       <li class="nav-item active">
           <a class="nav-link" href="{{ url('') }}">
               <i class="fas fa-home"></i>
               <span>Dashboard</span></a>
       </li>

       <!-- Divider -->
       <hr class="sidebar-divider">

       <!-- Heading -->
       <div class="sidebar-heading">
           DATA
       </div>

       <!-- Nav Item - Pages Collapse Menu -->
       @if (Auth::check())
           @if (Auth::user()->role == 'SuperAdmin')
               <li class="nav-item">
                   <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                       aria-expanded="true" aria-controls="collapseTwo">
                       <i class="fas fa-users"></i>
                       <span>Data Karyawan</span>
                   </a>
                   <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                       <div class="bg-white py-2 collapse-inner rounded">
                           <a class="collapse-item" href="{{ url('/karyawan') }}">Data Karyawan</a>
                           <a class="collapse-item" href="{{ url('/karyawan/create    ') }}">Form Karyawan</a>
                       </div>
                   </div>
               </li>

               <li class="nav-item">
                   <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1"
                       aria-expanded="true" aria-controls="collapseTwo1">
                       <i class="fas fa-building"></i>
                       <span>Data Departemen</span>
                   </a>
                   <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                       <div class="bg-white py-2 collapse-inner rounded">
                           <a class="collapse-item" href="{{ url('/departemen') }}">Data Departemen</a>
                       </div>
                   </div>
               </li>

               <li class="nav-item">
                   <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2"
                       aria-expanded="true" aria-controls="collapseTwo2">
                       <i class="fas fa-list"></i>
                       <span>Data Jabatan</span>
                   </a>
                   <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                       <div class="bg-white py-2 collapse-inner rounded">
                           <a class="collapse-item" href="{{ url('/jabatan') }}">Data Jabatan</a>
                       </div>
                   </div>
               </li>
           @endif
       @endif
       <!-- Nav Item - Utilities Collapse Menu -->
       <li class="nav-item">
           <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
               aria-expanded="true" aria-controls="collapseUtilities">
               <i class="fas fa-calendar"></i>
               <span>Data Absensi</span>
           </a>
           <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
               data-parent="#accordionSidebar">
               <div class="bg-white py-2 collapse-inner rounded">
                   <a class="collapse-item" href="{{ url('/absensi') }}">Data Absensi</a>
                   <a class="collapse-item" href="{{ url('/absensi/create    ') }}">Form Absensi</a>
               </div>
           </div>
       </li>

       <!-- Nav Item - Pages Collapse Menu -->
       <li class="nav-item">
           <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
               aria-expanded="true" aria-controls="collapsePages">
               <i class="fas fa-fw fa-clock"></i>
               <span>Data Overtime</span>
           </a>
           <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
               <div class="bg-white py-2 collapse-inner rounded">
                   <a class="collapse-item" href="{{ url('/overtime') }}">Data Overtime</a>
                   <a class="collapse-item" href="{{ url('/overtime/create') }}">Form Overtime</a>
               </div>
           </div>
       </li>
       @if (Auth::check())
           @if (Auth::user()->role == 'SuperAdmin' || Auth::user()->role == 'Admin')
               <li class="nav-item">
                   <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages2"
                       aria-expanded="true" aria-controls="collapsePages2">
                       <i class="fas fa-book"></i>
                       <span>Laporan</span>
                   </a>
                   <div id="collapsePages2" class="collapse" aria-labelledby="headingPages"
                       data-parent="#accordionSidebar">
                       <div class="bg-white py-2 collapse-inner rounded">
                           <a class="collapse-item" href="{{ url('/report') }}">Data Laporan</a>
                       </div>
                   </div>
               </li>
           @endif
       @endif
       <!-- Divider -->
       <hr class="sidebar-divider">

       <!-- Heading -->
       <div class="sidebar-heading">
           Setting
       </div>
       <li class="nav-item">
           <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKelas"
               aria-expanded="true" aria-controls="collapseKelas">
               <i class="fas fa-fw fa-user"></i>
               <span>Profil</span>
           </a>
           <div id="collapseKelas" class="collapse" aria-labelledby="headingKelas" data-parent="#accordionSidebar">
               <div class="bg-white py-2 collapse-inner rounded">
                   <a class="collapse-item" href="{{ url('/profil') }}">Data Profil</a>
               </div>
           </div>
       </li>

       <!-- Divider -->
       <hr class="sidebar-divider d-none d-md-block">

       <!-- Sidebar Toggler (Sidebar) -->
       <div class="text-center d-none d-md-inline">
           <button class="rounded-circle border-0" id="sidebarToggle"></button>
       </div>



   </ul>
   <!-- End of Sidebar -->
