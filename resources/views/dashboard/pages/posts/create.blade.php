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
  <h6 class="fw-semibold mb-0">Create Post</h6>

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
                          <div class=" align-items-center">
                                      <div class="row">
                                                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                            <div class="col-md-6">
                                                                  <div class="mb-3">
                                                                      <label for="title">Title:</label>
                                                                      <input type="text" name="title" class="form-control">
                                                                      @error('title')
                                                                      <p class="text-red-500 text-sm" style="color:#d22f2f">{{ $message }}</p>
                                                                      @enderror
                                                                  </div>
                                                            </div>      
                                                            <div class="col-md-6">
                                                                  <div class="mb-3">
                                                                      <label for="title">Thumbnail:</label>
                                                                      <input type="file" name="thumbnail" class="form-control">
                                                                      @error('thumbnail')
                                                                      <p class="text-red-500 text-sm" style="color:#d22f2f">{{ $message }}</p>
                                                                      @enderror
                                                                  </div>
                                                           </div>

                                                          <div class="row">
                                                             <div class="col-md-6">
                                                                 <div class="mb-3">
                                                                      <label for="title">Add Youtube Link:</label>
                                                                      <input type="text" name="youtube_link" class="form-control" placeholder="https://youtu.be/...">
                                                                      @error('youtube_link')
                                                                      <p class="text-red-500 text-sm" style="color:#d22f2f">{{ $message }}</p>
                                                                      @enderror
                                                                  </div>
                                                             </div>
                                                             <div class="col-md-6">
                                                                   <div class="mb-3">
                                                                      <label for="title">Tags (separate with commas):</label>
                                                                      <input type="text" name="tags" placeholder="e.g. Lyrics, Song, flave" class="form-control">
                                                                      @error('tags')
                                                                      <p class="text-red-500 text-sm" style="color:#d22f2f">{{ $message }}</p>
                                                                      @enderror
                                                                  </div>
                                                             </div>
                                                          </div>

                                                          <div class="row">
                                                              <div class="col-md-6">
                                                                   <div class="mb-3">
                                                                      <label for="title">Categories:</label>
                                                                     
                                                                      <select name="category_id" class="form-control js-example-basic-single" style="width: 100% !important">
                                                                          <option value="">-- Select Category --</option>
                                                                          @foreach($categories as $category)
                                                                              <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                          @endforeach
                                                                       </select>
                                                                      @error('category_id')
                                                                      <p class="text-red-500 text-sm" style="color:#d22f2f">{{ $message }}</p>
                                                                      @enderror
                                                                  </div>
                                                             </div>
                                                          </div>

                                                          <div class="col-md-12">
                                                              <div class="mb-3">
                                                                <label for="content">Content:</label>
                                                                <!-- <textarea name="content" id="editor" class="form-control"></textarea> -->
                                                                <textarea name="content" id="editor1" class="form-control"></textarea>
                                                              </div>
                                                          </div>
                                                          
                                                          <div class="col-md-12">
                                                              <div class="mb-3">
                                                                <button type="submit" class="btn btn-primary-600">Publish</button>
                                                              </div>
                                                          </div>  

                                                    
                                                    </div>
                                                    
                                                    
                                                </form>
                                          
                                          
                                      
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

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
   CKEDITOR.replace('editor1', {
        filebrowserUploadUrl: "{{ route('upload.image') }}?_token={{ csrf_token() }}",
        filebrowserImageUploadUrl: "{{ route('upload.image') }}?_token={{ csrf_token() }}",
    });

    CKEDITOR.on('instanceReady', function(evt) {
  // Override notification system to disable warnings
        evt.editor.showNotification = function() {
          return { update: function(){}, hide: function(){} };
        };
      });
</script>

<script>
document.getElementById('thumbnail').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const status = document.getElementById('thumbnailStatus');

    if (!file) return;

    status.textContent = 'Uploading...';

    // Simulate upload process (replace this with actual AJAX upload if needed)
    const formData = new FormData();
    formData.append('thumbnail', file);

    fetch('{{ route("posts.store") }}', {  // This should point to a route that handles only thumbnail if async
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        if (response.ok) {
            status.textContent = 'Uploaded';
        } else {
            status.textContent = 'Upload failed';
        }
    })
    .catch(err => {
        console.error(err);
        status.textContent = 'Upload failed';
    });
});
</script>

<script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
</script>
@endsection






