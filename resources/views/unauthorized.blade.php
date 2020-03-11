@extends('layouts.auth')
@section('content')
<div class="page-header-image" style="background-image:url(assets/images/login.jpg)"></div>
<div class="container">
    <div class="col-md-12 content-center">
        <div class="card-plain">
                <div class= "alert alert-danger">
                     {{ __('admin.You cannot access this page!') }}
                </div>
        </div>
    </div>
</div>
@endsection 



