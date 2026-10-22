@extends('layouts.auth')

@section('title', 'Reset password')
@section('heading')
    Locked out? <span class="dim">It happens.</span>
@endsection
@section('lead', 'Enter the email on your account and we’ll send you a secure link to choose a new password.')

@section('form')
    <span class="label">Password reset</span>
    <h2>Forgot your password?</h2>
    <p class="sub">We’ll email you a link to reset it. The link expires after a short time.</p>

    <form class="auth__form" method="POST" action="{{ route('password.email') }}" data-loading-form novalidate>
        @csrf

        @if(session('status'))
            <div class="notice notice--ok" role="status"><svg class="icon"><use href="#i-check"/></svg><span>{{ session('status') }}</span></div>
        @endif

        <div class="field @error('email') bad @enderror">
            <label for="email">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="you@company.com"
                   @error('email') aria-invalid="true" aria-describedby="email-err" @enderror>
            @error('email') <div class="ferr" id="email-err">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn--primary">Send reset link <svg class="icon arr"><use href="#i-arrow"/></svg></button>
    </form>

    <p class="auth__alt">Remembered it? <a href="{{ route('login') }}">Back to sign in</a></p>
@endsection
