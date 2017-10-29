@extends('layouts.main')

@section('content')
    <div class="columns">
        <div class="column is-offset-2 is-8">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                        @lang('manager.main')
                    </p>
                </header>
                <div class="card-content">
                    <div class="content">
                        <p>
                            @lang('content.welcome')
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="container">
         <div class="row">
             <div class="col-md-8 col-md-offset-2">
                 <div class="panel panel-default">
                     <div class="panel-heading">@lang('content.dashboard')</div>

                     <div class="panel-body">
                         @if (session('status'))
                             <div class="alert alert-success">
                                 {{ session('status') }}
                             </div>
                         @endif

                     </div>
                 </div>
             </div>
         </div>
     </div>--}}
@endsection
