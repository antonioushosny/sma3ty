@extends('layouts.auth')
@section('style')
<style>
    .page-header-image
    {
        background-color: #364150!important;
    }
    body
    {
        {{-- font-family: 'DroidArabicKufiBold';   --}}
    }
    .card-plain
    {
        background-color:#eceef1;
         /* padding: 20px; */
    }
    .form-control:active,.form-control:focus {
        border: 1px solid #c3ccda;
    }
    .form-control {
        background-color: #dde3ec;
        height: 43px;
        color: #8290a3;
        border: 1px solid #dde3ec;
    }
    .btn.btn-primary{
        background-color:#0046B0;
        color: #FFF;
        {{-- font-family: 'DroidArabicKufiBold';   --}}
    }
    /* .btn.btn-primary:hover{
        color: #FFF;
        background-color: #1f858e;
        border-color: #18666d;
    } */
    h5>a.link
    {
        color:black!important;
    }
    span.input-group-addon
    {
        color:#cccccc !important;
    }
    .authentication .card-plain.card-plain .form-control,.authentication .card-plain.card-plain .form-control:focus
    {
        color: #000;
    }
    .invalid-feedback
    {
        color: #e73d4a;
    }
    body, .page-header{
        background-color: #364150   !important;
    }
    .delete-border{
        border-radius: 0px !important; 
    }
    .authentication .card-plain.card-plain .input-group-addon {

        background-color: #dde3ec !important; 
        border-color: rgb(255, 255, 255) !important;
        color: #fff;

    }
    ::placeholder {
        color: #a19ca3 !important;
        {{-- font-family: 'DroidArabicKufiRegular'; --}}
        text-align: right;
    }
</style>
@endsection
@section('content')
<div class="page-header-image"  ></div>
<div class="container" style="padding :20px ;">
    <div class="col-md-12 content-center card-plain" style="top: 50%;">
        {{-- <div class="card-plain"> --}}

            <form action="{{ route('password.request') }}" method="POST" class="form" id="loginform" autocomplete="off">
                @csrf
                <div class="header">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="logo-container">
                        <img src="{{ asset('images/logo.png') }}" alt="">
                    </div>
                    {{--  <h5>Enter Email Address</h5>  --}}
                </div>
                <div class="content">                                                
                    <div class="input-group input-lg">
                        <input type="hidden" id="code" name="code"  value="{{ $token }}"  required >
                        <input type="text" id="email" name="email" class="delete-border form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{trans('admin.placeholder_email')}}" value="{{ old('email') }}"  required autofocus>
                        <!-- <input type="text" class="delete-border form-control" placeholder="Enter User Name" value="{{ old('email') }}"  autofocus> -->
                        <span class="input-group-addon delete-border">
                            <i class="zmdi zmdi-account-circle"></i>
                        </span>
                    </div>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif

                    <div class="input-group input-lg">
                        <input type="password"  placeholder="{{trans('admin.placeholder_password')}}" class="delete-border form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" >
                        <!-- <input type="password" placeholder="Password" class="form-control" /> -->
                        <span class="input-group-addon delete-border">
                            <i class="zmdi zmdi-lock"></i>
                        </span>
                        
                    </div>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                    
                    <div class="input-group input-lg">
                    <input type="password" id="password-confirm" placeholder="{{trans('admin.placeholder_password_confirmation')}}" class="delete-border form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password_confirmation" >
                    <span class="input-group-addon delete-border">
                        <i class="zmdi zmdi-lock"></i>
                    </span>
                    
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif

                </div>
                <div class="footer text-center">
                        <button type="submit" class="btn btn-primary">{{ __('admin.Reset Password') }}</button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
 