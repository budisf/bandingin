@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-12">
            <div class="card">
                <div class="card-header">{{ __('Library') }}</div>

                <div class="card-body">
                <a  href="javascript:void(0)" id="create-new-library" class="btn btn-primary">Tambah</a> <br><br>
                <table class="table table-striped table-bordered table-hover table-checkable order-column"
                                    id="libraryTable">
                        <thead class="thead-dark">
                            <tr>
                            
                            <th scope="col" >ID</th>
                            <th scope="col">No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Adress</th>
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
 <div class="modal fade" id="ajax-library-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="libraryCrudModal"></h4>
                </div>
                <div class="modal-body">
                    <form id="libraryForm" name="libraryForm" class="form-horizontal" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="hidden" name="library_id" id="library_id">
                                <div class="form-group">
                                    <label for="name" class="col-sm-12 control-label">Name</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Enter Name" value="" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="address" class="col-sm-12 control-label">Addres</label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control" id="address" name="address"
                                            placeholder="Address" value=""></textarea>
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
                $('#libraryTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "/libraries_show",
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
                    data: 'address',
                    name: 'address'
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
                
            $('#create-new-library').click(function () {
                $('#btn-save').val("create-library");
                $('#library_id').val('');
                $('#libraryForm').trigger("reset");
                $('#libraryCrudModal').html("Add New library");
                $('#ajax-library-modal').modal('show');
            });

            $('body').on('submit', '#libraryForm', function (e) {
                e.preventDefault();
                var actionType = $('#btn-save').val();
                $('#btn-save').html('Sending..');
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "/library/store",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $('#libraryForm').trigger("reset");
                        $('#ajax-library-modal').modal('hide');
                        $('#btn-save').html('Save Changes');
                        var oTable = $('#libraryTable').dataTable();
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

            $('body').on('click', '.edit-library', function () {
                var id = $(this).data('id');
                $.get('/library/' + id + '/edit', function (data) {
                    $('#libraryCrudModal').html("Edit Category");
                    $('#btn-save').val("edit-category");
                    $('#ajax-library-modal').modal('show');
                    $('#library_id').val(data.id);
                    $('#name').val(data.name);
                    $('#address').val(data.address);
                    // $('#category').val(data.category_id);
                    var oTable = $('#libraryTable').dataTable();
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
            url: "/library/"+id+"/delete",
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