@extends('layouts.app')
@section('content')
<style>
  .info {
    padding: 10px;
    height: 80px;
    border-radius: 20px;
    color: white;
    font-size: 13px;
    display: flex;
    flex-direction: column;

  }

  .info-no {
    text-align: center;
    font-size: 15px;
    font-weight: bold;
  }
</style>
<div style="display: grid; grid-template-columns: repeat(4 , auto); column-gap: 35px; row-gap:30px; margin-bottom:20px">
  <div class="bg-success   info">
    <p> No of Warehouses </p> <span class="info-no"> {{ $datas['warehousesNo'] }}</span>
  </div>

  <div class="bg-info   info">
    <p>No of Suppliers</p> <span class="info-no"> {{ $datas['suppliersNo'] }}</span>
  </div>

  <div class="bg-danger  info">
    <p>No of purchases</p> <span class="info-no"> {{ $datas['inCount'] }}</span>
  </div>
  <div class="bg-warning  info">
    <p>No of sales</p> <span class="info-no"> {{ $datas['outCount'] }}</span>
  </div>

</div>

<div class=" d-flex justify-content-between">
  <div class="barchart-container " style="height:450px; width:600px">
    <h6 class="text-center">Bar graph of Product and their rate</h6>
    <canvas id="barChart"></canvas>
  </div>

  <div class="piechart-container  " style=" position: relative;  height:250px; width:400px">
    <div class="piechart-content visually-hidden">
      <canvas id="pieChart" aria-label="Hello ARIA World"></canvas>
      <h6 class="text-center mt-2">Product and available quantity</h8>
    </div>
    <div class="loading " style="position: absolute; bottom:0; left:0">
      <span>Loading...</span>
      <div class="spinner-border" role="status">
      </div>
    </div>
  </div>
</div>


<script src=" https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js"
  integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- <script src="//cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script> --}}



<script>
  let productQuantity = [];
        let productsDetails = @json($products);
        let productName = [];
        let productRate = [];
        let productId = [];
        console.log(productsDetails);
        productsDetails.forEach(obj => {
            productName.push(obj['name']);
            productRate.push(obj['rate']);
            productId.push(obj['id']);

        });
        let lastproductId = productId[productId.length - 1];




        //bar graph
        const ctx = document.getElementById('barChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: productName,
                datasets: [{
                    label: 'Rate',
                    data: productRate,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1,
                    barThickness: 50,
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Products'
                        },
                    },

                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Rate' // Label for y-axis
                        }
                    }
                },
                maintainAspectRatio: false,
            }

        });



        // Fetch request to check quantity availability
        let branchId = warehouseId = 0;

        function fetchQuantity(product_id, product_name) {
            $.ajax({

                url: '/api/branchs/' + branchId + '/products/' + product_id + '/warehouses/' + warehouseId +
                    '/availability',
                type: 'GET',
                contentType: 'application/json',
                dataType: "json",
                success: function(response) {
                    productQuantity.push({

                        'name': product_name,
                        'quantity': response.quantity
                    });



                },
                error: function(xhr, status, error) {
                    console.log(xhr);


                }

            });


        }
        console.log(productId);
        productsDetails.forEach(item => {
            fetchQuantity(item.id, item.name);

        });
        $(document).ajaxStop(function() {

            $('.loading').hide();
            $('.piechart-content').removeClass('visually-hidden');
            //pie chart
            const pieChart = document.getElementById('pieChart');
            new Chart(pieChart, {
                type: 'doughnut',
                data: {
                    labels: productQuantity.map(item => item.name),
                    datasets: [{
                        label: 'Quantity ',
                        data: productQuantity.map(item => item.quantity),
                    }]
                },
                options: {
                  
                    plugins: {
                        datalabels: {
                            color: 'white',
                             
                            font: {
                                size: 16 // Change label font size
                            },
                 
                        }
                    } 
                },

                plugins: [ChartDataLabels]
            });
        });
</script>
@endsection