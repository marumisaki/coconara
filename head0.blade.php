@section('head')
<?php
ini_set('display_errors', 'on');
?>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
@if(Request::is('detail/*'))
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="@hideiwa1">
<meta name="twitter:title" content="{{$detail -> title}}">
<meta name="twitter:description" content="{{$detail -> min_price}},000円〜{{$detail -> max_price}},000円">
@if(app('env') == 'local')
<meta name="twitter:image" content="{{(asset('/img/match.jpg'))}}">
@else
<meta name="twitter:image" content="{{(secure_asset('/img/match1.jpg'))}}">
@endif

@endif
<script src="https://kit.fontawesome.com/cf99747a60.js" crossorigin="anonymous"></script>

<title>match! @yield('title')</title>
<meta name="description" content="@yield('description')">
<meta name="keyword" content="@yield('keyword')">

@if(app('env') == 'local')
<link rel="stylesheet" href="{{ (asset('/css/app.css')) }}">
@else
<link rel="stylesheet" href="{{ (secure_asset('/css/app.css')) }}">
@endif
@endsection
