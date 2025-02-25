<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>{{ config('site.common.info.name') }}</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10,user-scalable=yes,viewport-fit=cover">
    <meta name="format-detection" content="telephone=no, address=no, email=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Pragma" content="no-cache">
    
    <meta name="Author" content="{{ config('site.common.info.name') }}">
    <meta name="Keywords" content="{{ config('site.common.info.name') }}">
    <meta name="description" content="{{ config('site.common.info.name') }}">
    <meta property="og:title" content="{{ config('site.common.info.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="/assets/image/favicon.ico">

    <link rel="stylesheet" href="/assets/css/jquery-ui.min.css">
    <link rel="stylesheet" href="/assets/css/slick.css">
    <link rel="stylesheet" href="/assets/css/common.css">
    <link type="text/css" rel="stylesheet" href="/devScript/colorbox/example3/colorbox.css" />

    <script src="/assets/js/jquery-1.12.4.min.js"></script>
    <script src="/assets/js/jquery-ui.min.js"></script>
    <script src="/assets/js/slick.min.js"></script>
    <script src="/assets/js/common.js"></script>
    <script type="text/javascript" src="/devScript/common.js"></script>
    <script src="/devScript/colorbox/jquery.colorbox-min.js"></script> 

    <script>
    opener.document.getElementById("registrationForm").setAttribute('onsubmit','');
    opener.document.getElementById("registrationForm").submit();
    window.close();
    </script>
</head>    
<body>

</body>
</html>    