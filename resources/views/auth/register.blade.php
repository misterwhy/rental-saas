@extends('layouts.app')

@section('content')
<div class="content-wrap">
    <div class="content-head">
        <h1>Register</h1>
    </div>

    <div class="room-grid">
        <div class="card111">
            <div class="details111">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3" style="padding: 0 12px;">
                        <label for="name" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                               style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                        @error('name')
                            <span class="invalid-feedback" role="alert" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3" style="padding: 0 12px;">
                        <label for="email" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Email Address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"
                               style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                        @error('email')
                            <span class="invalid-feedback" role="alert" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3" style="padding: 0 12px;">
                        <label for="phone" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Phone</label>
                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" autocomplete="phone"
                               style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                        @error('phone')
                            <span class="invalid-feedback" role="alert" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3" style="padding: 0 12px;">
                        <label for="user_type" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">User Type</label>
                        <select id="user_type" class="form-control @error('user_type') is-invalid @enderror" name="user_type" required
                                style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                            <option value="tenant" {{ old('user_type') == 'tenant' ? 'selected' : '' }}>Tenant</option>
                            <option value="landlord" {{ old('user_type') == 'landlord' ? 'selected' : '' }}>Landlord</option>
                        </select>
                        @error('user_type')
                            <span class="invalid-feedback" role="alert" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3" style="padding: 0 12px;">
                        <label for="password" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"
                               style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                        @error('password')
                            <span class="invalid-feedback" role="alert" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3" style="padding: 0 12px;">
                        <label for="password-confirm" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password"
                               style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                    </div>

                    <div class="mb-3" style="padding: 15px 12px 12px 12px; text-align: center;">
                        <button type="submit" class="save-btn">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection