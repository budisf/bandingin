@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Books</h5>
                            <p class="card-text">Klik button bellow to manage your book </p>
                            <a href="/books" class="btn btn-primary">Lets go</a>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Libraries</h5>
                            <p class="card-text">Klik button bellow to manage your libraries</p>
                            <a href="/libraries" class="btn btn-primary">Lets go</a>
                        </div>
                        </div>
                    </div>
                    </div><br>
                    <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                        <div class="card-body">
                        <a href="{{route('libraries.all')}}" type="button" class="btn btn-link">List Libraries and books</a>
                        </div>
                        </div>
                   </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
