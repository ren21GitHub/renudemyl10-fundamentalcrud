@extends('layouts.master')

@section('content')
<div class="main-content mt-5"> 
    <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-6">
              <h4>Trashed Posts</h4>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
              <a href="{{route('posts.index')}}" class="btn btn-success mx-1">Back</a>
            </div>
          </div>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered border-dark">
                <thead style="background: #f2f2f2">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col" style="width: 1%">Image</th>
                    <th scope="col" style="width: 20%">Title</th>
                    <th scope="col" style="width: 30%">Description</th>
                    <th scope="col" style="width: 10%">Category</th>
                    <th scope="col" style="width: 10%">Publish Date</th>
                    <th scope="col" style="width: 20%">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ( $posts as $post )                    
                  <tr>
                    <th scope="row">{{$post->id}}</th>
                    <td>
                      <img src="{{asset($post->image)}}" alt="" width="80">
                    </td>
                    <td>{{$post->title}}</td>
                    <td>{{$post->description}}</td>
                    <td>{{$post->category->name}}</td>
                    <td>{{date('d-m-y', strtotime($post->created_at))}}</td>
                    <td>
                      <div class="d-flex">
                        <a href="{{route('posts.restore', $post->id)}}" class="btn btn-sm btn-success m-1">Restore</a>
                        <form action="{{route('posts.force_delete', $post->id)}}" method="POST" enctype="multipart/form-data">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-sm btn-danger m-1">Delete</button>
                        </form>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              {{$posts->links()}}
        </div>
    </div>
</div>
@endsection