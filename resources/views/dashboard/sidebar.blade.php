<aside class="sidebar">
  @php
  $permissionUser = App\Models\PermissionRole::getPermission('users',Auth::user()->role_id);
  $permissionSubscription = App\Models\PermissionRole::getPermission('Subscription',Auth::user()->role_id);
  $permissionaddsub = App\Models\PermissionRole::getPermission('add-subscription',Auth::user()->role_id);
  $permissionaddallsub = App\Models\PermissionRole::getPermission('all-subscriptions',Auth::user()->role_id);
  $permissionroles = App\Models\PermissionRole::getPermission('Roles',Auth::user()->role_id);
  $permissionPermissions = App\Models\PermissionRole::getPermission('Permissions',Auth::user()->role_id);
  $permissionedituserPermission = App\Models\PermissionRole::getPermission('delete-users',Auth::user()->role_id);
  $permissiondeleteuserPermission = App\Models\PermissionRole::getPermission('edit-users',Auth::user()->role_id);
  $permissionchooseSubscriptionPermission = App\Models\PermissionRole::getPermission('choose_subscription',Auth::user()->role_id);
  @endphp
  <button type="button" class="sidebar-close-btn">
    <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
  </button>
  <div>
    
    <a href="{{ config('services.external_url.website') }}" class="sidebar-logo">
      <img src="{{asset('flare_main.png')}}" alt="site logo" class="light-logo" style="width:200px;">
      <img src="{{asset('flare_main.png')}}" alt="site logo" class="dark-logo" style="width:50px;">
      <img src="{{asset('flare_logo2.png')}}" alt="site logo" class="logo-icon" style="width:50px;">
      <!-- <img src="assets/images/logo.png" alt="site logo" class="light-logo">
      <img src="assets/images/logo-light.png" alt="site logo" class="dark-logo">
      <img src="assets/images/logo-icon.png" alt="site logo" class="logo-icon"> -->
    </a>
  </div>
  <div class="sidebar-menu-area">
    <ul class="sidebar-menu" id="sidebar-menu">
      <li class="sidebar-menu-group-title">Application</li>
      <li>
        <a href="{{route('dashboard')}}">
          <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
          <span>Dashboard</span>
        </a>
      </li>

      <!-- <li>
        <a href="{{route('allUser')}}">
        <iconify-icon icon="raphael:users" width="16" height="16"  class="menu-icon"></iconify-icon>
           <span>Users</span> 
        </a>
       
      </li> -->

      @if(!empty($permissionUser))
      <li class="dropdown">
        <a href="javascript:void(0)" class="menu-icon">
        <iconify-icon icon="raphael:users" width="16" height="16" style="margin-inline-end: 0.4rem;"></iconify-icon>
          <span>Users</span> 
        </a>
        <ul class="sidebar-submenu">
          <li>
            <a href="{{route('allUser')}}">
              <iconify-icon icon="bi:dash" width="16" height="16"></iconify-icon>
              All Users</a>
          </li>
          <li>
            <a href="{{route('allActiveUser')}}">
              <iconify-icon icon="bi:dash" width="16" height="16"></iconify-icon>
              Active Users</a>
          </li>
          <li>
            <a href="{{route('allInactiveUser')}}">
              <iconify-icon icon="bi:dash" width="16" height="16"></iconify-icon>
              Inactive Users</a>
          </li>

          <li>
            <a href="{{route('all_deleted_user')}}">
              <iconify-icon icon="bi:dash" width="16" height="16"></iconify-icon>
              Deleted Users</a>
          </li>
          
        </ul>
      </li>
      @endif
      

      @if(!empty($permissionSubscription))
      <li class="dropdown">
        <a href="javascript:void(0)">
        <iconify-icon icon="streamline:subscription-cashflow" width="16" height="16"  class="menu-icon"></iconify-icon>
          <span>Subscription</span> 
        </a>
        <ul class="sidebar-submenu">
          @if(!empty($permissionaddsub))
          <li>
            <a href="{{route('subscription')}}"><iconify-icon icon="bi:dash" width="16" height="16"></iconify-icon>Add Subscription</a>
          </li>
          @endif  

          @if(!empty($permissionaddallsub))
          <li>
          
            <a href="{{route('allsubscription')}}"><iconify-icon icon="bi:dash" width="16" height="16"></iconify-icon>All Subscriptions</a>
          </li>
          @endif  
          @if(!empty($permissionchooseSubscriptionPermission))
          <li>
          
            <a href="{{route('choosesubscription')}}"><iconify-icon icon="bi:dash" width="16" height="16"></iconify-icon>Choose Subscriptions</a>
          </li>
          @endif
         
        </ul>
      </li>
      @endif

      <li>
        <a href="{{route('allTracks')}}">
        <iconify-icon icon="material-symbols-light:track-changes" width="20" height="20" class="menu-icon"></iconify-icon>
           <span>Tracks</span> 
        </a>
       
      </li>

      <li>
        <a href="{{route('admin_analytics')}}">
        <!-- <iconify-icon icon="material-symbols-light:track-changes" width="16" height="16"></iconify-icon> -->
        <iconify-icon icon="pixel:analytics" width="16" height="16" class="menu-icon"></iconify-icon>
           <span>Analytics</span> 
        </a>
       
      </li>

      
    @if(!empty($permissionroles))  
      <li>
        <a href="{{route('manage_role')}}">
        
        <iconify-icon icon="oui:app-users-roles" width="20" height="20" class="menu-icon"></iconify-icon>
           <span>Roles</span> 
        </a>
       
      </li>
    @endif
      
   
    @if(!empty($permissionPermissions)) 
       <li class="dropdown">
        <a href="javascript:void(0)">
        <iconify-icon icon="icon-park:permissions" width="20" height="20" class="menu-icon"></iconify-icon>
          <span>Permissions</span> 
        </a>
        <ul class="sidebar-submenu">
          <li>
            <a href="{{route('manage_permission')}}"><iconify-icon icon="bi:dash" width="16" height="16"></iconify-icon>Manage Permissions</a>
          </li>
          <li>
            <a href="{{route('assign_permission_role')}}"><iconify-icon icon="bi:dash" width="16" height="16"></iconify-icon>Assign Permission Role</a>
          </li>
          
        </ul>
      </li>
    @endif
      

      

      <li>
        <a href="{{route('transactions')}}">
        <iconify-icon icon="tdesign:undertake-transaction" width="16" height="16" class="menu-icon"></iconify-icon>
           <span>Transactions</span> 
        </a>
       
      </li>

      <li>
        <a href="{{route('messages.create')}}">
        <iconify-icon icon="ant-design:message-outlined" width="16" height="16" class="menu-icon"></iconify-icon>
           <span>Message</span> 
        </a>
       
      </li>

      

      

      <li class="dropdown">
        <a href="javascript:void(0)">
        <iconify-icon icon="arcticons:canada-post" width="16" height="16" class="menu-icon"></iconify-icon>
          <span>Post</span> 
        </a>
        <ul class="sidebar-submenu">
          <li>
            <a href="{{route('posts.create')}}"><iconify-icon icon="bi:dash" width="16" height="16"></iconify-icon>Create Post</a>
          </li>
          <li>
            <a href="{{route('posts.index')}}"><iconify-icon icon="bi:dash" width="16" height="16"></iconify-icon>All Posts</a>
          </li>
          
        </ul>
      </li>

      
       <li class="dropdown">
            <a href="javascript:void(0)">
           
            <iconify-icon icon="carbon:change-catalog" width="16" height="16" class="menu-icon"></iconify-icon>
              <span>Catalog/Releases</span> 
            </a>
            <ul class="sidebar-submenu">
              <li>
                <a href="{{route('music_product')}}"><iconify-icon icon="bi:dash" width="16" height="16"></iconify-icon>Products</a>
              </li>
              <li>
                <a href="{{route('approve_music_product')}}"><iconify-icon icon="bi:dash" width="16" height="16"></iconify-icon>Approved Products</a>
              </li>
              
            </ul>
       </li>  

      

      <li class="dropdown">
        <a href="javascript:void(0)" class="menu-icon">
        <iconify-icon icon="hugeicons:payment-02" width="16" height="16" style="margin-inline-end: 0.4rem;" class="menu-icon"></iconify-icon>
          <span>Payout</span> 
        </a>
        <ul class="sidebar-submenu">
          <li>
            <a href="{{route('payment')}}">
              <iconify-icon icon="bi:dash" width="16" height="16"class="menu-icon"></iconify-icon>
              Payments</a>
          </li>
          <li>
            <a href="{{route('earnings')}}">
              <iconify-icon icon="bi:dash" width="16" height="16" class="menu-icon"></iconify-icon>
              Earnings</a>
          </li>
          <!-- <li>
            <a href="{{route('split_sheet')}}">
              <iconify-icon icon="bi:dash" width="16" height="16"></iconify-icon>
              Split Sheet</a>
          </li> -->
        </ul>
      </li>

      <li class="dropdown">
        <a href="javascript:void(0)" class="menu-icon">
        <iconify-icon icon="material-symbols-light:settings-outline" width="16" height="16" style="margin-inline-end: 0.4rem;" class="menu-icon"></iconify-icon>  
          <span>Settings</span> 
        </a>
        <ul class="sidebar-submenu">
          <li>
            <a href="{{route('settings')}}">
              <iconify-icon icon="bi:dash" width="16" height="16" class="menu-icon"></iconify-icon>
              API</a>
          </li>
        </ul>
      </li>

      
      <li>
        <a href="{{ route('dashboard.logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
         <iconify-icon icon="lucide:power" class="menu-icon" class="menu-icon"></iconify-icon>
           <span>Logout</span> 
        </a>
        <form id="frm-logout" action="{{ route('dashboard.logout') }}" method="POST" style="display: none;">
                 @csrf
        </form>
      </li>
      
    </ul>
  </div>
</aside>