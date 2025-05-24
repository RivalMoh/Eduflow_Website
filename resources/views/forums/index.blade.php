@extends('forums.components.feed-layout', ['activeTab' => 'all'])

@section('forum-content')
    @include('forums.partials.posts')
@endsection
