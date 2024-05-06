@extends('layouts.app')
@section('content')

<h5 class=" mb-3 font-weight-bold">Product Availability Report</h5>
<div class="container d-flex align-items-start">
  <label for="validationDefault02">Select Branch </label>
  <div class="col-md-4 mb-3 mx-2">
    <select id="branchSelect" class="form-control" name="branch_id" multiple>
      @if(!$branch)
      <option value="">Headquarter</option>
      @endif
      @foreach($offices as $office )
      @if(!$branch)
      <option value="{{$office->id}}">{{$office->name}}</option>
      @else
      @if($office->id==$branch)
      <option value="{{$office->id}} " selected>{{$office->name}}</option>
      @endif
      @endif
      @endforeach
    </select>
  </div>
  <label for="validationDefault02">Select Product</label>
  <div class="col-md-4 mb-3 mx-2">
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
<div class="pagination">


</div>
<script>
  //creatinf function for ajax 
  let branch = @json($branch);
  
function fetch(page=1)

{
 
  //sending all office id in backend if  no branch is selected else sending only the selected one
  let office = [""];
  if(!branch)
  {
  let offices = @json($offices);
  $.each(offices, function(index, obj) {

    office.push(obj.id);
   
  });
}
  let branchId  = $('#branchSelect').val().length>0? $('#branchSelect').val():(branch?branch:office) ;


// console.log(office);
  
    
    $.ajax({

      url:'/reports/product-availability/generate',
      method:'GET',
      data:{
        "branch_id":branchId,
        "page":page,
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
      <th class ="fw-bold"> Quantity</th>
    </tr>
  </thead>

  <tbody class="table-body">

  </tbody>
</table>
`);
        //apending newly fetched data
let count=1;
 $.each(datas, function(index,obj) {
 $('.table-body').append(` <tr class="py-1">

<td class="py-1">
  <p class="fw-bold ms-2 ">${count++}
<td class="py-1">
  <p class=" ">${obj.product_name}</p>
</td>
<td class="py-1">

  <p class="">${obj.total_quantity}</p>
</td>

</tr>`)
});

//adding pagination
// $('.pagination').html(`
//   <div class="d-flex text-lg">
//     ${(() => {
//       let html = '';
//       for (let i = 1; i <= response.datas.totalPages; i++) {
//         html += `
//             <div class="  page-link  border border-primary rounded  ${i == response.datas.page ? "bg-primary text-white" : 'text-primary '} " style="width:30px; text-align:center;  cursor: pointer; " data-page="${i}">
//               ${i}
//             </div>
//         `;
//       }
//       return html;
//     })()}
//   </div>
// `);
      }
      else{

        $('.report-info').html(`<p class="mt-4 ml-4">Products not present!!!!</p>`)
        // $('.pagination').empty();
      }
      },
      error:function(xhr,status,error)
      {
       console.log(xhr);
      }

    });



}

fetch();

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