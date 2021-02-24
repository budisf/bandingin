@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-12">
            <div class="card">
                <div class="card-header">{{ __('Books') }}</div>

                <div class="card-body">
                <a  href="javascript:void(0)" id="create-new-book" class="btn btn-primary">Tambah</a> <br><br>
                <table class="table table-striped table-bordered table-hover table-checkable order-column"
                                    id="bookTable">
                        <thead class="thead-dark">
                            <tr>
                            
                            <th scope="col" >ID</th>
                            <th scope="col">No</th>
                            <th scope="col">Title</th>
                            <th scope="col">Category</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                    
                        </tbody>
                </table>
            </div>
        </div>
    </div>

 <!-- MULAI MODAL FORM TAMBAH/EDIT-->
 <div class="modal fade" id="ajax-book-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="bookCrudModal"></h4>
                </div>
                <div class="modal-body">
                    <form id="bookForm" name="bookForm" class="form-horizontal" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="hidden" name="book_id" id="book_id">
                                <div class="form-group">
                                    <label for="name" class="col-sm-12 control-label">Title</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Enter Title" value="" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 ">
                                <div class="form-group">
                                <label for="category"  class="col-sm-12 control-label">Category</label>
                                    <div class="col-sm-12">
                                        <select  name="category" class="form-control" id="category" >
                                            @foreach($categories as $cat)
                                            <option value=" {{$cat->id}}"> {{$cat->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="author" class="col-sm-12 control-label">Author</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="author" name="author"
                                            placeholder="Author" value="" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block" id="btn-save"
                                        value="create">Save
                                        changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- AKHIR MODAL -->
@endsection
@section('javascript')
<script>
     $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function() {
                $('#bookTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "/books_show",
                    columns: [{
                    data: 'id',
                    name: 'id',
                    'visible': false
                },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
         
                {
                    data: 'name',
                    name: 'name'
                },

                {
                    data: 'category_name',
                    name: 'category_name'
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                },
            ],
            order: [
                [0, 'desc']
            ]
                });
            });
                
            $('#create-new-book').click(function () {
                $('#btn-save').val("create-book");
                $('#book_id').val('');
                $('#bookForm').trigger("reset");
                $('#bookCrudModal').html("Add New Book");
                $('#ajax-book-modal').modal('show');
            });

            $('body').on('submit', '#bookForm', function (e) {
                e.preventDefault();
                var actionType = $('#btn-save').val();
                $('#btn-save').html('Sending..');
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "/book/store",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $('#bookForm').trigger("reset");
                        $('#ajax-book-modal').modal('hide');
                        $('#btn-save').html('Save Changes');
                        var oTable = $('#bookTable').dataTable();
                        oTable.fnDraw(false);
                        // iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                        //     title: 'Data Berhasil Disimpan',
                        //     message: '{{ Session('
                        //     success ')}}',
                        //     position: 'bottomRight'
                        // });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#btn-save').html('Save Changes');
                    }
                });
            });

            $('body').on('click', '.edit-book', function () {
                var id = $(this).data('id');
                $.get('/book/' + id + '/edit', function (data) {
                    $('#bookCrudModal').html("Edit Category");
                    $('#btn-save').val("edit-category");
                    $('#ajax-book-modal').modal('show');
                    $('#book_id').val(data.books.id);
                    $('#name').val(data.books.name);
                    $('#author').val(data.books.author);
                    $("#category").html(data.list_cat).show();
                    // $('#category').val(data.category_id);
                    var oTable = $('#bookTable').dataTable();
                    oTable.fnDraw(false);
                })
            });

        });

        function hapus(e){
    
            var id = $(e).data("id");
            swal({
                title: 'Apakah anda yakin ingin menghapus data ini ?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: '#3085d6',
                confirmButtonText: "Ya, Hapus Data!",
                cancelButtonText: "Tidak",
                // buttonsStyling: true
            }).then((willDelete) =>  {
            if (willDelete) {
                $.ajax({
                    type: "POST",
                    url: "/book/"+id+"/delete",
                    data: 'id='+id,
                    cache: false,
                    success: function(response) {
                    // refreshTable();
                    swal(
                        'Berhasil!',
                        'Data berhasil dihapus!',
                        'success'
                    )
                    location.reload();
                    }
                });
            }   
                
            });
        }
        
</script>
@endsection