<div class="box margin-vr activity-items">
    @foreach($activities as $activity)
        <div class="item activity-item activity-{{ str_slug($activity->subject_type) }} @if($activity->is_pinned) activity-pinned @endif" style="position: relative">
            {!! $activity->render() !!}
        </div>
    @endforeach
</div>