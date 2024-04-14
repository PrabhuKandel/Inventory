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
<form action="{{$branch?'/branchs/'.$branch.'/sellproducts':'/sellproducts'}}"   method="POST">
  @csrf
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="inputState">Customer</label>
      <select id="inputState" class="form-control" name="contact">
        <option selected disabled>Choose Customer...</option>
       @foreach ($customers as $customer )
       <option value="{{$customer->id}}">{{$customer->name}}</option>
       @endforeach
      </select>
    </div>
    <div class="form-group col-md-4">
      
      
      <label for="inputState">Product</label>
      <select id="inputProduct" class="form-control" name="product">
        <option selected >Choose...</option>
        @foreach($products as $product)

    
        <option value="{{$product->id}}"  rate="{{$product->rate}}"   unit="{{$product->unit->name}}">{{$product->name}}</option>
@endforeach

      </select>
    </div>
    <div class="form-group col-md-4">
      <label for="inputState">Warehouse</label>
      <select id="inputWarehouse" class="form-control" name="warehouse">
        <option selected value="0" >Select Warehouse...</option>
     @foreach ($warehouses as $warehouse )
       
     <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
     @endforeach

      </select>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationDefault02">Date</label>
      <input type="date" id="date" class="form-control" name="date" pattern="" required>
    </div>
  </div>
  <div>
    <p class="text-primary">Enter Product Quantity</p>
  </div>
  <div class="form-group row">
  <div class="form-group col-md-2">
    <label for="inputZip">Quantity</label>
    <input type="number" class="form-control" id="quantity" name="quantity">
  </div>
  <div class="form-group col-md-2">
    <label for="inputZip">Unit</label>
    <input type="text" class="form-control" id="productunit" name="unit" readonly>
  </div>
 
  <div class="form-group col-md-2">
    <label for="inputZip">Rate</label>
    <input type="number" class="form-control" id="productRate" name="rate" readonly>
  </div>
  <div class="form-group col-md-2">
    <label for="inputZip">Available Quantity</label>
    <input type="number" class="form-control" id="availability" name="available_quantity" readonly>
  </div>
  <div class="form-group row">
    <label for="inputZip">Total (Rs)</label>
    <div class="col-sm-4">
      <input type="number" class="form-control" id="totalInput" name='total'>
    </div>
  
  </div>
</div>

  
  <div class="form-group col-md-2">
  <button type="submit" class="btn btn-danger ">Sell</button>
  </div>
</form>
<script>
  var today = new Date();

// Format the date as yyyy-mm-dd
var formattedDate = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);

// Set the formatted date as the value of the date input
document.getElementById('date').value = formattedDate;


//to calculate rate  and total of product dynamically
const productSelect = document.getElementById('inputProduct');
  const rateInput = document.getElementById('productRate');
  const quantityInput = document.getElementById('quantity');
  const totalInput = document.getElementById('totalInput');
  const unitInput = document.getElementById('productunit');


  // Add event listener to the product select element
  productSelect.addEventListener('change', function() {
    // Get the selected product's rate and set it as the value of the rate input
    const selectedOption = productSelect.options[productSelect.selectedIndex];
    const rate = selectedOption.getAttribute('rate');
    rateInput.value = rate;
    calculateTotal();

  });
  productSelect.addEventListener('change', function() {
    // Get the selected product's rate and set it as the value of the rate input
    const selectedOption = productSelect.options[productSelect.selectedIndex];
    const unit = selectedOption.getAttribute('unit');
    unitInput.value = unit;


  });
 
// Add event listeners to quantity and rate inputs to recalculate total
quantityInput.addEventListener('input', calculateTotal);
rateInput.addEventListener('input', calculateTotal);


// Function to calculate total based on quantity and rate
function calculateTotal() {
    const quantity = parseFloat(quantityInput.value);
    const rate = parseFloat(rateInput.value);
    if (!isNaN(quantity) && !isNaN(rate)) {
        // Calculate the total
        const total = quantity * rate;
        // Update the total input field
        totalInput.value = total.toFixed(2);
    } else {
        // If either quantity or rate is not a valid number, reset the total field
        totalInput.value = '';
    }
}

// Add event listener to total input to recalculate quantity
totalInput.addEventListener('input', calculateQuantity);

// Function to calculate quantity based on total and rate
function calculateQuantity() {
    const total = parseFloat(totalInput.value);
    const rate = parseFloat(rateInput.value);
    if (!isNaN(total) && !isNaN(rate) && rate !== 0) {
        // Calculate the quantity
        const quantity = total / rate;
        // Update the quantity input field
        quantityInput.value = quantity.toFixed(2);
    } else {
        // If either total or rate is not a valid number, reset the quantity field
        quantityInput.value = '';
    }
}





const selectWarehouse = document.getElementById('inputWarehouse');
const selectProduct = document.getElementById('inputProduct');
let url;
let branchId = {!! json_encode($branch) !!}?{!! json_encode($branch) !!}:0;

function fetchData(productId, warehouseId) {
  // Fetch request to check quantity availability
  // var url_1= '/api/products/'+productId+'/availibility';
url  =  '/api/branchs/'+branchId +'/products/'+productId+'/warehouses/'+warehouseId +'/availability';
  
  //  url= '/api/products/'+productId+'/warehouses/'+warehouseId +'/availability';
    fetch(url)
        .then(response => {
            return  response.json(); // returns promise
        }).then(data=>{
          console.log(data.quantity);
          document.getElementById('availability').value = data.quantity;
        })
        .catch(error => {
            // Handle errors
            console.log(error);
            
            console.log('There was a problem with the fetch operation:', error);
        });
}

// Event listeners to fetch data when options are selected
selectWarehouse.addEventListener('change', function() {
    const warehouseId = this.value;
    const productId = selectProduct.value;
    fetchData(productId, warehouseId);
});

selectProduct.addEventListener('change', function() {
    const productId = this.value;
    const warehouseId = selectWarehouse.value? selectWarehouse.value : 0; 
    fetchData(productId, warehouseId);
});


  </script>
@endsection