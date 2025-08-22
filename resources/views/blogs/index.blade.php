@php
    use App\Enums\ButtonVariant;
    use App\Enums\ButtonSize;

    $breadcrumbItems = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Cookbook', 'url' => '/cookbook']
    ];
@endphp

@extends('layout.index')
@section('title', 'Community Cookbook')

@section('content')
    <ul>
        @foreach ($blogs as $blog)
            <li class="py-2">
                <a href="{{ route('blogs.show', $blog->id) }}" class="text-blue-500 hover:underline">{{ $blog->title }}</a>
            </li>
        @endforeach
    </ul>
@endsection