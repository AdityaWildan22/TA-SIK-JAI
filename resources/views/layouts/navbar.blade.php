  <!-- Topbar -->
  <nav class="navbar navbar-expand navbar-light bg-primary topbar mb-4 static-top shadow">
      <!-- Sidebar Toggle (Topbar) -->
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
          <i class="fa fa-bars" style="color: #fff"></i>
      </button>
      <!-- Topbar Navbar -->
      <ul class="navbar-nav ml-auto">

          <!-- Nav Item - User Information -->
          <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <span class="mr-2 d-none d-lg-inline text-light-600 small"
                      style="color: #fff">{{ Auth::user()->nama }}</span>
                  <img class="img-profile rounded-circle" src="{{ asset('img/undraw_profile.svg') }}">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                  <a class="dropdown-item" href="#">
                      <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                      <form class="d-inline-block" method="POST" action="{{ route('logout') }}">
                          @csrf
                          <button type="submit" style="border:none;background-color:#fff">Logout</button>
                      </form>
                  </a>
              </div>
          </li>

      </ul>
  </nav>
  <!-- End of Topbar -->
