<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Support\Facades\Http;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        // $posts = Post::all();
        // return view('dashboard.pages.posts.index',compact('posts'));
        
        $allposts = Post::all();
        $posts = Post::latest()->paginate(5);
        if ($request->ajax()) {
            return response()->json([
                'rows' => view('dashboard.pages.posts.table_rows', compact('posts'))->render(),
                'next_page' => $posts->nextPageUrl()
            ]);
        }

        return view('dashboard.pages.posts.index', compact('posts','allposts'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.pages.posts.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        
        $slug = \Str::slug($request->title);
        $count = Post::where('slug', 'LIKE', "$slug%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        if($request->hasFile('thumbnail')){
            
            $file = $request->file('thumbnail');
            $newFileName = time() . '.' . $file->getClientOriginalExtension();
            $response = Http::withHeaders([
                'X-APP-A-KEY' => env('APP_A_API_KEY'),
                    ])
                        ->attach(
                            'thumbnail',
                            file_get_contents($file->getRealPath()),
                            $newFileName
                        )->post(config('services.external_url.website_storage_link')."/api/upload_thumbnail");
            
        }

        if ($response->failed()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Upload failed'
                ], 500);
        }

        $data = $response->json();

        $post = Post::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'thumbnail' => $data['path'],
            'youtube_link' => $request->youtube_link,
            'category_id' => $request->category_id,
        ]);

        //Attach tags
        if ($request->tags) {
        $tagNames = array_map('trim', explode(',', $request->tags));
        $tagIds = [];

            foreach ($tagNames as $tagName) {
                $tagIds[] = Tag::firstOrCreate(['name' => strtolower($tagName)])->id;
            }

            $post->tags()->sync($tagIds);
        }
        
        if($post){
            session()->flash('success', "Post created is successful");
            return redirect()->route('posts.index');
        }else{
            session()->flash('error', "Post Creation failed");
            return redirect()->back();
        } 
        

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::find($id);
        $categories = Category::all();
        return view('dashboard.pages.posts.edit',compact('post','categories'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdatePostRequest $request, Post $post)
    {
        
        // Generate slug if title changed
        if ($request->title !== $post->title) {
            $slug = \Str::slug($request->title);
            $count = Post::where('slug', 'LIKE', "$slug%")
                        ->where('id', '!=', $post->id)
                        ->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }
        } else {
            $slug = $post->slug;
        }

        $thumbnailPath = $post->thumbnail; // default to existing thumbnail

        // Handle new thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $newFileName = time() . '.' . $file->getClientOriginalExtension();

            // Delete old thumbnail if exists
            if ($post->thumbnail) {
                try {
                    
                    Http::withHeaders([
                        'X-APP-A-KEY' => env('APP_A_API_KEY')
                    ])->post(config('services.external_url.website_storage_link')."/api/delete_thumbnail", [
                        'path' => $post->thumbnail
                    ]);
                } catch (\Exception $e) {
                    // Log error but continue
                    \Log::error("Failed to delete old thumbnail: ".$e->getMessage());
                }
            }

            // Upload new thumbnail
            $response = Http::withHeaders([
                'X-APP-A-KEY' => env('APP_A_API_KEY'),
            ])->attach(
                'thumbnail',
                file_get_contents($file->getRealPath()),
                $newFileName
            )->post(config('services.external_url.website_storage_link')."/api/upload_thumbnail");

            if ($response->failed()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Upload failed'
                ], 500);
            }

            $data = $response->json();
            $thumbnailPath = $data['path'];
        }

        // Update post
        $post->update([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'thumbnail' => $thumbnailPath,
            'youtube_link' => $request->youtube_link,
            'category_id' => $request->category_id,
        ]);

        // Update tags
        if ($request->tags) {
            $tagNames = array_map('trim', explode(',', $request->tags));
            $tagIds = [];
            foreach ($tagNames as $tagName) {
                $tagIds[] = Tag::firstOrCreate(['name' => strtolower($tagName)])->id;
            }
            $post->tags()->sync($tagIds);
        } else {
            $post->tags()->sync([]);
        }

        session()->flash('success', "Post updated successfully");
        return redirect()->route('posts.index');
    }



    

    /**
     * Remove the specified resource from storage.
     */
        public function destroy(string $id){
        // Find the post
        $post = Post::findOrFail($id);

        // Detach related tags (pivot delete)
        $post->tags()->detach();

        // Delete old thumbnail if exists
         if ($post->thumbnail) {
                try {
                    
                    Http::withHeaders([
                        'X-APP-A-KEY' => env('APP_A_API_KEY')
                    ])->post(config('services.external_url.website_storage_link')."/api/delete_thumbnail", [
                        'path' => $post->thumbnail
                    ]);
                } catch (\Exception $e) {
                    // Log error but continue
                    \Log::error("Failed to delete old thumbnail: ".$e->getMessage());
                }
            }

        // Delete post record
        $post->delete();

        // Return response
        return redirect()
            ->route('posts.index')
            ->with('success', 'Post deleted successfully!');
    }

}
