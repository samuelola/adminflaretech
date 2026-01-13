<footer class="d-footer">
  <div class="row align-items-center justify-content-between">
    <div class="col-auto">
      <p class="mb-0">© 2025 FlareTechMusic. All Rights Reserved.</p>
    </div>
    <!-- <div class="col-auto">
      <p class="mb-0">Made by <span class="text-primary-600">wowtheme7</span></p>
    </div> -->
  </div>
</footer>
</main>
@php

$plan_count = \DB::table('subscription_payment_details')
     ->select(\DB::raw('count(*) as sub_count'))
     ->groupBy('Planname')
     ->get();

$planname = \DB::table('subscription_payment_details')
     ->select(\DB::raw('Planname'))
     ->groupBy('Planname')
     ->get();

$countvalue = $plan_count->pluck('sub_count')->toArray();
$planvalue = $planname->pluck('Planname')->toArray();
  

@endphp

  <!-- jQuery library js -->
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
  <script src="{{asset('assets/js/lib/jquery-3.7.1.min.js')}}"></script>
  <!-- Bootstrap js -->
  <script src="{{asset('assets/js/lib/bootstrap.bundle.min.js')}}"></script>
  
  
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>

  <!-- Apex Chart js -->
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <!-- <script src="assets/js/lib/apexcharts.min.js"></script> -->
  <!-- Data Table js -->
  <!-- <script src="{{asset('datatables.js')}}"></script> -->
  <!-- Iconify Font js -->
  <script src="{{asset('assets/js/lib/iconify-icon.min.js')}}"></script>
  <!-- jQuery UI js -->
  <script src="{{asset('assets/js/lib/jquery-ui.min.js')}}"></script>
  <!-- Vector Map js -->
  <script src="{{asset('assets/js/lib/jquery-jvectormap-2.0.5.min.js')}}"></script>
  <script src="{{asset('assets/js/lib/jquery-jvectormap-world-mill-en.js')}}"></script>
  <!-- Popup js -->
  <script src="{{asset('assets/js/lib/magnifc-popup.min.js')}}"></script>
  <!-- Slick Slider js -->
  <script src="{{asset('assets/js/lib/slick.min.js')}}"></script>
  <!-- prism js -->
  <script src="{{asset('assets/js/lib/prism.js')}}"></script>
  <!-- file upload js -->
  <script src="{{asset('assets/js/lib/file-upload.js')}}"></script>
  <!-- audioplayer -->
  <script src="{{asset('assets/js/lib/audioplayer.js')}}"></script>
  
  <!-- main js -->
  <script src="{{asset('assets/js/app.js')}}"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  

<!-- <script src="assets/js/homeOneChart.js"></script> -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> 
<script src="{{asset('assets/js/refresh_token.js')}}"></script>
<script src="{{asset('assets/js/ping_code.js')}}"></script>

<script>
   var options = {
  chart: {
    type: 'line'
  },
  series: [{
    name: 'sales',
    data: [30,40,35,50,49,60,70,91,125]
  }],
  xaxis: {
    categories: [1991,1992,1993,1994,1995,1996,1997, 1998,1999]
  }
}

var chart = new ApexCharts(document.querySelector("#chartt"), options);

chart.render();
</script>  

 


<script>
    var ENDPOINT = "{{ route('dashboard') }}";
    var page = 1;
  
    $(".load-more-data").click(function(){
        page++;
        infinteLoadMore(page);
    });
    
  
    /*------------------------------------------
    --------------------------------------------
    call infinteLoadMore()
    --------------------------------------------
    --------------------------------------------*/
    function infinteLoadMore(page) {
        $.ajax({
                url: ENDPOINT + "?page=" + page,
                datatype: "html",
                type: "get",
                beforeSend: function () {
                    $('.auto-load').show();
                }
            })
            .done(function (response) {

                console.log(response.html);
                if (response.html == '') {
                    $('.auto-load').html("We don't have more data to display :(");
                    return;
                }

                $('.auto-load').hide();
                $("#data-wrapper").append(response.html);
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('Server error occured');
            });
    }
</script> 


<script>
    var ENDPOINT = "{{ route('dashboard') }}";
    var page = 1;
  
    $(".load-more-dataa").click(function(){
        page++;
        infinteLoadMorer(page);
    });
    
  
    /*------------------------------------------
    --------------------------------------------
    call infinteLoadMore()
    --------------------------------------------
    --------------------------------------------*/
    function infinteLoadMorer(page) {
        $.ajax({
                url: ENDPOINT + "?page=" + page,
                datatype: "html",
                type: "get",
                beforeSend: function () {
                    $('.auto-loadd').show();
                }
            })
            .done(function (response) {

                console.log(response.newhtml);
                if (response.newhtml == '') {
                    $('.auto-loadd').html("We don't have more data to display :(");
                    return;
                }

                $('.auto-loadd').hide();
                $("#data-wrapperr").append(response.newhtml);
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('Server error occured');
            });
    }
