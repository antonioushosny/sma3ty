@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
           {{$user->name}} Welcome in Fannie
        @endcomponent
    @endslot
{{-- Body --}}
   <h3>
        you are Added in Bunyan 
    </h3> <br>
    <h4>your email : {{$user->email}}</h4>
    <h4>your password : {{$password}}</h4>

    
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
            © {{ date('Y') }} Fannie 4U.!
        @endcomponent
    @endslot
@endcomponent