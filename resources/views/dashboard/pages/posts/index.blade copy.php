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

                                          <div class="col-md-3"></div>
                                          <div class="col-md-6">
                                                <form action="{{ route('posts.store') }}" method="POST">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="title">Title:</label>
                                                        <input type="text" name="title" class="form-control">
                                                        @error('title')
                                                        <p class="text-red-500 text-sm" style="color:#d22f2f">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="title">Thumbnail:</label>
                                                        <input type="file" name="thumbnail" class="form-control">
                                                        @error('thumbnail')
                                                        <p class="text-red-500 text-sm" style="color:#d22f2f">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label for="content">Content</label>
                                                        <textarea name="content" id="editor" class="form-control"></textarea>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary-600">Publish</button>
                                                </form>
                                          </div>
                                          <div class="col-md-3"></div>
                                      
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
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>

<script>
class MyUploadAdapter {
    constructor(loader) {
        this.loader = loader;
    }

    // Starts the upload process.
    upload() {
        return this.loader.file.then(file => new Promise((resolve, reject) => {
            const formData = new FormData();
            formData.append('upload', file);

            fetch("{{ route('upload.image') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.url) {
                    resolve({ default: result.url });
                } else {
                    reject(result.error || 'Upload failed');
                }
            })
            .catch(err => reject(err));
        }));
    }

    // Optional (abort upload)
    abort() {}
}

function MyCustomUploadAdapterPlugin(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        return new MyUploadAdapter(loader);
    };
}



ClassicEditor
    .create(document.querySelector('#editor'), {
        extraPlugins: [ MyCustomUploadAdapterPlugin ],
        
    })
    .catch(error => { console.error(error); });
</script>
@endsection



