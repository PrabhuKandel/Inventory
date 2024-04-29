@extends('layouts.app')
@section('content')
@php
$edit = isset($purchaseSaleDetail) && $purchaseSaleDetail ? true : false;
$purSaleId = $edit ? $purchaseSaleDetail->id : '';
@endphp
{{-- @dd(old()); --}}
{{-- <script src="{{ asset('js/app.js') }}"></script> --}}

<div id="success-message">

</div>


<div id="error-message" class="">

</div>


<div class="form-container mb-5">
    <form id="myForm" class="purchase-form"
        action="{{ $edit ? (isset($branch) && $branch ? '/branchs/' . $branch . '/' . $_type . '/' . $purchaseSaleDetail->id . '/update' : '/' . $_type . '/' . $purchaseSaleDetail->id . '/update') : '' }}"
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
                @if ($_type == 'sales')
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
                            @foreach ($contacts as $contact)
                            <option value="{{ $contact->id }}" {{ $edit && $purchaseSaleDetail->contact_id ==
                                $contact->id ? 'selected' : '' }}>
                                {{ $contact->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select id="inputProduct" class="form-control selectProduct" name='product_id[]'>
                            <option selected value="">Choose...</option>
                            @foreach ($products as $product)
                            <option value="{{ $product->id }}" rate="{{ $product->rate }}"
                                unit="{{ $product->unit->name }}" {{ $edit && $purchaseSaleDetail->product_id ==
                                $product->id ? 'selected' : '' }}>
                                {{ $product->name }}</option>
                            @endforeach

                        </select>
                    </td>
                    <td>
                        <select class="form-control inputWarehouse" name='warehouse_id[]'>
                            <option selected value="">Select Warehouse...</option>
                            @foreach ($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" {{ $edit && $purchaseSaleDetail->warehouse_id ==
                                $warehouse->id ? 'selected' : '' }}>
                                {{ $warehouse->name }} </option>
                            @endforeach

                        </select>
                    </td>

                    <td>
                        <input type="text" class="form-control productunit" name="unit[]" readonly>
                    </td>
                    <td>

                        <input type="number" class="form-control productRate" name="rate[]" readonly>
                    </td>
                    @if ($_type == 'sales')
                    <td>

                        <input type="number" id="availability" class="form-control inputAvailability "
                            name="availability[]" readonly>
                    </td>
                    @endif

                    <td>

                        <input type="number" class="form-control quantity" name="quantity[]"
                            value="{{ $edit ? $purchaseSaleDetail->quantiy : '' }}">
                    </td>
                    <td>
                        <input type="number" class="form-control totalInput" name='total[]'>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class=" ">
            <button type="submit" class="btn btn-danger ">{{ $edit ? 'Update' : ($_type == 'sales' ? 'Sell' :
                'Purchase') }}</button>
            @if (!$edit)
            <div class="bg-dark btn" id="sell-button" style="color:white"><i class="  fas fa-plus "></i> </div>
            @endif
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {

            //fetching availability

            let url;
            let branchId = {!! json_encode($branch) !!} ? {!! json_encode($branch) !!} : 0;
            let edit = @json($edit);


            function getAvailability() {

                const selectWarehouseAll = $('.inputWarehouse');


                const selectProductAll = $('.selectProduct');
                selectWarehouseAll.each(function(index)

                    {
                        $(this).on('change', function() {
                            const warehouseId = $(this).val() ? $(this).val() : 0;
                            const productId = selectProductAll.eq(index).val();
                            fetchData(productId, warehouseId, index);
                        });


                    });

                selectProductAll.each(function(index) {
                    $(this).on('change', function() {
                        const productId = $(this).val();
                        const warehouseId = selectWarehouseAll.eq(index).val() ? selectWarehouseAll
                            .eq(index).val() : 0;
                        fetchData(productId, warehouseId, index);
                    });


                });

            }
            getAvailability();

            function fetchData(productId, warehouseId, index) {


                // Fetch request to check quantity availability
                _url = '/api/branchs/' + branchId + '/products/' + productId + '/warehouses/' + warehouseId +
                    '/availability'
                $.ajax({

                    type: 'GET',
                    url: _url,
                    contentType: 'application/json',
                    dataType: "json",
                    success: function(response) {

                        $('.inputAvailability').eq(index).val(response.quantity);
                    },
                    error: function(xhr, status, error) {

                        $('.inputAvailability').eq(index).val("");

                    }

                });

            }

            //to create new purchase or sales form on clicking plus icon
            const formContainer = $('.more-form');
            const formHtml = ` <tr class="table-row">
        <td>
          <select id="inputState" class="form-control " name="contact_id[]">
            <option selected value="">Choose Customer...</option>
           @foreach ($contacts as $contact)
           <option value="{{ $contact->id }}">{{ $contact->name }}</option>
           @endforeach
          </select>
        </td>
        <td>
          <select id="inputProduct"  class="form-control selectProduct" name="product_id[]">
            <option selected value="">Choose...</option>
            @foreach ($products as $product)
    
        
            <option value="{{ $product->id }}"  rate="{{ $product->rate }}"   unit="{{ $product->unit->name }}">{{ $product->name }}</option>
    @endforeach
    
          </select>
        </td>
        <td>
          <select  class="form-control inputWarehouse" name="warehouse_id[]">
            <option selected value="0" >Select Warehouse...</option>
         @foreach ($warehouses as $warehouse)
           
         <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
         @endforeach
    
          </select>
        </td>

        <td>
          <input type="text" class="form-control productunit"  name="unit[]" readonly>
        </td>
        <td>

          <input type="number" class="form-control productRate" name="rate[]" readonly>
        </td>
        @if ($_type == 'sales')
        <td>

          <input type="number"  id="availability" class="form-control inputAvailability " name="availability[]" readonly>
        </td>
        @endif


        <td>

          <input type="number" class="form-control quantity"  name="quantity[]">
        </td>
        <td>
          <input type="number" class="form-control totalInput"  name='total[]'>
        </td>
        <td>
          <div  class="bg-danger btn remove-row"   style="color:white"><i class="  fas fa-xmark "></i> </div>
        </td>
        
      </tr>`;


            $('#sell-button').on('click', function() {
                $(formContainer).append(formHtml);
                attachEventListeners();
                getAvailability();

            });


            var today = new Date();

            // Format the date as yyyy-mm-dd
            var formattedDate = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' +
                today.getDate()).slice(-2);

            // Set the formatted date as the value of the date input
            let date = $('.date');
            date.val(formattedDate);


            // Add event listener to the product select element
            function attachEventListeners() {
                let productSelectAll = $('.selectProduct');
                let rateInputAll = $('.productRate');
                let quantityInputAll = $('.quantity');
                let unitInputAll = $('.productunit');
                let totalInputAll = $('.totalInput');
                let purchaseMoreAll = $('.purchase-more');


                productSelectAll.each(function(index) {
                    $(this).on('change', function() {
                        // Get the selected product's rate and set it as the value of the rate input
                        const selectedOption = $(this).find('option:selected');

                        //getting rate attribute
                        const rate = selectedOption.attr('rate');
                        rateInputAll.eq(index).val(rate);
                        //getting unit attribute
                        const unit = selectedOption.attr('unit');
                        unitInputAll.eq(index).val(unit);
                        // calculateTotal( index);

                    });

                    //obtaining quantity and calculating total
                    quantityInputAll.each(function(index) {
                        $(this).on('input', function() {
                            calculateTotal(index, rateInputAll.eq(index).val(),
                                quantityInputAll.eq(index).val(), totalInputAll)

                        });

                    });

                    //obtaining total and calculating quantity based on that
                    totalInputAll.each(function(index) {
                        $(this).on("input", function() {
                            calculateQuantity(index, rateInputAll.eq(index).val(),
                                totalInputAll.eq(index).val(), quantityInputAll)
                        });

                    });
                });
                //to remove row  from table dynamically
                const tableRowAll = $('.table-row');

                //remove  row from table
                const removeRowAll = $('.remove-row');
                removeRowAll.each(function(index) {


                    $(this).on('click', function() {
                        tableRowAll.eq(index).remove();

                    })

                });


            }
            attachEventListeners();



            // Function to calculate total based on quantity and rate
            function calculateTotal(index, rate, quantity, totalInputAll) {


                if (!isNaN(quantity) && (quantity !== '') && !isNaN(rate)) {
                    // Calculate the total
                    const total = quantity * rate;
                    // Update the total input field
                    totalInputAll.eq(index).val(total.toFixed(2));
                } else {
                    // If either quantity or rate is not a valid number, reset the total field
                    totalInputAll.eq(index).val('');
                }
            }


            //to calculate quantity based on change in total
            function calculateQuantity(index, rate, total, quantityInputAll) {
                // const total = parseFloat(total);
                // const rate = parseFloat(rate);
                if (!isNaN(total) && (total != '') && !isNaN(rate) && rate !== 0) {
                    // Calculate the quantity
                    const quantity = total / rate;
                    // Update the quantity input field
                    quantityInputAll.eq(index).val(quantity.toFixed(2));
                } else {
                    // If either total or rate is not a valid number, reset the quantity field
                    quantityInputAll.eq(index).val("");
                }
            }

            //submitted through ajax beacuse page dont refresh and newly added row isn;t lost
            const type = @json($_type);
            const pursaleId = @json($purSaleId);
            $('#myForm').submit(function(e) {
                e.preventDefault();
                $('#error-message').fadeOut(function() {
                    $(this).empty().removeClass('alert alert-danger alert-block').fadeIn();
                });

                let url;
                let method;
                let form = $('#myForm');
                url1 = branchId != 0 ? "/branchs/" + branchId + '/' + type + '/store' : "/" + type +
                    "/store";

                url2 = edit && branchId != 0 ? '/branchs/' + branchId + '/' + type + '/' + pursaleId +
                    '/update' : '/' + type + '/' + pursaleId + '/update'
                url = edit ? url2 : url1;
                method = edit ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    data: form.serialize(),
                    success: function(response) {
                        response.success ? $('#myForm')[0].reset() : '';

                        console.log(response);

                        $('#success-message').html(`<strong> ${response.message}</strong> `)
                            .addClass('alert alert-info alert-block').fadeIn();
                        setTimeout(function() {
                            $('#success-message').fadeOut();

                        }, 3000);

                    },
                    error: function(xhr, status, error) {

                        console.log(xhr);

                        $.each(xhr.responseJSON.errors, function(key, value) {
                            $.each(value, function(index, error) { 
                                
                                $('#error-message').append(`<p >${error}</p>`);
                            });
                        });
                        $('#error-message').addClass('alert alert-danger alert-block');


                    }
                });
            });

            //getting rate and unit of product in input field if edit is true

            if (edit) {

                const selectedOption = $('.selectProduct').find('option:selected');


                const rate = selectedOption.attr('rate');
                $('.productRate').val(rate);

                const unit = selectedOption.attr('unit');
                $('.productunit').val(unit);

                $('.totalInput').val(rate * ($('.quantity').val()));

                const productId = selectedOption.val();
                const warehouseId = $('.inputWarehouse').find('option:selected').val();
                // console.log(productId,warehouseId);

                fetchData(productId, warehouseId, 0);
            }
        })
</script>
@endsection