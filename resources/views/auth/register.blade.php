@extends('layouts/guest')

@section('main')



<main class="main main--bg-primary">
    <form class="form form--auth" method="POST" action="{{ route('register') }}">

        <h3 class="heading--primary">Registrati adesso!</h3>
        
        @csrf

        <div class="form__field">
                   
            <label for="name" class="col-md-4 form__label text-md-right">{{ __('Nome') }}</label>
            <input id="name" placeholder="Inserisci il tuo Nome" type="text" class="form__input input_width form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
              
        <div class="form__field">

            <label for="surname" class="col-md-4 form__label text-md-right">{{ __('Cognome') }}</label>
            <input id="surname" placeholder="Inserisci il tuo Cognome" type="text" class="form__input input_width form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" required autocomplete="surname" autofocus>

            @error('surname')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
                
        <div class="form__field">

            <label for="date_of_birth" class="col-md-4 form__label text-md-right">{{ __('Data di Nascita') }}</label>

            <input id="date_of_birth" placeholder="Inserisci la tua data di nascita" type="date" class="form__input input_width form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}" required autocomplete="date_of_birth" autofocus>

            @error('date_of_birth')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>

        <div class="form__field">

            <label for="email" class="col-md-4 form__label text-md-right">{{ __('Email') }}</label>
            <input id="email" type="email" placeholder="Inserisci la tua Email" class="form__input input_width form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
            
        <div class="form__field">

            <label for="password" class="col-md-4 form__label text-md-right">{{ __('Password') }}</label>
            <input id="password" placeholder="Inserisci la tua Password" type="password" class="form__input input_width form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form__field">

            <label for="password-confirm" class="col-md-4 form__label text-md-right">{{ __('Conferma Password') }}</label>
            <input id="password-confirm" placeholder="Inserisci la tua Password" type="password" class="form__input input_width form-control" name="password_confirmation" required autocomplete="new-password">

        </div>

        <div class="form__field">

            <button type="submit" class="btn btn--primary btn--new btn--reg">
                {{ __('Register') }}
            </button>
            
        </div>
    </form>
</main
@endsection
