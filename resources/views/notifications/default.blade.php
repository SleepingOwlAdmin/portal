<div class="event">
    <div class="label">
        <i class="circular icon {{ $notification->data['icon'] }}"></i>
    </div>
    <div class="content">
        <div class="summary">
            {{ $notification->data['text'] }}
        </div>

        <div class="meta">
            <div>
                <small class="date">
                    {{ $notification->created_at }}
                </small>
            </div>
        </div>
    </div>
</div>