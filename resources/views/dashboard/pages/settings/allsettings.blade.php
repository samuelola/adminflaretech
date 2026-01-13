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
  <h6 class="fw-semibold mb-0">Add API Parameters</h6>
  
</div>

   
    <div class="card h-100 radius-12" style="
    height: 400px;
">
       <div class="card-body p-24">
           <div class="row">
               <div class="col-xxl-6 col-xl-8 col-lg-10">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#apiModal">
                          Add API Parameters
                    </button>
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
                            
                            @foreach($allapis as $allapi)
                              <tr>
                                 <td>{{$sn++}}</td>
                                 <td>
                                  <span class="badge text-sm fw-semibold text-success-600 bg-success-100 px-20 py-9 radius-4 text-white">{{$allapi->api_name}}</span>
                                 </td>
                                 <td>
                                  <span class="badge text-sm fw-semibold text-info-600 bg-info-100 px-20 py-9 radius-4 text-white">{{$allapi->api_key}}</span>
                                 </td>

                                 <td>
                                       @if($allapi->status == 2)
                                            <button data-id ="{{$allapi->id}}" data-key ="{{$allapi->api_key}}" class="bg-success-focus text-info-main px-32 py-4 rounded-pill fw-medium text-sm apiProcess">
                                               <iconify-icon icon="material-symbols-light:refresh-rounded" width="24" height="24" style="color:green;"></iconify-icon>
                                            </button>
                                       @endif
                                        <button data-id ="{{$allapi->id}}" data-name ="{{$allapi->api_name}}" data-key ="{{$allapi->api_key}}" class="bg-info-focus text-info-main px-32 py-4 rounded-pill fw-medium text-sm editApiBtn" data-bs-toggle="modal" data-bs-target="#updateApiModal">Edit</button>
                                        
                                   
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

    

  <!--create role modal-->
      <div class="modal fade" id="apiModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form>
                    @csrf
                     <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add API Parameters</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                  <label class="form-label">Api Name</label>
                                  <input type="text" name="name" id="name" class="form-control" placeholder="Enter Api Name" value="{{ old('name') }}">
                                </div>
                                <div class="col-md-6">
                                     <label class="form-label">Api Key</label>
                                     <input type="text" name="api_key" id="api_key" class="form-control" placeholder="Enter Key" value="{{ old('name') }}">
                                </div>
                            </div>
                            
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button id="createApiForm" type="button" class="btn btn-primary">Create</button>
                        </div>
                        
                </form>
            </div>
          </div>
    </div>
  <!--end modal-->

  <!--start modal-->
 
<!-- delete role Modal -->
<div class="modal fade" id="deleteRoleModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form>
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="role_id" id="deleteRoleId"/>
                <p>Are you sure you want to delete the <span class="delete-role text-white bg-lilac-600 border border-lilac-600 radius-4 px-8 py-4 text-sm line-height-1 fw-medium"></span> Role?</p>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="deleteFormRole" type="button" class="btn btn-primary">Delete</button>
            </div>
        </form>
    </div>
  </div>
</div>
  <!--end modal-->


<!--update role modal-->
      <div class="modal fade" id="updateApiModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                  <label class="form-label">Api Name</label>
                                  <input type="text" name="name" id="editapi_name" class="form-control" placeholder="Enter Api Name" value="{{ old('api_name') }}">
                                </div>
                                <div class="col-md-6">
                                     <label class="form-label">Api Key</label>
                                     <input type="text" name="api_key" id="editapi_key" class="form-control" placeholder="Enter Key">
                                     <input type="hidden" name="id" id="editapi_id" class="form-control" placeholder="Enter Key">
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
        $("#createApiForm").click(function(e){
            e.preventDefault();
            $("#createApiForm").prop('disabled',true)
            var api_name = $("#name").val();
            var api_key = $("#api_key").val();
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('createsettings')}}",
                type: "POST",
                data : {api_name:api_name,api_key:api_key},
                success:function(response){
                    $("#createApiForm").prop('disabled',false)
                    if(response.success){
                       alert(response.msg)
                       $('#apiModal').modal('hide');
                       location.reload();
                    }else{
                       alert(response.msg)
                    }
                }
            })
        })

        $('.deleteRoleBtn').click(function(){
          var apiId = $(this).data("id");
          var apiName = $(this).data("name");
          var apiName = $(this).data("key");

          $('.delete-role').text(roleName);
          $('#deleteRoleId').val(roleId);

        });

         $("#deleteFormRole").click(function(e){
            e.preventDefault();
            var deleterole = $("#deleteRoleId").val();
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('delete_role')}}",
                type: "POST",
                data : {role_id:deleterole},
                success:function(response){
                    if(response.success){
                       alert(response.msg)
                       $('#deleteRoleModal').modal('hide');
                       location.reload();
                    }else{
                       alert(response.msg)
                    }
                }
            })
        })


        $('.editApiBtn').click(function(){
          var apiId = $(this).data("id");
          var apiName = $(this).data("name");
          var apiKey = $(this).data("key");
          $('#editapi_id').val(apiId);
          $('#editapi_name').val(apiName);
          $('#editapi_key').val(apiKey);
          
        });



        $('#updateApiBtn').click(function(e){
            e.preventDefault();
            var updateApiId = $("#editapi_id").val();
            var updateApiName = $("#editapi_name").val();
            var updateApiKey = $("#editapi_key").val();
            
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('updatesettings')}}",
                type: "POST",
                data : {api_id:updateApiId,api_name:updateApiName,api_key:updateApiKey},
                success:function(response){
                    if(response.success){
                       alert(response.msg)
                       $('#updateApiModal').modal('hide');
                       location.reload();
                    }else{
                       alert(response.msg)
                    }
                }
            })
        });

        
        
    }); 

</script>

<script>
  $('.apiProcess').click(function(e){
      var apiId = $(this).data("id");
      var apiKey = $(this).data("key");  
      $.ajax({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: "{{route('apiexchangerate')}}",
          type: "POST",
          data : {api_id:apiId,api_key:apiKey},
          success:function(response){
              if(response.success){
                  alert(response.msg)
                  location.reload();
              }else{
                  alert(response.msg)
              }
          }
     })

  });
  

</script>


    
    
@endsection
  





