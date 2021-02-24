@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-12">
            <div class="card">
                <div class="card-header">{{ __('Add book to ') }}{{$data['library_name']}}</div>

                <div class="card-body">
                <form id="bookForm" name="bookForm" class="form-horizontal" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="hidden" name="id" id="id">
                                <input type="hidden" name="library_id" value="{{$data['library_id']}}" id="library_id">
                                <div class="form-group">
                                    <label for="name" class="col-sm-12 control-label">Book</label>
                                    <div class="col-sm-12">
                                        <div class="input-group control-group increment" >
                                        <select  name="book[]" class="form-control" id="book" >
                                                @foreach($books as $book)
                                                <option value=" {{$book->id}}"> {{$book->name}} ({{$book->category->name}})</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-btn"> 
                                            <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm 12">
                                        <div class="clone hide">
                                        <div class="control-group input-group" style="margin-top:10px">
                                            <select  name="book[]" class="form-control" id="book" >
                                                @foreach($books as $book)
                                                <option value=" {{$book->id}}"> {{$book->name}} ({{$book->category->name}})</option>
                                                @endforeach
                                            </select>    
                                            <div class="input-group-btn"> 
                                            <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block" id="btn-save"
                                        value="create">Save
                                    </button>
                                </div>
                                </div>
                                    <a href="{{route('libraries.all')}}" type="button" class="btn btn-link">List Libraries and books</a>
                                </div>
                            </div>
                        </div>
                </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('javascript')
<script>

    $(document).ready(function() {
        
      $(".btn-success").click(function(){ 
          var html = $(".clone").html();
          $(".increment").after(html);
      });
      $("body").on("click",".btn-danger",function(){ 
          $(this).parents(".control-group").remove();
      });
    });

     $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
            $('body').on('submit', '#bookForm', function (e) {
                e.preventDefault();
                var actionType = $('#btn-save').val();
                $('#btn-save').html('Sending..');
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "/library/book/store",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $('#bookForm').trigger("reset");
                        $('#btn-save').html('Saved');
                        // var oTable = $('#bookTable').dataTable();
                        // oTable.fnDraw(false);
                        // iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                        //     title: 'Data Berhasil Disimpan',
                        //     message: '{{ Session('
                        //     success ')}}',
                        //     position: 'bottomRight'
                        // });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#btn-save').html('Saved');
                    }
                });
            });

        });
        
</script>
@endsection