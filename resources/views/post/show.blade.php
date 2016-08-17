@extends('layouts.app')

@section('content')
    <div class="ui container" id="newsContainer">
        <div class="ui items">
            <div class="news-item item box margin-vr padded">
                <div class="content">
                    <h1>{{ $post->title }}</h1>

                    <div class="ui section divider"></div>

                    <div class="description">
                        {!! $post->text_intro !!}

                        @if(!empty($post->image))
                            <div class="image margin-vr">
                                <img src="{{ $post->image_url }}" class="ui rounded image">
                            </div>
                        @endif

                        {!! $post->text !!}
                    </div>

                    <div class="ui section divider"></div>

                    <div class="meta">
                        <div class="ui divided relaxed tiny horizontal list">
                            <div class="item">
                                <strong>Created At</strong> <time>{{ $post->created_at }}</time>
                            </div>

                            <div class="item">
                                <likeable id="{{ $post->id }}" type="posts" size="large" color="green" likes="{{ $post->total_likes }}"></likeable>
                            </div>

                            <div class="item">
                                <strong>Author</strong> {!! $post->user->profile_link !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box margin-t">
                <commentable id="{{ $post->id }}" type="{{ $post->comments()->getMorphClass() }}"></commentable>
            </div>
        </div>
    </div>
@endsection