</script>


  



<script>
  // ================================ Total Subscriber bar chart Start ================================ 

  <?php 
    $users = \App\Models\User::distinct('first_name')->count();
    $total_subsscribe = \DB::table("subscription_payment_details")->distinct('email')->count();
    $total_tracks = \DB::table("trackdetails")->where(['ReleaseCount'=>0,'ReleaseCount'=>1])->distinct('UserName')->count();
    $total_albums = \DB::table("users")->sum('albums');
    $total_albumss = (int)$total_albums;
    $total_labels = \DB::table("labeldetails")->count();
    $total_labelss = (int)$total_labels;
                   
    $Er = ['users'=>$users,'subscribers'=>$total_subsscribe,'tracks'=>$total_tracks,'albums'=>$total_albumss,'singles'=>$total_labelss];
    $cat = ['users','subscribers','tracks','albums','singles'];
    $formattedt = [];

    foreach ($Er as $key=>$value) {
        $formattedt[] = [
            'x' => $key,
            'y' => $value,
        ];
    }

       $formattedft = json_encode($formattedt );
                 
  ?>
  var options = {
      
      series: [{
          name: "Sales",
          data: <?php
          
          foreach((array)$formattedft as $rrr){
            echo $rrr;
           }
          ?>
      }],


      chart: {
          type: 'bar',
          height: 235,
          toolbar: {
              show: false
          },
      },
      plotOptions: {
          bar: {
            borderRadius: 6,
            horizontal: false,
            columnWidth: 24,
            columnWidth: '52%',
            endingShape: 'rounded',
          }
      },
      dataLabels: {
          enabled: false
      },
      fill: {
          type: 'gradient',
          colors: ['#ce11e7'], // Set the starting color (top color) here
          gradient: {
              type: 'vertical',  // Gradient direction (vertical)
              stops: [0, 100],
          },
      },
      grid: {
          show: true,
          borderColor: '#D1D5DB',
          strokeDashArray: 4, // Use a number for dashed style
          position: 'back',
          padding: {
            top: -10,
            right: -10,
            bottom: -10,
            left: -10
          }
      },
      xaxis: {
          type: 'category',
          categories: [
                      <?php 
                          foreach ($cat as $value) {
                            echo "'$value',";
                          }
                       ?>
                ]
      },
      yaxis: {
        show: true,
      },
  };

  var chart = new ApexCharts(document.querySelector("#barChart"), options);
  chart.render();
  // ================================ Total Subscriber bar chart End ================================ 
</script>

<script>
    window.chartData = {
        series: {!! json_encode($countvalue) !!},
        labels: {!! json_encode($planvalue) !!}
    };
</script>

<script src="{{ asset('assets/js/users_sub_chart.js') }}"></script>

<script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                width: 'resolve'
            });
        });
        $(document).ready(function() {
            $('.js-example-basic-singlee').select2({
                width: 'resolve'
            });
        });
</script>



<script>
    
    $(document).ready(function() {
       $('#listView').click(function() {
         $(".gridView").hide();
         $(".listView").show();
       });
   });
</script>
<script>
   
    $(document).ready(function() {
       $('#gridView').click(function() {
           $(".gridView").show();
           $(".listView").hide();
       });
   });
</script>

<script>
    var ENDPOINT = "{{ route('allUser') }}";
    var page = 1;
  
    $(".load-more-alluserdata").click(function(){
          page++;
          infinteLoadMoreralluser(page);

    });
    
  
    /*------------------------------------------
    --------------------------------------------
    call infinteLoadMore()
    --------------------------------------------
    --------------------------------------------*/
    function infinteLoadMoreralluser(page) {
        $.ajax({
                url: ENDPOINT + "?page=" + page,
                datatype: "html",
                type: "get",
                beforeSend: function () {
                    $('.auto-loadalluser').show();
                }
            })
            .done(function (response) {

                console.log(response);
                if (response.htmluserdata == '') {
                    $('.auto-loadalluser').html("We don't have more data to display :(");
                    return;
                }

                $('.auto-loadalluser').hide();
                $("#data-alluser").append(response.htmluserdata);
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('Server error occured');
            });
    }
