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
  <h6 class="fw-semibold mb-0">Subscription Lists</h6>
  
</div>

   

    <div class="row gy-4 mt-1" style="margin-bottom: 87px;">
      <div class="col-xxl-6 col-xl-12">
        <div class="card h-100" style="padding-bottom: 40px;">
          <div class="card-body">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
              <h6 class="text-lg mb-0">Users Subscription</h6>
              
            </div>
             <!--start-->
            <div class="row gy-4 mt-3" id="data-wrapperallsub">

            <form method="GET" class="row mb-4">
        <!-- <div class="col-md-3">
            <input type="text" name="user_id" class="form-control"
                   placeholder="User ID" value="{{ request('user_id') }}">
        </div> -->

        <div class="col-md-3">
            <input type="text" name="email" class="form-control"
                   placeholder="Email" value="{{ request('email') }}">
        </div>

        <div class="col-md-3">
            <select name="status" class="form-control">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="notactive" {{ request('status') == 'notactive' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <div class="col-md-3">
            <button class="btn btn-primary">Filter</button>
            <a href="{{ route('cancel_user_subscription') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>
                
                   @if($subscriptions->isEmpty())
        <p>You have no subscriptions.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Users</th>
                    <th>Email</th>
                    <th>Plan</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th>Expires At</th>
                    <th>Action</th>
                </tr>
            </thead>
                        <tbody>
                            @foreach($subscriptions as $sub)
                                <tr>
                                    <td>
                                        {{$sub->first_name}} {{$sub->last_name}}
                                    </td>
                                    <td>
                                        {{$sub->email}}
                                    </td>
                                    <td>{{ $sub->subscription_name }}</td>
                                    <td>
                                        <span class="badge 
                                            {{ $sub->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($sub->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $sub->start_date ? \Carbon\Carbon::parse($sub->start_date)->format('Y-m-d') : '-' }}</td>
                                    <td>
                                        {{ $sub->expires_at ? \Carbon\Carbon::parse($sub->expires_at)->format('Y-m-d') : '-' }}
                                    </td>
                                    <td>
                                        @if($sub->status === 'active')
                                            <form method="POST" 
                                                action="{{ route('subscription.cancel', $sub->sub_count_id) }}"
                                                onsubmit="return confirm('Are you sure you want to cancel this subscription?')">
                                                @csrf
                                                @method('PUT')
                                                <button class="btn btn-danger btn-sm">
                                                    Cancel Subscription
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">Not Available</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $subscriptions->links() }}
                @endif
                    
                </div>
           

            </div>
             <!--end start-->
          
          </div>
      </div>
    </div>
  </div>

@endsection



