<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use File;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::paginate(2);
        return view('index ', compact('posts'));

        // $categories = Category::all();
        // return view('index ', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        $post = Post::findOrFail($id);
        $categories = Category::all();
        return view('edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|integer',
            'description' => 'required',
        ]);

        $post = Post::findOrFail($id);

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
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect('/posts');
    }

    public function trashed()
    {
        $posts = Post::onlyTrashed()->get();
        return view('trashed', compact('posts'));
    }

    public function restore(string $id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->back();
    }

    public function forceDelete(string $id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        File::delete(public_path($post->image));
        $post->forceDelete();
        
        return redirect()->back();
    }
}
