<li>
    <a href="/", target="_blank">
        <i class="fa fa-btn fa-globe"></i> Index page
    </a>
</li>
<li class="dropdown user user-menu" style="margin-right: 20px;">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        @if($user->avatar_url)
            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="user-image" />
        @endif

        <span class="hidden-xs">{{ $user->name }}</span>
    </a>
    <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header">
            @if($user->avatar_url)
                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="img-circle" />
            @endif
            <p>
                {{ $user->name }}
                <small>Since {{ $user->created_at->format('d.m.Y') }}</small>
            </p>
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
            <a href="{{ url('/logout') }}">
                <i class="fa fa-btn fa-sign-out"></i> Logout
            </a>
        </li>
    </ul>
</li>