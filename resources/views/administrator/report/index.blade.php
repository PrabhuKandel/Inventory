@extends('layouts.app')
@section('content')

@if($message = Session::get('success'))
<div id="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif
<div class="container d-flex">
  <label for="validationDefault02">Select Branch </label>
  <div class="col-md-4 mb-3 mx-2">
    <select id="branchSelect" class="form-control" name="branch_id">
      <option value="all">All</option>
      <option value="" selected>Headquarter</option>
      @foreach($offices as $office )
      <option value="{{$office->id}}">{{$office->name}}</option>
      @endforeach

    </select>

  </div>

  <label for="validationDefault02">Transcation Type </label>
  <div class="col-md-4 mb-3 mx-2">
    <select id="transcationSelect" class="form-control" name="type">

      <option value="in" selected>Purchase </option>
      <option value="out">Sale </option>
      <option value="both">Both</option>

    </select>
  </div>
  <button id="submit-btn" class="btn btn-success mb-3">Submit</button></a>
</div>




<table class="table align-middle mb-3 bg-white">
  <thead class="bg-light">
    <tr>
      <th> Transcation ID</th>
      <th>Product </th>
      <th>Warehouse</th>
      <th>Quantity</th>
      <th>Amount</th>
      <th>Contact</th>
      <th>User</th>
      <th>Date</th>
    </tr>
  </thead>
  @php

  $count = ($page - 1) * $perPage + 1;
  @endphp

  <tbody class="table-body">

    @foreach ($reports as $report )

    @php
    $count++;
    @endphp
    <tr class="py-1">

      <td class="py-1">
        <p class="fw-bold ms-2 ">{{$report->id}}</p>
      </td>
      <td class="py-1">
        <p class=" ">{{$report->product_name}}</p>
      </td>
      <td class="py-1">

        <p class=" ">{{$report->warehouse_name}}</p>
      </td>

      <td class="py-1">

        <p class="">{{$report->quantity}}</p>
      </td>
      <td class="py-1">

        <p class=" ">{{$report->amount}}</p>

      </td>
      <td class="py-1">

        <p class=" ">{{$report->contact_name}}</p>

      </td>
      <td class="py-1">
        <p class=" ">{{$report->user_name}}</p>
      </td>
      <td class="py-1">
        <p class="">{{$report->created_date}}</p>
      </td>
      @endforeach
    </tr>

  </tbody>
</table>
<div class="report-info">


</div>

@if($total)

<div class="pagination d-flex justify-content-between">
  <div>
    @php
    $start = ($page - 1) * $perPage+1;
    @endphp
    Showing <span class="start">{{$start}}</span> to <span class="end">{{$count-1}}</span> of <span
      class="total">{{$total}}</span> results
  </div>
  <div class=" d-flex  text-lg ">
    @for ($i = 1; $i <= $totalPages; $i++) <a style="" href=" {{ request()->fullUrlWithQuery(['page' => $i]) }}"
      class="{{ $i == $page ? 'bg-primary text-white' : '' }}">
      <div class="border border-primary rounded" style="width:30px; text-align:center; ">
        {{ $i }}
      </div>
      </a>
      @endfor
  </div>
</div>
@endif


<script>
  $('#submit-btn').on('click',function(){

    //remove previous row
    $('.table-body').fadeOut(function() {
    $(this).empty().fadeIn();
});
//remove previous pagination
$('.pagination').remove();

    let branchId = $('#branchSelect').val();
    let transcation = $('#transcationSelect').val();
    
    $.ajax({

      url:'/reports',
      method:'GET',
      data:{
        "branch_id":branchId,
        "transaction_type":transcation,
      },
      success:function(response){

      
        //apending newly fetched data
        let datas =  response.datas.reports;
        console.log(response.datas);


        $.each(datas, function(index,obj) {
          

      
        $('.table-body').append(` <tr class="py-1">

<td class="py-1">
  <p class="fw-bold ms-2 ">${obj.id}</p>
</td>
<td class="py-1">
  <p class=" ">${obj.product_name}</p>
</td>
<td class="py-1">

  <p class=" ">${obj.warehouse_name}</p>
</td>

<td class="py-1">

  <p class="">${obj.quantity}</p>
</td>
<td class="py-1">

  <p class=" ">${obj.amount}</p>

</td>
<td class="py-1">

  <p class=" ">${obj.contact_name}</p>

</td>
<td class="py-1">
  <p class=" ">${obj.user_name}</p>
</td>
<td class="py-1">
  <p class="">${obj.created_date}</p>
</td>

</tr>`)
});

//pagination
$('.start').val();
$('.end').val();
$('.total').val();



      },
      error:function(xhr,status,error)
      {

      }

    });

  })
</script>

@endsection