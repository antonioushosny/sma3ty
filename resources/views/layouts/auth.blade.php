<!doctype html>
<html class="no-js " lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

    <title>:: sma3ty ::</title>
    <!-- Favicon-->
    <!-- <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon"> -->
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" >
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/authentication.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">
    {{-- <link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/droid-arabic-kufi" type="text/css"/> --}}
    @yield('style')
    <style>
        ::-webkit-input-placeholder { /* Edge */
            color: #a19ca3;
            {{-- font-family: 'DroidArabicKufiRegular';  --}}
            text-align: left;
        }

        :-ms-input-placeholder { /* Internet Explorer 10-11 */
        color: #a19ca3;
        {{-- font-family: 'DroidArabicKufiRegular'; --}}
        text-align: left;  
        }

        ::placeholder {
        color: #a19ca3;
        {{-- font-family: 'DroidArabicKufiRegular';  --}}
        text-align: left; 
        }
    </style>  
</head>

<body class="theme-purple authentication sidebar-collapse">

<div class="page-header">
    

    @yield('content') 
    <footer class="footer">
        <div class="container">
          
            <div class="copyright">
                {{--  &copy;  --}}
                <script>
                    // document.write(new Date().getFullYear())
                </script>
            </div>
        </div>
    </footer>
</div>

<!-- Jquery Core Js -->
<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js -->

<script>
   $(".navbar-toggler").on('click',function() {
    $("html").toggleClass("nav-open");
});
//=============================================================================
$('.form-control').on("focus", function() {
    $(this).parent('.input-group').addClass("input-group-focus");
}).on("blur", function() {
    $(this).parent(".input-group").removeClass("input-group-focus");
});
</script>
</body>
</html>