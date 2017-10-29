@section('title', 'Профиль пользователя')
@extends('layouts.main')

@section('content')
    <div class="columns">
        <div class="column is-offset-2 is-8">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                        @lang('content.profile')
                    </p>
                </header>
                <div class="card-content">
                    <div class="content">
                        @if (session('message'))
                            <p class="notification is-success"> {{ session('message') }}</p>
                        @endif
                        <form action="{{ route('profile.save') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="field">
                                <label class="label"> @lang('auth.name') </label>
                                <div class="control">
                                    <input class="input" type="text" placeholder="Роман Андреевич" name="name"
                                           value="{{ $user->name }}">
                                </div>
                                @if ($errors->has('name'))
                                    <p class="help is-danger">
                                        {{ $errors->first('name') }}
                                    </p>
                                @endif
                            </div>
                            <div class="field">
                                <label class="label">@lang('auth.email'):</label>
                                <div class="control">
                                    <input class="input" type="email" placeholder="roman@gmail.com" name="email"
                                           value="{{ $user->email }}">
                                </div>
                                @if ($errors->has('email'))
                                    <p class="help is-danger">
                                        {{ $errors->first('email') }}
                                    </p>
                                @endif
                            </div>

                            <div class="field">
                                <label class="label">@lang('auth.new_password'):</label>
                                <div class="control">
                                    <input class="input" type="password" placeholder="" name="password" value="">
                                </div>
                                @if ($errors->has('password'))
                                    <p class="help is-danger">
                                        {{ $errors->first('password') }}
                                    </p>
                                @endif
                            </div>

                            <div class="field">
                                <label class="label">@lang('auth.password_confirmation'):</label>
                                <div class="control">
                                    <input class="input" type="password" placeholder="" name="password_confirmation"
                                           value="">
                                </div>
                                @if ($errors->has('password_confirmation'))
                                    <p class="help is-danger">
                                        {{ $errors->first('password_confirmation') }}
                                    </p>
                                @endif
                            </div>
                            <div class="field is-grouped">
                                <div class="control">
                                    <button class="button is-link" type="submit">@lang('content.save')</button>
                                </div>
                                <div class="control">
                                    <button class="button is-text" type="reset">@lang('content.reset')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
