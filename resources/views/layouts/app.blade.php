<!DOCTYPE html>
<html lang="en">
<head>
    {!! Meta::render() !!}
</head>
<body id="app-layout">

    @include('layouts.partials.notifications')
    @include('layouts.partials.header')
    @yield('content')
    @include('layouts.partials.footer')

    {!! Meta::renderScripts(true) !!}
</body>
</html>
