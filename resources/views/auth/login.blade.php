@extends('layouts.app')

@section('title', 'Login')

@section('main')
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label>E-mail</label>
            <input name="email" value="{{ old('email') }}" required class="form-control{{ $errors->has('email') ? ' is-invalid': '' }}" />
            @if ($errors->has('email'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}" />
            @if ($errors->has('password'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
        </div>

        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} />
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
@endsection
