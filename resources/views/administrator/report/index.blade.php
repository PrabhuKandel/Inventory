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
      @if(!$branch)
      <option value="all">All</option>
      <option value="" selected>Headquarter</option>
      @endif
      @foreach($offices as $office )
      @if(!$branch)
      <option value="{{$office->id}}">{{$office->name}}</option>
      @else
      @if($office->id==$branch)
      <option value="{{$office->id}}" selected>{{$office->name}}</option>
      @endif
      @endif
      @endforeach
    </select>

  </div>

  <label for="validationDefault02">Transcation Type </label>
  <div class="col-md-4 mb-3 mx-2">
    <select id="transcationSelect" class="form-control" name="type">

      <option value="in" selected>Purchase </option>
      <option value="out">Sale </option>
      <option value="all">Both</option>

    </select>
  </div>
  <button id="submit-btn" class="btn btn-success mb-3">Submit</button></a>
</div>

<div class="report-info">

</div>
<div class="pagination">


</div>
<script>
  //creatinf function for ajax 
function fetch(page=1)

{
 

  let branchId = $('#branchSelect').val();
  let transcation = $('#transcationSelect').val();
    
    $.ajax({

      url:'/reports',
      method:'GET',
      data:{
        "branch_id":branchId,
        "transaction_type":transcation,
        "page":page,
      },
      success:function(response){
      //create table header 
      let datas =  response.datas.reports;

      if(response.datas.reports.length!=0){
       $('.report-info').html(`<table class="table align-middle mb-3 bg-white">
  <thead class="bg-light">
    <tr>
      <th> Transcation ID</th>
      <th>Product </th>
      <th>Warehouse</th>
      <th>Quantity</th>
      <th>Amount</th>
      <th>Contact</th>
      <th>Transcated By</th>
      <th>Date</th>
    </tr>
  </thead>

  <tbody class="table-body">

  </tbody>
</table>
`);
        //apending newly fetched data

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

//adding pagination
$('.pagination').html(`
  <div class="d-flex text-lg">
    ${(() => {
      let html = '';
      for (let i = 1; i <= response.datas.totalPages; i++) {
        html += `
            <div class="  page-link  border border-primary rounded  ${i == response.datas.page ? "bg-primary text-white" : 'text-primary '} " style="width:30px; text-align:center;  cursor: pointer; " data-page="${i}">
              ${i}
            </div>
        `;
      }
      return html;
    })()}
  </div>
`);
      }
      else{

        $('.report-info').html(`<p class="mt-4 ml-4">No Data Found!!!!</p>`)
      }
      },
      error:function(xhr,status,error)
      {
       alert("Error");
      }

    });



}

  $('#submit-btn').on('click',function(){

    //remove previous row
    if ($('.report-info table tbody tr').length > 0) {

      $('.tbody').empty();

    }
  fetch();

});
  

//handling pagination
$('.pagination').on('click', '.page-link', function() {

  let page = $(this).data('page');
  fetch(page);
});

</script>

@endsection