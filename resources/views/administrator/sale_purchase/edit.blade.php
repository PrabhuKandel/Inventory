@extends('layouts.app')
@section('content')


<div id="success-message">

</div>


<div id="error-message" class="">

</div>


<div class="form-container mb-5">
  <form id="myForm" class="purchase-form" {{--
    action="{{ (isset($branch) && $branch) ? '/branchs/'.$branch.'/'.$_type.'/store':'/'.$_type.'/store'}}" --}}
    method="POST">
    @csrf
    <div class="form-group-row d-flex justify-content-start">
      <div class=" form-group col-md-2 ml-0   ">
        <label for="validationDefault02">Date</label>
        <input type="date" class="form-control   date" name="created_date" pattern="">
      </div>
    </div>
    <table class="table">
      <thead>
        <th>Contact</th>
        <th>Product</th>
        <th>Warehouse</th>
        <th style="width:10%">Unit</th>
        <th style="width:10%">Rate</th>
        @if($_type == 'sales')
        <th style="width:10%">Availability</th>
        @endif
        <th>Quantity</th>
        <th>Total (Rs)</th>
        </tr>
      </thead>

      <tbody class="more-form ">
        <tr>
          <td>
            <select id="inputState" class="form-control " name='contact_id[]'>
              <option selected value="">Choose Contact...</option>
              @foreach ($contacts as $contact )
              <option value="{{$contact->id}}">{{$contact->name}}</option>
              @endforeach
            </select>
          </td>
          <td>
            <select id="inputProduct" class="form-control selectProduct" name='product_id[]'>
              <option selected disabled value="">Choose...</option>
              @foreach($products as $product)


              <option value="{{$product->id}}" rate="{{$product->rate}}" unit="{{$product->unit->name}}">
                {{$product->name}}</option>
              @endforeach

            </select>
          </td>
          <td>
            <select class="form-control inputWarehouse" name='warehouse_id[]'>
              <option selected value="0">Select Warehouse...</option>
              @foreach ($warehouses as $warehouse )

              <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
              @endforeach

            </select>
          </td>

          <td>
            <input type="text" class="form-control productunit" name="unit[]" readonly>
          </td>
          <td>

            <input type="number" class="form-control productRate" name="rate[]" readonly>
          </td>
          @if($_type == "sales")
          <td>

            <input type="number" id="availability" class="form-control inputAvailability " name="availability[]"
              readonly>
          </td>
          @endif

          <td>

            <input type="number" class="form-control quantity" name="quantity[]">
          </td>
          <td>
            <input type="number" class="form-control totalInput" name='total[]'>
          </td>
        </tr>
      </tbody>
    </table>
    <div class=" ">
      <button type="submit" class="btn btn-success ">Update</button>

    </div>
  </form>
</div>
@endsection