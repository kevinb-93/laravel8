@extends('layouts.app')

@section('title', 'Register')

@section('main')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label>Name</label>
            <input name="name" value="{{ old('name') }}" required class="form-control{{ $errors->has('name') ? ' is-invalid': '' }}" />
            @if ($errors->has('name'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
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
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required class="form-control" />
        </div>

        <button type="submit" class="btn btn-primary btn-block">Register</button>
    </form>
@endsection
