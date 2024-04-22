@extends('layouts.app')
@section('content')
@if($message = Session::get('success'))
<div id ="success-message" class="alert alert-success alert-block">
  <strong> {{ $message}}</strong>
</div>
@endif
@if ($errors->any())
<div class="  alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="form-container mb-5">
<form id="myForm" class="purchase-form" action="{{$branch?'/branchs/'.$branch.'/sellproducts':'/sellproducts'}}"  method="POST">
  @csrf



  <div class="form-group-row d-flex justify-content-start">
    <div class=" form-group col-md-2 ml-0   ">
      <label for="validationDefault02">Date</label>
      <input type="date"  class="form-control   date" name="created_date" pattern="" required>
      </div>
  </div>
  <table class="table">
    <thead>
      <th>Customer</th>
      <th>Product</th>
      <th>Warehouse</th>
      <th style="width:10%">Unit</th>
      <th style="width:10%">Rate</th>
      <th style="width:10%">Availability</th>
      <th>Quantity</th>
      <th>Total (Rs)</th>
    </tr>
    </thead>

    <tbody class="more-form ">
      <tr>
        <td>
          <select id="inputState" class="form-control " name='contact_id[]'>
            <option selected value="" >Choose Customer...</option>
           @foreach ($customers as $customer )
           <option value="{{$customer->id}}">{{$customer->name}}</option>
           @endforeach
          </select>
        </td>
        <td>
          <select id="inputProduct"  class="form-control selectProduct" name="product_id[]">
            <option selected value="">Choose...</option>
            @foreach($products as $product)
    
        
            <option value="{{$product->id}}"  rate="{{$product->rate}}"   unit="{{$product->unit->name}}">{{$product->name}}</option>
    @endforeach
    
          </select>
        </td>
        <td>
          <select  class="form-control inputWarehouse" name="warehouse_id[]">
            <option selected value="">Select Warehouse...</option>
         @foreach ($warehouses as $warehouse )
           
         <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
         @endforeach
    
          </select>
        </td>

        <td>
          <input type="text" class="form-control productunit"  name="unit[]" readonly>
        </td>
        <td>

          <input type="number" class="form-control productRate" name="rate[]" readonly>
        </td>
        <td>

          <input type="number"  id="availability" class="form-control inputAvailability " name="availability[]" readonly>
        </td>

        <td>

          <input type="number" class="form-control quantity"  name="quantity[]">
        </td>
        <td>
          <input type="number" class="form-control totalInput"  name='total[]'>
        </td>
      </tr>
    </tbody>
</table>
  <div class=" ">
  <button type="submit" class="btn btn-danger ">Sell</button>
  <div  class="bg-dark btn"  id="sell-button" style="color:white"><i class="  fas fa-plus "></i> </div>
  </div>
