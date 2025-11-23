@extends('dashboard.index')
@section('title')
  Dashboard
@endsection
@section('content')

@include('sweetalert::alert')

 @php 
    function shortenBlogContent($content, $limit = 50) {
        $words = explode(" ", strip_tags($content)); // remove HTML first
        if (count($words) <= $limit) {
            return $content;
        }
        return implode(" ", array_slice($words, 0, $limit)) . '...';
    }
 @endphp

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
  <h6 class="fw-semibold mb-0">All Posts</h6>

</div>

        
        <div class="row">
                <div class="col-xxl-6 col-xl-8 col-lg-10 mb-2">
                   
                    <a href="{{route('posts.create')}}" type="button" class="btn btn-primary">Create Post</a>
               </div>
                <div class="col-md-12 mt-3">
                        @if(session('error')) 
                            <div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8 d-flex align-items-center justify-content-between" role="alert">
                                    <div class="d-flex align-items-center gap-2">
                                        {!! session('error') !!} 
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @elseif(session('success'))  
                            <div class="alert alert-success bg-success-100 text-success-600 border-success-100 px-24 py-11 mb-0 fw-semibold text-lg radius-8 d-flex align-items-center justify-content-between" role="alert">
                                    <div class="d-flex align-items-center gap-2">
                                        {!! session('success') !!} 
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>  
                        @endif
                </div>
                
        </div>

   
            <!--new row -->

            <div class="col-lg-12">
                <div class="card h-100">
                    
                    <div class="card-body p-24">
                          
                          @if($allposts->count() > 0)
                              {{$allposts->count()}} Posts
                          @else
                              0
                          @endif
                          <div class=" align-items-center">
                                <div class="row">
                                      <div class="table-responsive">
                                    <table class="table colored-row-table mb-0">
                                        <thead>
                                        <tr>
                                            
                                            <th scope="col" class="bg-base">Thumbnail</th>    
                                            <th scope="col" class="bg-base">Title</th>    
                                            <th scope="col" class="bg-base">Content</th>
                                            <th scope="col" class="bg-base">Date</th>
                                            <th scope="col" class="bg-base">Action</th>    
                                        </tr>
                                        </thead>
                                        <tbody>

                                         @include('dashboard.pages.posts.table_rows')
                                        
                                        
                                        </tbody>
                                    </table>
                                    <div class="text-center mt-3">
                                        @if ($posts->hasMorePages())
                                            <button id="loadMoreBtn" data-next-page="{{ $posts->nextPageUrl() }}" class="btn btn-primary-600">
                                                Load More
                                            </button>
                                        @endif
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).on('click', '#loadMoreBtn', function () {
    var button = $(this);
    var nextPage = button.data('next-page');

    if (!nextPage) return;

    $.get(nextPage, function (response) {
        $('tbody').append(response.rows);

        if (response.next_page) {
            button.data('next-page', response.next_page);
        } else {
            button.remove(); // hide button if no more data
        }
    });
});

</script>


@section('script')
<script>
    function confirmDelete(event) {
        const confirmed = confirm('Are you sure you want to delete this post?');
        if (!confirmed) {
            event.preventDefault(); // Stop form submission
            return false;
        }
        return true; // Allow form to submit
    }
</script>
@endsection




