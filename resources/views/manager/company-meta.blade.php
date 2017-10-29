@section('title', 'Редактирование Meta карточки фирмы')
@extends('layouts.main')

@section('content')
    <div class="columns">
        <div class="column is-offset-2 is-8">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                        @lang('manager.company_meta')
                    </p>
                </header>
                <div class="card-content">
                    <div class="content">
                        <company-meta></company-meta>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
