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
  <h6 class="fw-semibold mb-0">Message</h6>
  
</div>

            @if(session('success'))
                
                <!-- <div class="fade show alert alert-dismissible alert-danger bg-danger-600 text-white border-danger-600 px-24 py-11 mb-0 fw-semibold text-lg radius-8 d-flex align-items-center justify-content-between" role="alert">
                    {!! session('error') !!}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div> -->
                <div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8 d-flex align-items-center justify-content-between" role="alert">
                        <div class="d-flex align-items-center gap-2">
                            
                            {!! session('success') !!} 
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

    <div class="card h-100 p-0 radius-12">
       <div class="card-body p-24">
           <div class="row justify-content-center">
               <div class="col-xxl-6 col-xl-8 col-lg-10">
                    <div class="card border">
                        <div class="card-body">
                            <form action="{{ route('messages.store') }}" method="post">
                                @csrf
                                 <div class="row mb-3">
                                        <div class="col-md-6">

                                          <label class="form-label" style="display: block;">Artist</label>
                                          <select name="receiver_id" class="js-example-basic-single" style="width: 100% !important">
                                                  <option>Select Artist</option>  
                                                    @foreach($users as $user)
                                                      <option value="{{ $user->id }}">{{ ucfirst($user->email) }}</option>
                                                    @endforeach
                                          </select>
                                          @error('receiver_id')
                                              <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                          @enderror 
                                        </div> 
                                        <div class="col-md-6">
                                            <label class="form-label">Subject</label>
                                            <input type="text" name="subject" class="form-control" placeholder="Subject" value="{{ old('subject') }}">
                                            @error('subject')
                                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror  
                                        </div>
                                </div>
                                <div class="row mb-3">
                                  <div class="col-md-12">
                                      <label class="form-label">Message</label>
                                          <textarea name="body" class="form-control" style="height: 182px;"></textarea>
                                          @error('body')
                                              <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                          @enderror 
                                          
                                      </div> 
                                      
                                </div>
                               

                                

                            

                            

                            <div class="d-flex align-items-center justify-content-center gap-3" style="margin-top:20px;">
                                <!-- <button type="button" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8"> 
                                    Cancel
                                </button> -->
                                <button type="submit" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8"> 
                                    Save
                                </button>
                                
                            </div>
                          </form>
                        </div>
                    </div>
               </div>
           </div> 
       </div>
    </div>
@endsection


  





