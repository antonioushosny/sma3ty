@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
         
         Welcome To HR
        @endcomponent
    @endslot
{{-- Body --}}
   <h3>
 
    </h3> <br>
    <h4>Verify Code For Your Email Is :- </h4> <br> <h3>{{$code}}</h3> 

    
{{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset
{{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }}  HR.!
        @endcomponent
    @endslot
@endcomponent