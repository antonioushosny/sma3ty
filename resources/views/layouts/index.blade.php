<!doctype html>
<?php   
    if($title){
        $page = $title;
    }
    else {
        $page ='home';
    }
?>
<h4 class="no-js " lang="en">
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>::  sma3ty ::</title>
<!-- <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">  -->
<link rel="shortcut icon" href="{{ asset('images/logo.png') }}" >

<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('assets/plugins/morrisjs/morris.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}"/>

<!-- Custom Css -->
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">

<!-- Bootstrap Material Datetime Picker Css -->
<link href="{{ asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet" />
<!-- Bootstrap Select Css -->
<link href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />

<link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/droid-arabic-kufi" type="text/css"/>



@yield('style')  
 
 
@yield('content')   

<!-- Jquery Core Js --> 
<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) --> 
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script> <!-- slimscroll, waves Scripts Plugin Js -->
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>

<!-- // for form validations  -->
 
<script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.js') }}"></script> <!-- Jquery Validation Plugin Css --> 
 <script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.js') }}"></script> <!-- JQuery Steps Plugin Js --> 
<script src="{{ asset('assets/js/pages/forms/form-validation.js') }}"></script> 
  <!-- //for  dialogs  -->
<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script> <!-- SweetAlert Plugin Js --> 
<script src="{{ asset('assets/js/pages/ui/dialogs.js') }}"></script>
 
<script src="{{ asset('assets/plugins/momentjs/moment.js') }}"></script> <!-- Moment Plugin Js --> 
<!-- Bootstrap Material Datetime Picker Plugin Js --> 
<script src="{{ asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script> 
<script src="{{ asset('assets/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script> 
<script src="{{ asset('assets/js/pages/forms/basic-form-elements.js') }}"></script> 

<!-- Jquery DataTable Plugin Js --> 
<script src="{{ asset('assets/bundles/datatablescripts.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script> 
    <script>
    function isNumber(e){
            var key = e.charCode;  
            if( key <48 || key >57 )
            {
				if (key != 0)
				{
                e.preventDefault();   
				}
				          
            }
    }
        $('#btneditprofile').on('click',function(){

            $('#btneditprofile').css('display', 'none');
            $('#ulformeditprofile').css('display', 'inline-block');
        })
        function isNumber(e){
            var key = e.charCode;  
            if( key <48 || key >57 )
            {
                if (key != 0)
                {
                e.preventDefault();   
                }
                            
            }
        }
        function readURL(input,imagediv) {
            
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                src = document.getElementById(imagediv).src;    
                imag = "{{asset('images/addimage.png')}}" ;
                if(imag != src){
                    arrayimages = src ;
                }
                reader.onload = function (e) {
                    $('#'+imagediv).attr('src', e.target.result);
                }
        
                reader.readAsDataURL(input.files[0]);
            }
        }
        var message, ShowDiv = $('#showNofication'), count = $('#count'), c;

        $('.notificaiton').on('click' , function(){
            setTimeout( function(){
                count.html(0);
                $('.unread').each(function(){
                    $(this).removeClass('unread');
                });
            }, 5000);
            $.get( "{{route('MarkAllSeen') }}" , function(){});
        });

        function randomPassword(length) {
            var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOP1234567890";
            var pass = "";
            for (var x = 0; x < length; x++) {
                var i = Math.floor(Math.random() * chars.length);
                pass += chars.charAt(i);
            }
            return pass;
        }
        
        function generate() {
            myform.password.value = randomPassword(6);
        }

     
   
    </script> 
    @yield('script')

</body>
</h4>