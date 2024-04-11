  <!-- Sidebar -->
{{-- @php
  $branch = explode("/",  $request->route()->uri)[0]=='branchs' && isset($request->route()->parameters['id'])?$request->route()->parameters['id']:false;
  @endphp --}}
  @php( $branches=(\App\Models\Office::all()));

  @php($headquater=isset($branch) && $branch ?true:false )
  <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
    <div class="position-sticky">
      <div class="list-group list-group-flush mx-3 mt-4">
        <a
          href="{{route('dashboards.index')}}"
          class="list-group-item list-group-item-action py-2 ripple "
          aria-current="true"
        >
          <i class="fas fa-tachometer-alt fa-fw me-3 "></i><span>Main dashboard</span>
        </a>
        {{-- <a href="{{route('branchs.index')}}" class="list-group-item list-group-item-action py-2 ripple ">
          <i class="fas fa-chart-area fa-fw me-3"></i><span>
    
            @if (isset($branch) && $branch)
              @php($branch_name=(\App\Models\Office::find($branch))->name)
              {{$branch_name}}
              @else
              Headquarter 
            @endif          
          </span>
        </a> --}}

        {{-- dropdown to go to branch --}}
     

        <select id="inputState" class="form-control" name="branch" onchange="navigateToRoute(this)">
          @foreach ($branches as $branch)
              <option value="{{ route('branchs.show', $branch->id) }}" >
                  {{ $branch->type == 'headquarter' ? 'Headquarter' : $branch->name }}
              </option>
          @endforeach
      </select>
          <script>
            function navigateToRoute(selectElement) {
                // Get the selected option's value (i.e., the route URL)
                let selectedRoute = selectElement.value;
                
                // Navigate to the selected route
                window.location.href = selectedRoute;
            }
        </script>
    

        <a href="{{ (isset($branch) && $branch) ? '/branchs/'.$branch.'/warehouses': '/warehouses' }}"  class="list-group-item list-group-item-action py-2 ripple"
          ><i class="fas fa-chart-bar fa-fw me-3"></i><span>Warehouse</span></a
        >
        {{-- <a href="{{ (isset($branch) && $branch) ? '/branchs/'.$branch.'/users': '/users' }}"  class="list-group-item list-group-item-action py-2 ripple"
        ><i class="fas fa-chart-bar fa-fw me-3"></i><span>Users</span></a> --}}
        {{-- {route('contacts.index')}} --}}
        <a href="{{(isset($branch) && $branch?'/branchs/'.$branch.'/contacts':'/contacts')}}" class="list-group-item list-group-item-action py-2 ripple"
        ><i class="fas fa-calendar fa-fw me-3"></i><span>
          Contact</span></a>
          
          @if (!$headquater)
          <a href="{{route('users.index')}}" class="list-group-item list-group-item-action py-2 ripple"
          ><i class="fas fa-lock fa-fw me-3"></i><span>Add Users</span></a
        >
          @endif

          @if (!$headquater)
          <a href="{{route('categories.index')}}" class="list-group-item list-group-item-action py-2 ripple"
          ><i class="fas fa-globe fa-fw me-3"></i><span>Category</span></a>
     
          @endif
    @if (!$headquater)
    <a href="{{route('units.index')}}" class="list-group-item list-group-item-action py-2 ripple"
    ><i class="fas fa-building fa-fw me-3"></i><span>Unit</span></a>
    @endif
{{-- 
        <a href="{{ (isset($branch) && $branch) ? '/branchs/'.$branch.'/products': '/products' }}" class="list-group-item list-group-item-action py-2 ripple"
        ><i class="fas fa-building fa-fw me-3"></i><span>Products</span></a> --}}
          <a href="{{(isset($branch) && $branch?'/branchs/'.$branch.'/products':'/products')}}" class="list-group-item list-group-item-action py-2 ripple"
          ><i class="fas fa-chart-line fa-fw me-3"></i><span> Products</span></a
        >
        <a href="{{ (isset($branch) && $branch) ? '/branchs/'.$branch.'/purchasesdetails': '/purchasesdetails' }}" class="list-group-item list-group-item-action py-2 ripple"
        ><i class="fas fa-chart-line fa-fw me-3"></i><span>Purchase</span></a
      >
        <a href="{{ (isset($branch) && $branch) ? '/branchs/'.$branch.'/salesdetails': '/salesdetails' }}" class="list-group-item list-group-item-action py-2 ripple"
        ><i class="fas fa-chart-line fa-fw me-3"></i><span>Sell</span></a
      >

       
 @if (!$headquater)
 <a href="" class="list-group-item list-group-item-action py-2 ripple"
 ><i class="fas fa-users fa-fw me-3"></i><span>Roles</span></a
> 
 @endif
        

        <a href="#" class="list-group-item list-group-item-action py-2 ripple"
          ><i class="fas fa-money-bill fa-fw me-3"></i><span>Reports</span></a
        >
      </div>
    </div>
  </nav>
  {{-- to add active class on links where user click --}}
