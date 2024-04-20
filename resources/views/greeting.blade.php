@extends('layouts.master')

@section('content')
    {{-- <h1>{{__('frontend.test')}}</h1> --}}

{{--  Defining and Retrieving Translation Strings --}}
    <div>
        <div class="">
        {{-- CHANGE TRANSLATION DEPENDING ON ROUTE --}}
            <a href="{{route('greeting', 'en')}}" class="btn btn-primary">English</a>
            <a href="{{route('greeting', 'hi')}}" class="btn btn-danger">Hindi</a>
        </div>
        <div class="display-3">{{__('frontend.Welcome to our application')}}</div>
        <p>{{__('frontend.Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cumque enim nisi quaerat beatae, autem praesentium aperiam! Blanditiis, provident sed. Iure suscipit, rerum cum aspernatur corporis deserunt sunt magni alias consequuntur?')}}</p>

        <div class="row">
            <ul class="row">
                <li>{{__('frontend.Home')}}</li>
                <li>{{__('frontend.About')}}</li>
                <li>{{__('frontend.Contact')}}</li>
                <li>{{__('frontend.More')}}</li>
            </ul>
        </div>
    </div>
@endsection