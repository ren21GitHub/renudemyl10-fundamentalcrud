@extends('layouts.master')

@section('content')
<div class="main-content mt-5"> 
    <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-6">
              <h4>Show Post</h4>
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
                  </tr>
                </thead>
                <tbody>               
                  <tr>
                    <th scope="row">{{$posts->id}}</th>
                    <td>
                      <img src="{{asset($posts->image)}}" alt="" width="80">
                    </td>
                    <td>{{$posts->title}}</td>
                    <td>{{$posts->description}}</td>
                    <td>{{$posts->category->name}}</td>
                    <td>{{date('d-m-y', strtotime($posts->created_at))}}</td>
                  </tr>
                </tbody>
              </table>
        </div>
    </div>
</div>
@endsection