</script>

<script>
    var ENDPOINT = "{{ route('allUser') }}";
    var page = 1;
  
    $(".load-more-allgriduserdata").click(function(){
        page++;
        infinteLoadMorerallgrid(page);
    });
    
  
    /*------------------------------------------
    --------------------------------------------
    call infinteLoadMore()
    --------------------------------------------
    --------------------------------------------*/
    function infinteLoadMorerallgrid(page) {
        $.ajax({
                url: ENDPOINT + "?page=" + page,
                datatype: "html",
                type: "get",
                beforeSend: function () {
                    $('.auto-loadallgriduser').show();
                }
            })
            .done(function (response) {

                console.log(response.htmlusergriddata);
                if (response.htmlusergriddata == '') {
                    $('.auto-loadallgriduser').html("We don't have more data to display :(");
                    return;
                }

                $('.auto-loadallgriduser').hide();
                $("#data-allgriduser").append(response.htmlusergriddata);
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('Server error occured');
            });
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

<script type="text/javascript">

 
     $('.show_confirm').click(function(event) {

          var form =  $(this).closest("form");

          var name = $(this).data("name");

          event.preventDefault();

          swal({

              title: `Are you sure you want to delete this record?`,

              text: "it will be deleted",

              icon: "warning",

              buttons: true,

              dangerMode: true,

          })

          .then((willDelete) => {

            if (willDelete) {

              form.submit();

            }

          });

      });

</script>

<script>

var ENDPOINT = "{{ route('allsubscription') }}";

var page = 1;



$(window).scroll(function () {

    if ($(window).scrollTop() + $(window).height() >= ($(document).height() - 20)) {

        page++;

        infinteLoadMoreallSub(page);

    }

});


function infinteLoadMoreallSub(page) {

    $.ajax({

            url: ENDPOINT + "?page=" + page,

            datatype: "html",

            type: "get",

            beforeSend: function () {

                $('.auto-loadallsub').show();

            }

        })

        .done(function (response) {

            if (response.htmlallsub == '') {

                $('.auto-loadallsub').html("We don't have more data to display :(");

                return;

            }



            $('.auto-loadallsub').hide();

            $("#data-wrapperallsub").append(response.htmlallsub);

        })

        .fail(function (jqXHR, ajaxOptions, thrownError) {

            console.log('Server error occured');

        });

}

</script>
<script>
    var ENDPOINT = "{{ route('dashboard') }}";
    var page = 1;
  
    $(".load-more-dataaplan").click(function(){
        page++;
        infinteLoadMorerplan(page);
    });
    
  
    /*------------------------------------------
    --------------------------------------------
    call infinteLoadMore()
    --------------------------------------------
    --------------------------------------------*/
    function infinteLoadMorerplan(page) {
        $.ajax({
                url: ENDPOINT + "?page=" + page,
                datatype: "html",
                type: "get",
                beforeSend: function () {
                    $('.auto-loaddplan').show();
                }
            })
            .done(function (response) {

                console.log(response.newhtmlplan);
                if (response.newhtmlplan == '') {
                    $('.auto-loaddplan').html("We don't have more data to display :(");
                    return;
                }

                $('.auto-loaddplan').hide();
                $("#data-wrapperrplan").append(response.newhtmlplan);
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('Server error occured');
            });
    }
</script>

<script>
   $(document).ready( function () {
    $('#myTable').DataTable({order:[]});
} );
</script>

<script>
    $('#world-map').vectorMap(
    {
      map: 'world_mill_en',
      backgroundColor: 'transparent',
      borderColor: '#fff',
      borderOpacity: 0.25,
      borderWidth: 0,
      color: '#000000',
      regionStyle : {
          initial : {
          fill : '#D1D5DB'
        }
      },
      markerStyle: {
      initial: {
            r: 5,
            'fill': '#fff',
            'fill-opacity':1,
            'stroke': '#000',
            'stroke-width' : 1,
            'stroke-opacity': 0.4
        },
    },
      markers : [{
          latLng : [35.8617, 104.1954],
          name : 'China : 250'
        },

        {
          latLng : [25.2744, 133.7751],
          name : 'AustrCalia : 250'
        },

        {
          latLng : [36.77, -119.41],
          name : 'USA : 82%'
        },

        {
          latLng : [55.37, -3.41],
          name : 'UK   : 250'
        },

        {
          latLng : [25.20, 55.27],
          name : 'UAE : 250'
      }],

      series: {
          regions: [{
              values: {
                  "US": '#487FFF ',
                  "SA": '#487FFF',
                  "AU": '#487FFF',
                  "CN": '#487FFF',
                  "GB": '#487FFF',
              },
              attribute: 'fill'
          }]
      },
      hoverOpacity: null,
      normalizeFunction: 'linear',
      zoomOnScroll: false,
      scaleColors: ['#000000', '#000000'],
      selectedColor: '#000000',
      selectedRegions: [],
      enableZoom: false,
      hoverColor: '#fff',
      
    }); 
  // ================================ J Vector Map End ================================
</script>

<script>
      var options = {
        series: [80, 40, 10],
        chart: {
            height: 300,
            type: 'radialBar',
        },
        colors: ['#3D7FF9', '#ff9f29', '#16a34a'], 
        stroke: {
            lineCap: 'round',
        },
        plotOptions: {
            radialBar: {
                hollow: {
                    size: '10%',  // Adjust this value to control the bar width
                },
                dataLabels: {
                    name: {
                        fontSize: '16px',
                    },
                    value: {
                        fontSize: '16px',
                    },
                    // total: {
                    //     show: true,
                    //     formatter: function (w) {
                    //         return '82%'
                    //     }
                    // }
                },
                track: {
                    margin: 20, // Space between the bars
                }
            }
        },
        labels: ['Cardiology', 'Psychiatry', 'Pediatrics'],
    };

    var chart = new ApexCharts(document.querySelector("#radialMultipleBar"), options);
    chart.render();
    // ================================= Multiple Radial Bar Chart End =============================
</script>

<script>
      // ================================ Total Transaction line chart Start ================================ 
  var options = {
    series: [{
      name: "This month",
      data: [4, 16, 12, 28, 22, 38, 23]
    }],
    chart: {
      height: 290,
      type: 'line',
      toolbar: {
        show: false
      },
      zoom: {
        enabled: false
      },
      dropShadow: {
        enabled: true,
        top: 6,
        left: 0,
        blur: 4,
        color: "#000",
        opacity: 0.1,
      },
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth',
      width: 3
    },
    markers: {
      size: 0,
      strokeWidth: 3,
      hover: {
        size: 8
      }
    },
    tooltip: {
      enabled: true,
      x: {
        show: true,
      },
      y: {
        show: false,
      },
      z: {
        show: false,
      }
    },
    grid: {
      row: {
        colors: ['transparent', 'transparent'], // takes an array which will be repeated on columns
        opacity: 0.5
      },
      borderColor: '#D1D5DB',
      strokeDashArray: 3,
    },
    yaxis: {
      labels: {
        formatter: function (value) {
          return "$" + value + "k";
        },
        style: {
          fontSize: "14px"
        }
      },
    },
    xaxis: {
      categories: ['Mon', 'Tues', 'Wed', 'Thurs', 'Fri', 'Sat', 'Sun'],
      tooltip: {
        enabled: false
      },
      labels: {
        formatter: function (value) {
          return value;
        },
        style: {
          fontSize: "14px"
        }
      },
      axisBorder: {
        show: false
      },
      crosshairs: {
        show: true, 
        width: 20,
        stroke: {
          width: 0
        },
        fill: {
          type: 'solid',
          color: '#B1B9C4',
          gradient: {
              colorFrom: '#D8E3F0',
              colorTo: '#BED1E6',
              stops: [0, 100],
              opacityFrom: 0.4,
              opacityTo: 0.5,
          },
        }
      }
    }
  };

  var chart = new ApexCharts(document.querySelector("#transactionLineChartt"), options);
  chart.render();
  // ================================ Total Transaction line chart End ================================ 
</script>


<script>
    var ENDPOINT = "{{ route('dashboard') }}";
    var page = 1;
  
    $(".load-more-tranxdata").click(function(){
        page++;
        infinteLoadMorertranx(page);
    });
    
  
    /*------------------------------------------
    --------------------------------------------
    call infinteLoadMore()
    --------------------------------------------
    --------------------------------------------*/
    function infinteLoadMorertranx(page) {
        $.ajax({
                url: ENDPOINT + "?page=" + page,
                datatype: "html",
                type: "get",
                beforeSend: function () {
                    $('.auto-tranxload').show();
                }
            })
            .done(function (response) {

                console.log(response.newhtmltransaction);
                if (response.newhtmltransaction == '') {
                    $('.auto-tranxload').html("We don't have more data to display :(");
                    return;
                }

                $('.auto-tranxload').hide();
                $("#data-tranxwrapper").append(response.newhtmltransaction);
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('Server error occured');
            });
    }
</script>

@yield('script')

</body>
</html>