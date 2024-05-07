@extends('layouts.app')
@section('content')
<div class="error-message ">

</div>
<div>
  <h5 class=" mb-3 font-weight-bold">Product Availability By Warehouse Report</h5>
  <div class="  mb-3 d-flex  ">
    <label for=""> Select Branch:</label>
    <div class="d-flex">
      @if(!$branch)
      <div class="mr-3 ml-2">
        <input type="checkbox" value="" class="branchSelect">Headquarter
      </div>
      @endif
      @foreach($offices as $office )
      @if(!$branch)
      <div class="mr-3  ml-2 ">
        <input type="checkbox" value="{{$office->id}}" class="branchSelect">{{$office->name}}
      </div>
      @else
      @if($office->id==$branch)
      <div class="mr-2 ml-2 ">
        <input type="checkbox" value="{{$office->id}} " class="branchSelect">{{$office->name}}
      </div>
      @endif
      @endif
      @endforeach
    </div>
  </div>

  <div class="container d-flex align-items-start">

    <label for="validationDefault02">Select Warehouse</label>
    <div class="col-md-3 mb-3 ">
      <select id="warehouseSelect" class="form-control" name="warehouse_id">

      </select>
    </div>
    <label for="validationDefault02">Select Product</label>
    <div class="col-md-3 mb-3 ">
      <select id="productSelect" class="form-control" name="product_id">
        @foreach($products as $product )
        <option value="{{$product->id}}">{{$product->name}}</option>
        @endforeach
      </select>
    </div>
    <button id="submit-btn" class="btn btn-success mb-3">Generate</button></a>
  </div>

  <div class="report-info">

  </div>
  <div class="pagination d-flex justify-content-between">


  </div>
  <script>
    //initally checking all
   $(".branchSelect").each(function(){
            $(this).prop("checked", true);
        });

function fetch(page=1)

{
 

  let warehouseId  = $('#warehouseSelect').val();
  let productId  = $('#productSelect').val();
  //getting all checked values

  

    $.ajax({

      url:'/reports/product-availability-warehouse/generate',
      method:'GET',
      data:{
        "warehouse_id":warehouseId,
        "product_id":productId,
        "branch":@json($branch),
        'page':page,
       
      },
      success:function(response){
      
      //create table header 
      let datas =  response.datas.reports;
      

      if(response.datas.reports.length!=0){
       $('.report-info').html(`<table class="table align-middle mb-3 bg-white">
  <thead class="bg-light">
    <tr>
      <th class ="fw-bold">SN</th>
      <th class ="fw-bold">Id</th>
      <th class ="fw-bold">Product </th>
      <th class ="fw-bold">Type </th>
      <th class ="fw-bold">Quantity</th>
      <th class ="fw-bold">Balance </th>
    </tr>
  </thead>

  <tbody class="table-body">

  </tbody>
</table>
`);
    //apending newly fetched data
   
// let count = (response.datas.page - 1) * response.datas.perPage + 1;
let count= (response.datas.page - 1) * response.datas.perPage + 1;
 $.each(datas, function(index,obj) {
 $('.table-body').append(` <tr class="py-1">

<td class="py-1">
  <p class="fw-bold ms-2 ">${count++}</p>
</td>
<td class="py-1">
  <p class=" ">${obj.purchaseSale_id}</p>
</td>
<td class="py-1">
  <p class=" ">${obj.product_name}</p>
</td>
<td class="py-1">
  <p class=" ">${obj.type}</p>
</td>
<td class="py-1">

  <p class="">${obj.quantity}</p>
</td>
<td class="py-1">

<p class="">${obj.balance}</p>
</td>
</tr>`)
});


// adding pagination

if(response.datas.totalPages>1)
{
  
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

      }
      else{

        $('.report-info').html(`<p class="mt-4 ml-4">Product not present in this warehouse!!!!</p>`)
        // $('.pagination').empty();
      }
      },
      error:function(xhr,status,error)
      {
       console.log(xhr);
      }

    });



}

//warehouse option according to selected branch

function getWarehouses()
{

  let branchId=[];
        $(".branchSelect:checked").each(function(){
            
            branchId.push($(this).val());
        });
        // Display the selected values
        console.log(branchId);
      

$.ajax({

url:'/branchs/getwarehouses',
method:'GET',
data:{
 
  "branch_id":branchId,
 
},

success:function(response){
  console.log(response);
  $("#warehouseSelect").empty();
  $.each(response.warehouses, function(index, warehouse) {
     $("#warehouseSelect").append(`<option value="${warehouse.id}">${warehouse.name} </option>`);
       });

  
},
error:function(xhr,status,error)
{
 console.log(xhr);
}

});
}
getWarehouses();

//Initally showing all products
// fetch();

//call function when checkbox selection is changed
$(".branchSelect").change(function() {
    
    //at least one should be checked
    if ($(".branchSelect:checked").length === 0) {
        $(this).prop("checked", true);
    }
    getWarehouses();
});



  $('#submit-btn').on('click',function(){


    
    if ($('.report-info table tbody tr').length > 0) {

      $('.tbody').empty();
      
    }
    $('.pagination').fadeOut().empty().fadeIn();
   fetch();  
   

});


// handling pagination
$('.pagination').on('click', '.page-link', function() {
  let page = $(this).data('page');
  fetch(page);
});
  

  </script>

  @endsection