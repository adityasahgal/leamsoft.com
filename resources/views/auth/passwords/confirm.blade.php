@extends('layouts.auth')

@section('title', 'Confirm password')
@section('heading')
    Quick check. <span class="dim">It’s really you?</span>
@endsection
@section('lead', 'This area needs your password again before you continue.')

@section('form')
    <span class="label">Security check</span>
    <h2>Confirm your password</h2>
    <p class="sub">Please confirm your password before continuing.</p>

    <form class="auth__form" method="POST" action="{{ route('password.confirm') }}" data-loading-form novalidate>
        @csrf

        <div class="field @error('password') bad @enderror">
            <label for="password">Password</label>
            <div class="pw">
                <input id="password" type="password" name="password" required autocomplete="current-password" autofocus
                       @error('password') aria-invalid="true" aria-describedby="password-err" @enderror>
                <button type="button" data-toggle-password="password" aria-label="Show password" aria-pressed="false"><svg class="icon"><use href="#i-eye"/></svg></button>
            </div>
            <div class="caps" data-caps-for="password" role="status">Caps Lock is on</div>
            @error('password') <div class="ferr" id="password-err">{{ $message }}</div> @enderror
        </div>

        <div class="auth__row">
            <span></span>
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="btn btn--primary">Confirm password <svg class="icon arr"><use href="#i-arrow"/></svg></button>
    </form>
@endsection
