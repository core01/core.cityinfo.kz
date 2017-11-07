@extends('layouts.main')

@section('content')
    <div class="columns">
        <div class="column is-offset-2 is-8">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                        @lang('manager.users')
                    </p>
                </header>
                <div class="card-content">
                    <users></users>
                </div>
            </div>
        </div>
    </div>
@endsection
