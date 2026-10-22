@extends('layouts.auth')

@section('title', 'Sign in')

@section('form')
    <span class="label">Sign in</span>
    <h2>Access your account</h2>
    <p class="sub">Use the email and password provided by your Leamsoft administrator.</p>

    <form class="auth__form" method="POST" action="{{ route('login') }}" data-loading-form novalidate>
        @csrf

        @if(session('status'))
            <div class="notice notice--ok" role="status"><svg class="icon"><use href="#i-check"/></svg><span>{{ session('status') }}</span></div>
        @endif
        @if($errors->any() && !$errors->has('email') && !$errors->has('password'))
            <div class="notice notice--err" role="alert"><svg class="icon"><use href="#i-alert"/></svg><span>{{ $errors->first() }}</span></div>
        @endif

        <div class="field @error('email') bad @enderror">
            <label for="email">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="you@company.com"
                   @error('email') aria-invalid="true" aria-describedby="email-err" @enderror>
            @error('email') <div class="ferr" id="email-err">{{ $message }}</div> @enderror
        </div>

        <div class="field @error('password') bad @enderror">
            <label for="password">Password</label>
            <div class="pw">
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                       @error('password') aria-invalid="true" aria-describedby="password-err" @enderror>
                <button type="button" data-toggle-password="password" aria-label="Show password" aria-pressed="false"><svg class="icon"><use href="#i-eye"/></svg></button>
            </div>
            <div class="caps" data-caps-for="password" role="status">Caps Lock is on</div>
            @error('password') <div class="ferr" id="password-err">{{ $message }}</div> @enderror
        </div>

        <div class="auth__row">
            <label class="check">
                <input type="checkbox" name="remember" id="remember" @checked(old('remember'))>
                <span>Keep me signed in</span>
            </label>
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="btn btn--primary">Sign in <svg class="icon arr"><use href="#i-arrow"/></svg></button>
    </form>

    <p class="auth__alt">Not a client yet? <a href="{{ url('contact-us') }}">Start a project</a></p>
@endsection
