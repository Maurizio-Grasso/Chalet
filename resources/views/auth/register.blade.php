@extends('layouts/guest')

@section('main')
<div class="width_container">

        <div class="register-form">
            <div class="card">
                <div class="card-header"><h3>Registrati adesso!</h3></div>

                <div class="card-body">
                    <form class="form" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="name-form">
                            <label for="name" class="col-md-4 form__label text-md-right">{{ __('Nome') }}</label>

                            <div class="name-input">
                                <input id="name" placeholder="Inserisci il tuo Nome" type="text" class="form__input input_width form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="surname-form">
                            <label for="surname" class="col-md-4 form__label text-md-right">{{ __('Cognome') }}</label>

                            <div class="surname-input">
                                <input id="surname" placeholder="Inserisci il tuo Cognome" type="text" class="form__input input_width form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" required autocomplete="surname" autofocus>

                                @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="date-form">
                            <label for="date_of_birth" class="col-md-4 form__label text-md-right">{{ __('Data di Nascita') }}</label>

                            <div class="date-input">
                                {{-- <input id="date_of_birth" placeholder="Inserisci la tua data di nascita" type="text" class="form__input input_width form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}" required autocomplete="date_of_birth" autofocus> --}}
                                <input id="date_of_birth" placeholder="Inserisci la tua data di nascita" type="date" class="form__input input_width form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}" required autocomplete="date_of_birth" autofocus>

                                @error('date_of_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="email-form">
                            <label for="email" class="col-md-4 form__label text-md-right">{{ __('Email') }}</label>

                            <div class="email-input">
                                <input id="email" type="email" placeholder="Inserisci la tua Email" class="form__input input_width form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="password-form">
                            <label for="password" class="col-md-4 form__label text-md-right">{{ __('Password') }}</label>

                            <div class="password-input">
                                <input id="password" placeholder="Inserisci la tua Password" type="password" class="form__input input_width form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="conf_password-form">
                            <label for="password-confirm" class="col-md-4 form__label text-md-right">{{ __('Conferma Password') }}</label>

                            <div class="conf_password-input">
                                <input id="password-confirm" placeholder="Inserisci la tua Password" type="password" class="form__input input_width form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="submit-button">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn--primary btn--new btn--reg">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
</div>
@endsection
