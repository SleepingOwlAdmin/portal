@extends('layouts.app')

@section('content')
    <style type="text/css">
        .column {
            margin-top: 50px;
            max-width: 450px;
        }
    </style>
    <div class="ui middle center aligned grid">
        <div class="column">
            <h2 class="ui teal header">
                @lang('core.title.login')
            </h2>
            <form class="ui large form" role="form" method="POST" action="{{ url('/login') }}">

                {!! csrf_field() !!}

                <div class="ui  segment">
                    <div class="field {{ $errors->has('email') ? 'error' : '' }}">
                        <div class="ui left icon input">
                            <i class="user icon"></i>
                            <input type="text" name="email" value="{{ old('email') }}" placeholder="@lang('core.user.field.email')">
                        </div>
                    </div>
                    <div class="field {{ $errors->has('password') ? 'error' : '' }}">
                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" name="password" placeholder="@lang('core.user.field.password')">
                        </div>
                    </div>

                    <div class="field" style="text-align: left;">
                        <div class="ui checkbox">
                            <input type="checkbox" name="remember" id="rememberMe" tabindex="0" checked>
                            <label for="rememberMe">@lang('core.user.label.remember')</label>
                        </div>
                    </div>

                    <button class="ui fluid large teal submit button">@lang('core.user.button.login')</button>
                </div>
            </form>
        </div>
    </div>
@endsection
