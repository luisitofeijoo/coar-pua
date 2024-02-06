@extends('layouts.app')
@section('content')
<form method="POST" action="{{ route('custom-login') }}">
                @csrf

                <div class="field">
                    <label class="label" for="email">Usuario</label>
                    <div class="control">
                        <input id="username" type="text" class="input @error('username') is-danger @enderror" name="username" placeholder="Escribe tu usuario" required autocomplete="off" autofocus>
                    </div>
                    @error('email')
                        <p class="help is-danger" role="alert">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="field">
                    <label class="label" for="password">Contraseña</label>
                    <div class="control">
                        <input id="password" type="password" class="input @error('password') is-danger @enderror" placeholder="Escribe tu contraseña"  name="password" required>
                    </div>
                    @error('password')
                        <p class="help is-danger" role="alert">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="field is-grouped">
                    <div class="control">
                        <button type="submit" class="button is-primary">
                            Iniciar sesión
                        </button>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="control">
                            <a class="button is-text" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    @endif
                </div>
            </form>
@endsection
