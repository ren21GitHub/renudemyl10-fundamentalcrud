@extends('layouts.master')

@section('content')

    {{-- PASSING DATA TO COMPONENTS --}}
    {{-- <div class="row">
        @foreach ( $posts as $post )
        <x-posts.index :post='$post'/>            
        @endforeach
    </div> --}}

    {{-- COMPONENT SLOTS --}}
    {{-- <x-button>
        Slot sample
    </x-button> --}}
    <div class="row">
        @foreach ( $posts as $post )
        <x-posts.index>
            <x-slot name='title'>
                {{$post->title}}
            </x-slot>
            <x-slot name='description'>
                {{$post->description}}    
            </x-slot>
        </x-posts.index>        
        @endforeach
    </div>
@endsection

{{-- <div>
    <h1>Contact</h1>

    <x-button />
    <x-forms.button />
    <x-input-field />
    <x-forms.link />
</div> --}}