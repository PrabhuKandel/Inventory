<nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
  <!-- Container wrapper -->
  <div class="container-fluid  d-flex justify-content-center">
    <!-- Toggle button -->
    <button class="navbar-toggler" type="button" data-mdb-collapse-init data-mdb-target="#sidebarMenu"
    aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fas fa-bars"></i>
  </button>

    <!-- Brand -->
    <a class="navbar-brand " href="#"  style="margin-left: 1.5rem;">
  
        <i class="fa-solid fa-house "></i> 
      
    </a>
    <!-- Search form -->
    <form class="d-none d-md-flex input-group w-auto my-auto">
      <input
        autocomplete="off"
        type="search"
        class="form-control rounded"
        placeholder='Search (ctrl + "/" to focus)'
        style="min-width: 225px;"
      />
      <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
    </form>

    <!-- Right links -->
    <ul class="navbar-nav ms-auto d-flex flex-row">
      <!-- Notification dropdown -->
      <li class="nav-item dropdown">
        <a
          class="nav-link me-3 me-lg-0 dropdown-toggle hidden-arrow"
          href="#"
          id="navbarDropdownMenuLink"
          role="button"
          data-mdb-dropdown-init
          data-mdb-ripple-init
          aria-expanded="false"
        >
          <i class="fas fa-bell"></i>
          <span class="badge rounded-pill badge-notification bg-danger">1</span>
        </a>
        <ul
          class="dropdown-menu dropdown-menu-end"
          aria-labelledby="navbarDropdownMenuLink"
        >
          <li>
            <a class="dropdown-item" href="#">Some news</a>
          </li>
          <li>
            <a class="dropdown-item" href="#">Another news</a>
          </li>
          <li>
            <a class="dropdown-item" href="#">Something else here</a>
          </li>
        </ul>
      </li>

    

 

      <!-- Avatar -->
      <li class="nav-item dropdown">
        <a
          class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center"
          {{-- href="#" --}}
          id="avatarDropdownMenuLink"
          role="button"
          data-mdb-dropdown-init
          data-mdb-ripple-init
          aria-expanded="false"
        >
          <img
            src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img (31).webp"
            class="rounded-circle"
            height="22"
            alt="Avatar"
            loading="lazy"
          />
        </a>
        <ul
          class="dropdown-menu dropdown-menu-end"
          aria-labelledby="avatarDropdownMenuLink"
        >
          <li>
            <a class="dropdown-item" href="#">My profile</a>
          </li>
          <li>
            <a class="dropdown-item" href="#">Settings</a>
          </li>
          <li>
            <form action="" method="POST">
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