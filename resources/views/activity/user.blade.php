<div class="content padded">
    <span class="ui mini orange label">
        New User
    </span>

    <span class="ui mini label date">
        <time>{{ $subject->created_at }}</time>
    </span>

    <h3 class="ui header">
        <a href="{!! $subject->profile_link !!}">
            {!! $subject->name !!}
        </a>
    </h3>

    @if($subject->avatar_url)
        <div class="margin-vr">
            <img src="{{ $subject->avatar_url }}" class="ui box image" />
        </div>
    @endif
</div>