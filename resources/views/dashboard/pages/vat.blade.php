@extends('dashboard.index')
@section('title')
  SuperAdmin
@endsection
@section('content')


@include('sweetalert::alert') 

<main class="dashboard-main">
  <div class="navbar-header">
  <div class="row align-items-center justify-content-between">
    <div class="col-auto">
      <div class="d-flex flex-wrap align-items-center gap-4">
        <button type="button" class="sidebar-toggle">
          <iconify-icon icon="heroicons:bars-3-solid" class="icon text-2xl non-active"></iconify-icon>
          <iconify-icon icon="iconoir:arrow-right" class="icon text-2xl active"></iconify-icon>
        </button>
        <button type="button" class="sidebar-mobile-toggle">
          <iconify-icon icon="heroicons:bars-3-solid" class="icon"></iconify-icon>
        </button>
        <form class="navbar-search">
          <input type="text" name="search" placeholder="Search">
          <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
        </form>
      </div>
    </div>
    @include('dashboard.subheader')
  </div>
</div> 
  
  <div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
  <h6 class="fw-semibold mb-0">Vat</h6>
  
</div>

   
    <div class="card h-100 radius-12" style="
    height: 400px;
">
       <div class="card-body p-24">
           <div class="row">
               <div class="col-xxl-6 col-xl-8 col-lg-10">
                    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#apiModal">
                          Add API Parameters
                    </button> -->
               </div>
               <div class="col-md-12">
                    <div class="table-responsive" style="margin-top:20px">
                        <table class="table basic-border-table mb-0">
                            <thead>
                            <tr>
                                <th>Sn </th>
                                <th>Name</th>
                                <th>Key</th>
                                 <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                             @php
                                $sn = 1;
                             @endphp
                            
                            @foreach($allvats as $allvat)
                              <tr>
                                 <td>{{$sn++}}</td>
                                 <td>
                                  <span class="badge text-sm fw-semibold text-success-600 bg-success-100 px-20 py-9 radius-4 text-white">{{$allvat->name}}</span>
                                 </td>
                                 <td>
                                  <span class="badge text-sm fw-semibold text-info-600 bg-info-100 px-20 py-9 radius-4 text-white">{{$allvat->vat}}</span>
                                 </td>

                                 <td>
                                       
                                        <button data-id ="{{$allvat->id}}" data-name ="{{$allvat->name}}" data-key ="{{$allvat->vat}}" class="bg-info-focus text-info-main px-32 py-4 rounded-pill fw-medium text-sm editApiBtn" data-bs-toggle="modal" data-bs-target="#updateVatModal">Edit</button>
                                        
                                   
                                 </td>
                              </tr>
                            @endforeach
                            
                            </tbody>
                        </table>
                        </div>
               </div>
           </div> 
       </div>
    </div>

  
<!--update role modal-->
      <div class="modal fade" id="updateVatModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form>
                    @csrf
                     <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Update Api</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                  <label class="form-label">Vat Name</label>
                                  <input type="text" name="name" id="editname" class="form-control" value="{{ old('name') }}">
                                </div>
                                <div class="col-md-6">
                                     <label class="form-label">Vat Value</label>
                                     <input type="text" name="vat" id="editvat" class="form-control">
                                     <input type="hidden" name="id" id="editvat_id" class="form-control">
                                </div>
                            </div>
                            
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button id="updateApiBtn" type="button" class="btn btn-primary">Update</button>
                        </div>
                        
                </form>
            </div>
          </div>
    </div>
  <!--end modal-->  

@endsection

@section('script')
   

<script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
</script>

<script>
        $(document).ready(function() {
            $('.js-example-basic-singleet').select2({
                width: 'resolve'
            });
        });
</script>

<script>
    $(document).ready(function() {
        $('.editApiBtn').click(function(){
          var apiId = $(this).data("id");
          var apiName = $(this).data("name");
          var apiKey = $(this).data("key");
          $('#editvat_id').val(apiId);
          $('#editname').val(apiName);
          $('#editvat').val(apiKey);
          
        });

        $('#updateApiBtn').click(function(e){
            e.preventDefault();
            var updateVatId = $("#editvat_id").val();
            var updateVatName = $("#editname").val();
            var updateVat = $("#editvat").val();
            
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('updatevat')}}",
                type: "POST",
                data : {vat_id:updateVatId,vat_name:updateVatName,vat_value:updateVat},
                success:function(response){
                    if(response.success){
                       alert(response.msg)
                       $('#updateVatModal').modal('hide');
                       location.reload();
                    }else{
                       alert(response.msg)
                    }
                }
            })
        });
    });
</script>

@endsection
  





