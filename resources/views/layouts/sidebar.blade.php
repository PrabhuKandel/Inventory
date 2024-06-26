<!-- Sidebar -->

@php($branches = \App\Models\Office::all());

@php($headquater = isset($branch) && $branch ? false : true)
<nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse ">
  <div class="position-sticky ">
    <div class="list-group list-group-flush mx-3 mt-4 ">
      <a href="{{ isset($branch) && $branch ? '/branchs/' . $branch . '/dashboards' : '/dashboards' }}"
        class="list-group-item list-group-item-action py-2 ripple " aria-current="true">
        <i class="fas fa-tachometer-alt fa-fw me-3 "></i><span>Main dashboard</span>
      </a>
      @if ($headquater)
      <a href="{{ route('branchs.index') }}" class="list-group-item list-group-item-action py-2 ripple "
        aria-current="true">
        <i class="fa-solid fa-plus fa-fw me-3"></i><span>Create Branch</span>
      </a>
      @endif

      <div class="dropdown">
        <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          @if (isset($branch) && $branch)
          @php($branch_name = \App\Models\Office::find($branch)->name)
          {{ $branch_name }}
          @else
          Headquarter
          @endif
        </button>


        @if (Auth::user()->hasRole('Super Admin') ||
        Auth::user()->hasRole('Headquarter Admin') ||
        Auth::user()->hasRole('Headquarter User'))
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          @if(isset($branch)&&$branch)
          <a class="dropdown-item" id="headquarter" href="{{ route('dashboards.main', '') }}">Headquarter</a>
          @endif
          @if (isset($branch) && !$branch)
          @foreach ($branches as $branch1)
          <a class="dropdown-item" id="branch" href="{{ route('dashboards.branch', $branch1->id) }}">{{ $branch1->name
            }}</a>
          @endforeach
          @endif
        </div>
        @endif
        <script>
          const dropdownItems = document.querySelectorAll('.dropdown-item');
                    dropdownItems.forEach(item => {
                        item.addEventListener('click', function(event) {
                            event.preventDefault();

                            window.location.href = this.getAttribute('href');
                        });
                    });
        </script>
      </div>



      <a href="{{ isset($branch) && $branch ? '/branchs/' . $branch . '/warehouses' : '/warehouses' }}"
        class="list-group-item list-group-item-action py-2 ripple "><i
          class="fa-solid fa-warehouse fa-fw me-3 "></i><span>Warehouse</span></a>

      <a href="{{ isset($branch) && $branch ? '/branchs/' . $branch . '/contacts' : '/contacts' }}"
        class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-calendar fa-fw me-3"></i><span>
          Contact</span></a>

      @if ($headquater)
      <a href="{{ isset($branch) && $branch ? '/branchs/' . $branch . '/users' : '/users' }}"
        class="list-group-item list-group-item-action py-2 ripple"><i class="fa-solid fa-user fa-fw me-3"></i><span>Add
          Users</span></a>
      @endif

      @if ($headquater)
      <a href="{{ isset($branch) && $branch ? '/branchs/' . $branch . '/categories' : '/categories' }}"
        class="list-group-item list-group-item-action py-2 ripple"><i
          class="fa-solid fa-list fa-fw me-3"></i><span>Category</span></a>
      @endif
      @can('view-unit')
      <a href="{{ isset($branch) && $branch ? '/branchs/' . $branch . '/units' : '/units' }}"
        class="list-group-item list-group-item-action py-2 ripple"><i
          class="fa-solid fa-list fa-fw me-3"></i><span>Unit</span></a>
      @endcan

      <a href="{{ isset($branch) && $branch ? '/branchs/' . $branch . '/products' : '/products' }}"
        class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-chart-line fa-fw me-3"></i><span>
          Products</span></a>
      <a href="{{ isset($branch) && $branch ? '/branchs/' . $branch . '/purchases' : '/purchases' }}"
        class="list-group-item list-group-item-action py-2 ripple"><i
          class="fa-solid fa-cart-shopping fa-fw me-3"></i><span>Purchase</span></a>
      <a href="{{ isset($branch) && $branch ? '/branchs/' . $branch . '/sales' : '/sales' }}"
        class="list-group-item list-group-item-action py-2 ripple"><i
          class="fas fa-chart-line fa-fw me-3"></i><span>Sell</span></a>


      @if ($headquater)
      <a href="{{ route('roles.index') }}" class="list-group-item list-group-item-action py-2 ripple"><i
          class="fas fa-users fa-fw me-3"></i><span>Roles</span></a>
      @endif


      <a href="{{ isset($branch) && $branch ? '/branchs/' . $branch . '/reports' : '/reports' }}"
        class="list-group-item list-group-item-action py-2 ripple"><i
          class="fas fa-money-bill fa-fw me-3"></i><span>Reports</span></a>
    </div>
  </div>
</nav>
{{-- to add active class on links where user click --}}

<script>
  // $(document).ready(function() {
  //       $('.list-group-item-action').click(function() {
  //           // $('.list-group-item-action').removeClass('active');
  //           $(this).addClass('active');
  //       });
  //   });
</script>