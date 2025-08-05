@extends('layouts.app')

@section('content')
<div class="content-wrap">
    <div class="content-head">
        <h1>Login</h1>
    </div>

    <div class="room-grid">
        <div class="card111">
            <div class="details111">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3" style="padding: 0 12px;">
                        <label for="email" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Email Address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                               style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                        @error('email')
                            <span class="invalid-feedback" role="alert" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3" style="padding: 0 12px;">
                        <label for="password" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"
                               style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                        @error('password')
                            <span class="invalid-feedback" role="alert" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3" style="padding: 0 12px;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                                   style="margin-right: 0.5rem;">
                            <label class="form-check-label" for="remember" style="font-size: 0.85rem;">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>

                    <div class="mb-3" style="padding: 15px 12px 12px 12px; text-align: center;">
                        <button type="submit" class="save-btn">Login</button>
                        @if (Route::has('password.request'))
                            <a class="edit-btn" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection