@extends('layouts.auth')

@section('title', 'Choose a new password')
@section('heading')
    Set a new password. <span class="dim">Then you’re back in.</span>
@endsection
@section('lead', 'Use at least 8 characters. A short phrase is easier to remember and harder to guess.')

@section('form')
    <span class="label">Password reset</span>
    <h2>Choose a new password</h2>
    <p class="sub">Enter your email and your new password below.</p>

    <form class="auth__form" method="POST" action="{{ route('password.update') }}" data-loading-form novalidate>
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="field @error('email') bad @enderror">
            <label for="email">Email address</label>
            <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email"
                   @error('email') aria-invalid="true" aria-describedby="email-err" @enderror>
            @error('email') <div class="ferr" id="email-err">{{ $message }}</div> @enderror
        </div>

        <div class="field @error('password') bad @enderror">
            <label for="password">New password</label>
            <div class="pw">
                <input id="password" type="password" name="password" required autocomplete="new-password" autofocus minlength="8"
                       @error('password') aria-invalid="true" aria-describedby="password-err" @enderror>
                <button type="button" data-toggle-password="password" aria-label="Show password" aria-pressed="false"><svg class="icon"><use href="#i-eye"/></svg></button>
            </div>
            <div class="caps" data-caps-for="password" role="status">Caps Lock is on</div>
            @error('password') <div class="ferr" id="password-err">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="password-confirm">Confirm new password</label>
            <div class="pw">
                <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password" minlength="8">
                <button type="button" data-toggle-password="password-confirm" aria-label="Show password" aria-pressed="false"><svg class="icon"><use href="#i-eye"/></svg></button>
            </div>
        </div>

        <button type="submit" class="btn btn--primary">Update password <svg class="icon arr"><use href="#i-arrow"/></svg></button>
    </form>

    <p class="auth__alt"><a href="{{ route('login') }}">Back to sign in</a></p>
@endsection
