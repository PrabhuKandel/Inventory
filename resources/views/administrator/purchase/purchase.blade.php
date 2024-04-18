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
<form  class="purchase-form" action="{{$branch?'/branchs/'.$branch.'/purchaseproducts':'/purchaseproducts'}}"  method="POST">
  @csrf
  <div class="form-group-row d-flex justify-content-start">
    <div class=" form-group col-md-2 ml-0   ">
      <label for="validationDefault02">Date</label>
      <input type="date"  class="form-control   date" name="created_date" pattern="" required>
      </div>
  </div>
  <div class="form-group row mt-3">
    <div class=" from-group col-md-2">

      <label for="inputState">Supplier</label>
      <select id="inputState" class="form-control " name="contact_id">
        <option selected disabled>Choose Supplier...</option>
       @foreach ($customers as $customer )
       <option value="{{$customer->id}}">{{$customer->name}}</option>
       @endforeach
      </select>
    </div>
    <div class="form-group col-md-2">
      
      
      <label for="inputState">Product</label>
      <select id="inputProduct"  class="form-control selectProduct" name="product_id">
        <option selected disabled>Choose...</option>
        @foreach($products as $product)

    
        <option value="{{$product->id}}"  rate="{{$product->rate}}"   unit="{{$product->unit->name}}">{{$product->name}}</option>
@endforeach

      </select>
    </div>
    <div class="form-group col-md-2">
      <label for="inputState">Warehouse</label>
      <select id="inputState" class="form-control" name="warehouse_id">
        <option selected disabled>Select Warehouse...</option>
     @foreach ($warehouses as $warehouse )
       
     <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
     @endforeach

      </select>
    </div>
  
 
  {{-- <div>
    <p class="text-primary">Enter Product Quantity</p>
  </div> --}}
  <div class="form-group col">
    <label for="inputZip">Unit</label>
    <input type="text" class="form-control productunit"  name="unit" readonly>
  </div>
 
  <div class="form-group col-md-1">
    <label for="inputZip">Rate</label>
    <input type="number" class="form-control productRate" name="rate" readonly>
  </div>

  <div class="form-group col-md-2">
    <label for="inputZip">Quantity</label>
    <input type="number" class="form-control quantity"  name="quantity">
  </div>
  
    <div class="form-group col-md-2">
    <label for="inputZip">Total (Rs)</label>
      <input type="number" class="form-control totalInput"  name='total'>
    </div>
    
  </div>


  
  <div class=" ">
  <button type="submit" class="btn btn-success ">Purchase</button>
  <div  class="bg-dark btn  purchase-more " style="color:white"><i class="  fas fa-plus "></i> </div>
  </div>
  <hr class="border border-dark  opacity-100">
  <br>
</form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {

//to create new purchase form on clicking plus icon

const formContainer = document.querySelector('.form-container');
const formHtml = `<form  class="purchase-form" action="{{$branch?'/branchs/'.$branch.'/purchaseproducts':'/purchaseproducts'}}"  method="POST">
  @csrf
  <div class="form-group row mt-3">
    <div class=" from-group col-md-2">

      <label for="inputState">Supplier</label>
      <select id="inputState" class="form-control" name="contact_id">
        <option selected disabled>Choose Supplier...</option>
       @foreach ($customers as $customer )
       <option value="{{$customer->id}}">{{$customer->name}}</option>
       @endforeach
      </select>
    </div>
    <div class="form-group col-md-2">
      
      
      <label for="inputState">Product</label>
      <select id="inputProduct"  class="form-control selectProduct" name="product_id">
        <option selected disabled>Choose...</option>
        @foreach($products as $product)

    
        <option value="{{$product->id}}"  rate="{{$product->rate}}"   unit="{{$product->unit->name}}">{{$product->name}}</option>
@endforeach

      </select>
    </div>
    <div class="form-group col-md-2">
      <label for="inputState">Warehouse</label>
      <select id="inputState" class="form-control" name="warehouse_id">
        <option selected disabled>Select Warehouse...</option>
     @foreach ($warehouses as $warehouse )
       
     <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
     @endforeach

      </select>
    </div>
  
 
  {{-- <div>
    <p class="text-primary">Enter Product Quantity</p>
  </div> --}}
  <div class="form-group col-md-1">
    <label for="inputZip">Unit</label>
    <input type="text" class="form-control productunit"  name="unit" readonly>
  </div>
 
  <div class="form-group col-md-1">
    <label for="inputZip">Rate</label>
    <input type="number" class="form-control productRate" name="rate" readonly>
  </div>

  <div class="form-group col-md-2">
    <label for="inputZip">Quantity</label>
    <input type="number" class="form-control quantity"  name="quantity">
  </div>
  
    <div class="form-group col-md-2">
    <label for="inputZip">Total (Rs)</label>
      <input type="number" class="form-control totalInput"  name='total'>
    </div>
    
  </div>


  
  <div class=" ">
  <button type="submit" class="btn btn-success ">Purchase</button>
  <div  class="bg-dark btn  purchase-more " style="color:white"><i class="  fas fa-plus "></i> </div>
  </div>
  <hr class="border border-dark  opacity-100">
  <br>
</form>`;

function createform(purchaseMoreAll)
{

purchaseMoreAll.forEach(function(purchaseMore,index)
{
  purchaseMore.addEventListener('click',function()
{
 
 formContainer.insertAdjacentHTML('beforeend',formHtml);
 attachEventListeners();

});
});

}


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

  createform(purchaseMoreAll);

  
}
  attachEventListeners();



// Function to calculate total based on quantity and rate
function calculateTotal(index,rate,quantity,totalInputAll) {
  console.log(totalInputAll);

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