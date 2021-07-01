@extends('layouts/guest')

@section('main')

<div class="width_container">
    <div class="login-form">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h3>Fai il login adesso!</h3></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="email-form">
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

                        <div class="password-form">
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

                        <div class="remember-form">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    
                                    <label class="form__label" for="remember">
                                        <input class="form__input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        {{ __('Ricordami') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="submit-botton">
                            <div class="col">
                                
                                <div>
                                    <button type="submit" class="btn btn--primary btn--log">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                                
                                <div>
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

