@extends('layouts.app')

@section('content')

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label>{{ __('E-mail') }}</label>
            <input name="email" value="{{ old('email') }}" required
            class="form-control {{$errors->has('email') ? ' is-invalid':''}}">

            @if($errors->has('email'))
                <spon class="invalid-feedback">
                    <strong>{{$errors->first('email')}}</strong>
                </spon>
            @endif
        </div>

    <div class="form-group">
        <label>{{ __('Password') }}</label>
        <input name="password" required
        class="form-control {{$errors->has('password') ? ' is-invalid':''}}">

        @if($errors->has('password'))
            <spon class="invalid-feedback">
                <strong>{{$errors->first('password')}}</strong>
            </spon>
        @endif
    </div>

    <div class="form-group">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember"
            value="{{ old('remember') ? 'checked' : '' }}">
            <label class="form-check-label" for="remember">
                {{ __('Remember me') }}
            </label>
        </div>
    </div>
        <button class="btn btn-primary btn-block" type='submit'>{{ __('Login!') }}</button>
    </form>

@endsection
