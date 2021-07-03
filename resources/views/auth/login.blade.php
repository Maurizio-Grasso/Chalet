@extends('layouts/guest')

@section('main')

<main class="main--bg-primary">
    
    <form class="form form--auth" method="POST" action="{{ route('login') }}">
            
        <h3 class="heading--primary">Esegui il login</h3>
            
            @csrf

            <div class="form__field">
                <label for="email" class="form__label">{{ __('Email') }}</label>

                <div class="email-input">
                    <input id="email" placeholder="Inserisci la tua Email" type="email" class="form__input input_width @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    
                </div>
            </div>

            <div class="form__field">
                
                <label for="password" class="form__label">{{ __('Password') }}</label>

                <div class="pasword-input">
                    <input id="password" type="password" placeholder="Inserisci la tua Password" class="form__input input_width @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form__field">
                
                    <div class="form-check">
                        
                        <label class="form__label" for="remember">
                            <input class="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            {{ __('Ricordami') }}
                        </label>
                    </div>
                
            </div>

            <div class="form__field">
                    
                    <div>
                        <button type="submit" class="btn btn--primary btn--log">
                            {{ __('Login') }}
                        </button>
                    </div>                                    
                
            </div>

        </form>
    </main>


@endsection

