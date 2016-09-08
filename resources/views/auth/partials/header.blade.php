@if (Auth::guest())
    <div class="item">
        <a class="ui button" href="{{ url('/login') }}">Login</a>
    </div>
@else
    <a class="item notification-item" style="display: none;" @click="showNotifications" :class="{'unread': hasUnreadNotifications}">
        <i class="large alarm icon" :class="{'outline': !hasUnreadNotifications}"></i>
        <span class="top right attached ui label" v-if="hasUnreadNotifications">@{{ unreadNotifications }}</span>
    </a>

    <div class="ui dropdown item">
        {!! Auth::user()->name !!}
        <i class="dropdown icon"></i>
        <div class="menu">
            <a class="item" href="{{ url('/admin') }}">
                <i class="circular inverted blue dashboard icon"></i> Dashboard
            </a>
            <div class="ui divider"></div>
            <a class="item" href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="circular inverted red power icon"></i> Logout
            </a>

            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
    </div>
@endif