</form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {



  //fetching availability

  let branchId = {!! json_encode($branch) !!}?{!! json_encode($branch) !!}:0;
  let url;
  
  function  getAvailability()
  {

    const selectWarehouseAll = document.querySelectorAll('.inputWarehouse');
   
    const selectProductAll = document.querySelectorAll('.selectProduct');
    selectWarehouseAll.forEach(function(selectWarehouse,index)

{
  selectWarehouse.addEventListener('change', function() {
      const warehouseId = this.value;
      const productId = selectProductAll[index].value;
      fetchData(productId, warehouseId,index);
  });


});

selectProductAll.forEach(function(selectProduct,index)
{
  selectProduct.addEventListener('change', function() {
    const productId = this.value;
    const warehouseId = selectWarehouseAll[index].value? selectWarehouseAll[index].value : 0; 
    fetchData(productId, warehouseId,index);
});


});

  }
getAvailability();
function fetchData(productId, warehouseId,index) {
  // Fetch request to check quantity availability
  // var url_1= '/api/products/'+productId+'/availibility';
url  =  '/api/branchs/'+branchId +'/products/'+productId+'/warehouses/'+warehouseId +'/availability';
  
  //  url= '/api/products/'+productId+'/warehouses/'+warehouseId +'/availability';
    fetch(url)
        .then(response => {
            return  response.json(); // returns promise
        }).then(data=>{
          console.log(data.quantity);
         console.log(document.querySelectorAll('.inputAvailability'));
          document.querySelectorAll('.inputAvailability')[index].value = data.quantity;
        })
        .catch(error => {
            // Handle errors
            console.log(error);
            
            console.log('There was a problem with the fetch operation:', error);
        });
}



//to create new purchase form on clicking plus icon

const formContainer = document.querySelector('.more-form');
const formHtml = ` <tr>
        <td>
          <select id="inputState" class="form-control " name="contact_id[]">
            <option selected value="">Choose Customer...</option>
           @foreach ($customers as $customer )
           <option value="{{$customer->id}}">{{$customer->name}}</option>
           @endforeach
          </select>
        </td>
        <td>
          <select id="inputProduct"  class="form-control selectProduct" name="product_id[]">
            <option selected value="">Choose...</option>
            @foreach($products as $product)
    
        
            <option value="{{$product->id}}"  rate="{{$product->rate}}"   unit="{{$product->unit->name}}">{{$product->name}}</option>
    @endforeach
    
          </select>
        </td>
        <td>
          <select  class="form-control inputWarehouse" name="warehouse_id[]">
            <option selected value="">Select Warehouse...</option>
         @foreach ($warehouses as $warehouse )
           
         <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
         @endforeach
    
          </select>
        </td>

        <td>
          <input type="text" class="form-control productunit"  name="unit[]" readonly>
        </td>
        <td>

          <input type="number" class="form-control productRate" name="rate[]" readonly>
        </td>
        <td>

          <input type="number"  id="availability" class="form-control inputAvailability " name="availability[]" readonly>
</td>


        <td>

          <input type="number" class="form-control quantity"  name="quantity[]">
        </td>
        <td>
          <input type="number" class="form-control totalInput"  name='total[]'>
        </td>
      </tr>`;


  document.querySelector('#sell-button').addEventListener('click',function()
{
  
 
 formContainer.insertAdjacentHTML('beforeend',formHtml);
 attachEventListeners();
 getAvailability();

});





  var today = new Date();

// Format the date as yyyy-mm-dd
var formattedDate = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);

// Set the formatted date as the value of the date input


let date = document.querySelector('.date');
  date.value=formattedDate;


  // Add event listener to the product select element
  function attachEventListeners()
  {
   let productSelectAll = document.querySelectorAll('.selectProduct');
  let rateInputAll = document.querySelectorAll('.productRate');
  let quantityInputAll = document.querySelectorAll('.quantity');
  let unitInputAll = document.querySelectorAll('.productunit');
  let totalInputAll = document.querySelectorAll('.totalInput');
  let purchaseMoreAll  = document.querySelectorAll('.purchase-more');
 
  
    productSelectAll.forEach(function(productSelect,index)
{
  productSelect.addEventListener('change', function() {
    // Get the selected product's rate and set it as the value of the rate input
    const selectedOption = productSelect.options[productSelect.selectedIndex];
    //getting rate attribute
    const rate = selectedOption.getAttribute('rate');
    rateInputAll[index].value = rate;
    //getting unit attribute
    const unit = selectedOption.getAttribute('unit');
    unitInputAll[index].value = unit;
    // calculateTotal( index);

  });

  //obtaining quantity and calculating total
  quantityInputAll.forEach(function(quantityInput,index)
{
quantityInput.addEventListener('input',function(){
calculateTotal(index,rateInputAll[index].value,quantityInputAll[index].value,totalInputAll)

});

});

//obtaining total and calculating quantity based on that
totalInputAll.forEach(function(totalInput,index)
{
totalInput.addEventListener("input",function(){
  calculateQuantity(index,rateInputAll[index].value,totalInputAll[index].value,quantityInputAll)
});

});
  });



  
}
  attachEventListeners();



// Function to calculate total based on quantity and rate
function calculateTotal(index,rate,quantity,totalInputAll) {
  

    if (!isNaN(quantity) &&(quantity!=='') && !isNaN(rate)) {
        // Calculate the total
        const total = quantity * rate;
        // Update the total input field
        totalInputAll[index].value = total.toFixed(2);
    } else {
        // If either quantity or rate is not a valid number, reset the total field
        totalInputAll[index].value = '';
    }
}


//to calculate quantity based on change in total
function calculateQuantity(index,rate,total,quantityInputAll) {
    // const total = parseFloat(total);
    // const rate = parseFloat(rate);
    if (!isNaN(total) &&(total!='') && !isNaN(rate) && rate !== 0) {
        // Calculate the quantity
        const quantity = total / rate;
        // Update the quantity input field
        quantityInputAll[index].value = quantity.toFixed(2);
    } else {
        // If either total or rate is not a valid number, reset the quantity field
        quantityInputAll[index].value = '';
    }
}



});
  </script>
@endsection