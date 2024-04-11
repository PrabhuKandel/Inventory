@extends('layouts.app')
@section('content')
<h4 class="mb-2">Select Branch to see Products of respective branch</h4>


<div class="row row-cols-4">

<div class="col">
  <a href="{{route('viewproducts.show',1)}}" class=" rounded btn   btn-dark px-2 pb-1 pt-1 mr-2 " >Branch 1</a>
</div>
<div class="col">
  <a href="{{route('viewproducts.show',2)}}" class=" rounded btn  btn-dark px-2 pb-1 pt-1 mr-2 " >Branch 2</a>
</div>
 
<div class="col">
  <a href="{{route('viewproducts.show',3)}}" class=" rounded btn  btn-dark px-2 pb-1 pt-1 mr-2 " >Branch 3</a>
</div>
 
<div class="col">
  <a href="{{route('viewproducts.show',4)}}" class=" rounded btn  btn-dark px-2 pb-1 pt-1 mr-2 " >Branch 4</a>
</div>
 



</div>
@endsection