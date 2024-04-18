<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $posts = Post::paginate(2);
        // return view('index ', compact('posts'));

    //STORING DATA IN CACHE
        // $posts = Cache::remember('posts', 60, function(){//60 means 60 seconds
        //     return Post::with('category')->paginate(2);
        // });

        // return view('index ', compact('posts'));

    //STORING DATA IN CACHE FOREVER
        // $posts = Cache::rememberForever('posts', function(){
        //     return Post::with('category')->paginate(2);
        // });

        // return view('index ', compact('posts'));

    //USING CACHE WITH PAGINATION
        $posts = Cache::remember('posts-page-'.request('page', 1), 3, function(){
            return Post::with('category')->paginate(3);
        });

        return view('index', compact('posts'));

        // $categories = Category::all();
        // return view('index ', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // AUTHORIZATION GATES
            // Gate::authorize('create_post');
        
        // AUTHORIZATION POLICY
            Gate::authorize('create', Post::class);

        $categories = Category::all();
        return view('create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // AUTHORIZATION GATES
            // Gate::authorize('create_post');

        // AUTHORIZATION POLICY
        Gate::authorize('create', Post::class);

        $request->validate([
            'image' => 'required|max:2028|image',
            'title' => 'required|max:255',
            'category_id' => 'required|integer',
            'description' => 'required',
        ]);

        $filename = time().'_'.$request->image->getClientOriginalName();
        $filePath = $request->image->storeAs('uploads', $filename);

        $post = new Post();
        $post->image = 'storage/'.$filePath;
        $post->title = $request->title;
        $post->description = $request->description;
        $post->category_id = $request->category_id;

        $post->save();
        return redirect('/posts');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $posts = Post::findOrFail($id);
        return view('show', compact('posts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
     {
        // AUTHORIZATION GATES
            // Gate::authorize('edit_post');
        
        $post = Post::findOrFail($id);
        // AUTHORIZATION POLICY
            Gate::authorize('update', $post);
        $categories = Category::all();
        return view('edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // AUTHORIZATION GATES
            // Gate::authorize('edit_post');
        
        $post = Post::findOrFail($id);
        // AUTHORIZATION POLICY
            Gate::authorize('update', $post);

        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|integer',
            'description' => 'required',
        ]);
        
        if($request->hasFile('image')){
            $request->validate([
                'image' => 'required|max:2028|image',
            ]);

            $filename = time().'_'.$request->image->getClientOriginalName();
            $filePath = $request->image->storeAs('uploads', $filename);

            File::delete(public_path($post->image));

            $post->image = 'storage/'.$filePath;
        }

        $post->title = $request->title;
        $post->description = $request->description;
        $post->category_id = $request->category_id;

        $post->save();
        return redirect('/posts');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // AUTHORIZATION GATES
            // Gate::authorize('delete_post');
        
        $post = Post::findOrFail($id);
        // AUTHORIZATION POLICY
        Gate::authorize('delete', $post);

        $post->delete();

        return redirect('/posts');
    }

    public function trashed()
    {
        // AUTHORIZATION GATES
            // Gate::authorize('delete_post');

        $posts = Post::onlyTrashed()->paginate(2);
        // AUTHORIZATION POLICY
        Gate::authorize('create', Post::class);

        return view('trashed', compact('posts'));
    }

    public function restore(string $id)
    {
        // AUTHORIZATION GATES
            // Gate::authorize('delete_post');

        $post = Post::onlyTrashed()->findOrFail($id);    
        // AUTHORIZATION POLICY
            Gate::authorize('delete', $post);

            $post->restore();

        return redirect()->back();
    }

    public function forceDelete(string $id)
    {
        // AUTHORIZATION GATES
            // Gate::authorize('delete_post');

        $post = Post::onlyTrashed()->findOrFail($id); 
        // AUTHORIZATION POLICY
            Gate::authorize('delete', $post);

        File::delete(public_path($post->image));
        $post->forceDelete();
        
        return redirect()->back();
    }
}
