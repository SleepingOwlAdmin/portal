<div class="content padded">
    <span class="ui mini green label">
        New Post
    </span>

    <span class="ui mini label date">
        <time>{{ $subject->created_at }}</time>
    </span>

    {{--
    @if($subject->comments_count > 0)
        <a class="ui mini red label" href="{{ $subject->link }}#comments">
            Comments ({{ $subject->comments_count }})
        </a>
    @endif
    --}}

    <h3>
        <a href="{{ $subject->link }}">{{ $subject->title }}</a>
    </h3>

    @if(!empty($subject->thumb))
        <div class="margin-b">
            <img src="{{ $subject->thumb_url }}" class="ui medium bordered image">
        </div>
    @endif

    <div class="description">
        {!! $subject->intro !!}

        @if(!empty($subject->cut_text))
            <a href="{{ $subject->link }}" class="ui mini basic button icon">
                {{ $subject->cut_text }} <i class="angle double right icon"></i>
            </a>
        @endif
    </div>

    <div class="ui top right attached label">
        <likeable id="{{ $subject->id }}" type="posts" likes="{{ $subject->total_likes }}"></likeable>
    </div>
</div>