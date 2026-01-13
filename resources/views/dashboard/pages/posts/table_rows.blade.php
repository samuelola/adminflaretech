@php
    // Define an array of background color classes
    $rowColors = ['bg-primary-light', 'bg-success-focus', 'bg-info-focus', 'bg-warning-focus', 'bg-danger-focus'];
@endphp

@foreach($posts as $post)
    @php
        // Use post id to maintain consistent colors even after load more
        $colorClass = $rowColors[$post->id % count($rowColors)];
    @endphp

    <tr>
        
        <td class="{{ $colorClass }}">
            <img src="{{ config('services.external_url.website_storage_link') . '/storage/' . $post->thumbnail }}"
                 class="w-40-px h-40-px rounded-circle">
        </td>
        <td class="{{ $colorClass }}">{{ $post->title }}</td>
        <td class="{{ $colorClass }}">{!! \Str::limit($post->content, 50) !!}</td>
        <td class="{{ $colorClass }}">{{ date("M d, Y", strtotime($post->created_at)) }}</td>
        <td class="{{ $colorClass }}">
            <div class="d-flex align-items-center gap-1">
                <a class="btn btn-info" href="{{ route('posts.edit', $post->id) }}">
                    <iconify-icon icon="tabler:edit" width="16" height="16"></iconify-icon>
                </a>
                <form action="{{ route('posts.destroy', $post->id) }}" 
                      method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this post?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                        <iconify-icon icon="ant-design:delete-outlined" width="16" height="16"></iconify-icon>
                    </button>
                </form>
            </div>
        </td>
    </tr>
@endforeach
