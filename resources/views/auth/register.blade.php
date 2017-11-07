@extends('layouts.main')

@section('content')
    <div class="columns">
        <div class="column is-offset-2 is-8">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                        @lang('auth.login')
                    </p>
                </header>
                <div class="card-content">
                    <div class="content">

                        <form class="form" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label for="name" class="label">@lang('auth.name')</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <input id="name" type="text"
                                                   class="input {{ $errors->has('name') ? 'is-danger' : '' }}"
                                                   name="name" value="{{ old('name') }}" required autofocus>
                                        </div>
                                        @if ($errors->has('name'))
                                            <p class="help is-danger">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label for="email" class="label">@lang('auth.email')</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <input id="email" type="text"
                                                   class="input {{ $errors->has('email') ? 'is-danger' : '' }}"
                                                   name="email" value="{{ old('email') }}" required autofocus>
                                        </div>
                                        @if ($errors->has('email'))
                                            <p class="help is-danger">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label for="password" class="label">@lang('auth.password')</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <input id="password" type="password"
                                                   class="input {{ $errors->has('password') ? 'is-danger' : '' }}"
                                                   name="password" value="{{ old('password') }}" required autofocus>
                                        </div>
                                        @if ($errors->has('password'))
                                            <p class="help is-danger">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label for="password-confirm"
                                           class="label">@lang('auth.password_confirmation')</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <input id="password-confirm" type="password"
                                                   class="input {{ $errors->has('password_confirmation') ? 'is-danger' : '' }}"
                                                   name="password_confirmation"
                                                   value="{{ old('password_confirmation') }}" required autofocus>
                                        </div>
                                        @if ($errors->has('password_confirmation'))
                                            <p class="help is-danger">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label">
                                    <!-- Left empty for spacing -->
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <button type="submit" class="button is-primary">
                                                @lang('auth.register')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
