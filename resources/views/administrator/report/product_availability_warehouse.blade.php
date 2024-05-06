@extends('layouts.app')
@section('content')
<div class="error-message ">

</div>
<div class="container d-flex align-items-start">
  <label for="validationDefault02">Select Warehouse</label>
  <div class="col-md-4 mb-3 mx-2">
    <select id="warehouseSelect" class="form-control" name="warehouse_id" multiple>
      @foreach($warehouses as $warehouse )
      <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
      @endforeach
    </select>
  </div>
  <label for="validationDefault02">Select Product</label>
  <div class="col-md-4 mb-3 mx-2">
    <select id="productSelect" class="form-control" name="product_id" multiple>
      @foreach($products as $product )
      <option value="{{$product->id}}">{{$product->name}}</option>
      @endforeach
    </select>
  </div>
  <button id="submit-btn" class="btn btn-success mb-3">Generate</button></a>
</div>

<div class="report-info">

</div>
<div class="pagination">


</div>
<script>
  //creatinf function for ajax 
//Initally showing all products
  fetch();
function fetch()

{
 

  let warehouseId  = $('#warehouseSelect').val();
  let productId  = $('#productSelect').val();

    $.ajax({

      url:'/reports/product-availability-warehouse/generate',
      method:'GET',
      data:{
        "warehouse_id":warehouseId,
        "product_id":productId,
        "branch_id":@json($branch),
      },
      success:function(response){
        console.log(response);
      //create table header 
      let datas =  response.datas.reports;

      if(response.datas.reports.length!=0){
       $('.report-info').html(`<table class="table align-middle mb-3 bg-white">
  <thead class="bg-light">
    <tr>
      <th class ="fw-bold">SN</th>
      <th class ="fw-bold">Product </th>
      <th class ="fw-bold">Quantity</th>
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
  <p class="fw-bold ms-2 ">${1}</p>
</td>
<td class="py-1">
  <p class=" ">${obj.product_name}</p>
</td>

<td class="py-1">

  <p class="">${obj.total_quantity}</p>
</td>

</tr>`)
});

      }
      else{

        $('.report-info').html(`<p class="mt-4 ml-4">No Data Found!!!!</p>`)
        // $('.pagination').empty();
      }
      },
      error:function(xhr,status,error)
      {
       console.log(xhr);
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
// $('.pagination').on('click', '.page-link', function() {

//   let page = $(this).data('page');
//   fetch(page);
// });

</script>

@endsection