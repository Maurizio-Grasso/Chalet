<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- Font AweSome CDN     --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Style --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @yield('headPush')

    {{-- Dinamyc Title --}}
    <title>@yield('title')</title>
</head>

<body>
    <div id="app">
    
        
    @php
        // Is User Authenticated ?

        use Illuminate\Support\Facades\Auth;

        $isLoggedIn = false;

        if (Auth::check()) {
            $isLoggedIn = true;
        }

        $homePage = array(
            'name'  => 'home' ,
            'label' => 'Home Page' ,
            'slug'  =>  route('guest-home') ,
            'icon'  => 'fas fa-home'
        );

        $advancedSearch = array(
            'name'  => 'search' ,
            'label' => 'Ricerca Avanzata' ,
            'slug'  =>  route('search') ,
            'icon'  => 'fas fa-search-location'
        );
        
        $logIn = array(
            'name'  => 'login' ,
            'label' => 'logIn' ,
            'slug'  =>  route('login') ,
            'icon'  => 'fas fa-sign-in-alt'
        );

        $logOut = array(
            'name'  => 'signout' ,
            'label' => 'Esci' ,
            'slug'  =>  route('logout') ,
            'icon'  => 'fas fa-sign-out-alt' ,
        );

        $dashboard = array(
            'name'  => 'dashboard' ,
            'label' => 'Dashboard' ,
            'slug'  =>  route('admin_homepage') ,
            'icon'  => 'fas fa-user' ,
        );

        $signUp = array(
            'name'  => 'signup' ,
            'label' => 'Registrati' ,
            'slug'  =>  route('register') ,
            'icon'  => 'fas fa-user-plus'
        );
        
        $menuItems = array( $homePage , $advancedSearch);

        if($isLoggedIn) {
            array_push($menuItems , $dashboard , $logOut);
        } else {
            array_push($menuItems , $logIn , $signUp);
        }
        

    @endphp


    {{-- Header Component --}}

    <header-guest :csrf="{{ json_encode(csrf_token())}}" :items="{{ json_encode($menuItems)}}"></header-guest>
    
    {{-- Main Here --}}
    
    @yield('main')
    
</div>
    <script src="{{asset('js/app.js')}}"></script>
</body>
</html>