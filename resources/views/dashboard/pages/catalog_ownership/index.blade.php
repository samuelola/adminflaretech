@extends('dashboard.index')
@section('title')
  Dashboard
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
  <h6 class="fw-semibold mb-0">All Catalog Ownership Songs</h6>

</div>

        <div class="row">
                <div class="col-md-12">
                        @if(session('error'))
                            
                            <div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8 d-flex align-items-center justify-content-between" role="alert">
                                    <div class="d-flex align-items-center gap-2">
                                        
                                        {!! session('error') !!} 
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                </div>
        </div>

   
            <!--new row -->
            <div class="row">
                 <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">Catalog</h5>
          </div>
            <div class="card-body">
            <div class="table-responsive">
              <table class="table bordered-table mb-0">
                <thead>
                  <tr>
                    <th>Artist</th>
                    <th scope="col">Stage Name</th>
                    <th scope="col">Catalog Id</th>
                    <th scope="col">DOB</th>
                    <th scope="col">Nationality</th>
                    <th scope="col">Country</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Email</th>
                    <th scope="col">ID Type</th>
                    <th scope="col">ID Upload</th>
                    <th scope="col">Created Date</th>
                    <th scope="col">View Song</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                     @if(!is_null($get_uploadsongs))
  
                            @foreach($get_uploadsongs as $value)
                            <tr>
                                <td>{{$value->full_name}}</td>    
                                <td>{{$value->stage_name}}</td>
                                <td>{{$value->artist_code}}</td>
                                <td>{{$value->dob}}</td> 
                                <td>{{$value->nationality}}</td>
                                <td>{{$value->country}}</td>
                                <td>{{$value->phone}}</td>
                                <td>{{$value->email}}</td>
                                <td>{{$value->id_type}}</td>            
                                <td>
                                    
                                    @if(!empty($value->government_id_path))
                                        @php
                                            $govtPath = $value->government_id_path ?? 'default.jpg';
                                            $storageUrl = rtrim(config('services.external_url.website_storage_link'), '/');
                                        @endphp
                                    <button 
                                        class="btn btn-sm btn-primary-600 view-id-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#idModal"
                                        data-image="{{ $storageUrl . '/storage/' . ltrim($govtPath, '/') }}">
                                        View ID
                                    </button>
                                    @else 
                                       <p>No Image</p>
                                    @endif
                                </td>
                                <td>
                                    {{\Carbon\Carbon::parse($value->created_at)->format('d-m-Y')}}
                                </td>
                                <td><a href="{{route('artist-song',encrypt($value->id))}}" class="btn btn-primary-600">Songs</a></td>
                                <td>
                                    <form method="post" action="{{route('create_metadata',encrypt($value->id))}}"> 
                                      @csrf
                                        <button type="submit" class="btn btn-primary-600">
                                            Create Metadata
                                        </button>
                                    </form>
                                    
                                    
                                </td>
                            </tr>
                        @endforeach


                        @else

                            <p style="text-align:center">No Data avaliable</p

                        @endif



                </tbody>
              </table>

              <div class="modal modal-lg fade" id="idModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    
                    <div class="modal-header">
                        <h5 class="modal-title">ID Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body text-center">
                        <img id="idImage" src="" class="img-fluid" alt="ID Image">
                    </div>

                    </div>
                </div>
              </div>
                
          </div>
        </div>
            </div>   
            <!--end new row-->
          
          </div>
      </div>
    </div>
  </div>

@endsection

@section('script')
   <script>
    document.addEventListener("DOMContentLoaded", function () {
        const buttons = document.querySelectorAll(".view-id-btn");
        const modalImage = document.getElementById("idImage");

        buttons.forEach(button => {
            button.addEventListener("click", function () {
                const imagePath = this.getAttribute("data-image");
                modalImage.src = imagePath;
            });
        });
    });
</script>
@endsection



