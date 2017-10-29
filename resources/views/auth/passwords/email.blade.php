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
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                            {{ csrf_field() }}

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
                                <div class="field-label">
                                    <!-- Left empty for spacing -->
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <button type="submit" class="button is-primary">
                                                @lang('auth.reset_password_link')
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
