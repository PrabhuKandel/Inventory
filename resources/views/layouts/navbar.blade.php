<nav id="main-navbar" class="navbar navbar-expand-lg navbar-light  fixed-top" style="background:#3a4750">
  <!-- Container wrapper -->
  <div class="container-fluid  d-flex justify-content-between">
    <!-- Toggle button -->
    <button class="navbar-toggler" type="button" data-mdb-collapse-init data-mdb-target="#sidebarMenu"
      aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Brand -->
    <a class="navbar-brand "
      href="{{ isset($branch) && $branch ? '/branchs/' . $branch . '/dashboards' : '/dashboards' }}"
      style="margin-left: 1.5rem; color:white;">

      <i class="fa-solid fa-house "></i>

    </a>
    <div class="d-none d-md-flex input-group w-auto my-auto">
      <h4 style="color:white">Inventory Management System</h4>

    </div>
    <!-- Search form -->

    <!-- Right links -->
    <ul class="navbar-nav  ">
      <!-- Avatar -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center" {{-- href="#" --}}
          id="avatarDropdownMenuLink" role="button" data-mdb-dropdown-init data-mdb-ripple-init aria-expanded="false">
          <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img (31).webp" class="rounded-circle" height="22"
            alt="Avatar" loading="lazy" />
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="avatarDropdownMenuLink">
          <li>
            <a class="dropdown-item" href="#">My profile</a>
          </li>
          <li>
            <a class="dropdown-item" href="#">Settings</a>
          </li>
          <li>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="dropdown-item">Logout</button>
            </form>
          </li>
        </ul>
      </li>
    </ul>
  </div>
  <!-- Container wrapper -->
</nav>
<!-- Navbar -->