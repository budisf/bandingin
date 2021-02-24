@extends('layouts.app')
@section('content')

    <div class="container ">
        <div class="row">
        @foreach($library as $lib)
        <div class="col-12 col-md-4 col-sm-4">
        <div class="card text-white align-middle bg-success mb-3">
        <div class="card-body">
            <h5 class="card-title text-center">{{$lib->name}}</h5>
            <?php
                $book = App\DetailLibrary::with('book')->where('library_id',$lib->id)->get();
            ?>
                <div class="row">
                    @foreach($book as $b)
                    <div class="col-4">
                    {{$b->book->name}}
                    </div>
                    @endforeach
                </div>
        </div>
        </div>
        </div>
        @endforeach
        </div>
    </div>

@endsection