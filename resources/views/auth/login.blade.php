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
                        <form class="form" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label for="email" class="col-md-4 label">@lang('auth.email')</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <input id="email" type="email"
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
                                    <label for="password" class="col-md-4 label">@lang('auth.password')</label>
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
                                <div class="field-label">
                                    <!-- Left empty for spacing -->
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <input type="checkbox"
                                                   name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('auth.remember')
                                        </div>
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
                                                @lang('auth.signin')
                                            </button>
                                            <a class="button is-text" href="{{ route('password.reset') }}">
                                                @lang('auth.forgot_password')
                                            </a>
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
