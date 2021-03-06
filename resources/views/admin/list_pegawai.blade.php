@extends('layouts.user')
@section('css_addon')
    <style>
        [hidden] {
          display: none !important;
        }
    </style>
@endsection
@section('js_addon')
    <script>       
        $(document).ready(function() {
            $('#table-penduduk-sortable').DataTable({
                "searching": true,
                "bPaginate": true
            });
        });
        $('.btn-edit').on('click', function(){
            var penduduk_id = $(this).attr('penduduk');
            var noKtp = $(this).attr('noKtp');
            var nama = $(this).attr('nama');
            var tmptLahir = $(this).attr('tmptLahir');
            var tglLahir = $(this).attr('tglLahir');
            var selectTipe = $(this).attr('jk');
            var agama = $(this).attr('agama');
            var alamat = $(this).attr('alamat');
            var no_telp = $(this).attr('no_telp');    
            var image_url = $(this).attr('image_url');
            // var file_url = $(this).attr('file_url');

            $('input[id="penduduk_id"]').val(penduduk_id);
            $('input[id="noKtp"]').val(noKtp);
            $('input[id="nama"]').val(nama);
            $('input[id="tmptLahir"]').val(tmptLahir);
            $('input[id="tglLahir"]').val(tglLahir);
            $('select[id="selectTipe"]').val(selectTipe);
            $('input[id="agama"]').val(agama);
            $('textarea[id="alamat"]').val(alamat);
            $('input[id="no_telp"]').val(no_telp);
 
            $('form[name="form-edit"]').attr('action', '/home/edit/');
            if(image_url != ""){
                $('#showImg').attr('src', 'http://localhost:8000/storage/'+image_url);
            }else{
                $('#showImg').attr('src', '{{ asset('img/profile2.png') }}');
            }
     
            // if(file_url != ""){
            //     var arr_name = file_url.split('/');
            //     var filename = arr_name[arr_name.length-1];
            //     $("#berkas-edit").filestyle('placeholder', filename);
            // }
 

        });
        $('.btn-delete').on('click', function () {
            var url = $(this).attr('url');

            swal({
                title: "Anda Yakin?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, hapus saja",
                closeOnConfirm: false
            }, function(){
                window.location.href = url;
            });
        });
        $('.btn-tambah').on('click', function(){
            var nips = $(this).attr('nips');
            // var seek = false;
            swal({
                title: "Cek NIP!",
                type: "input",
                text: "Tediri dari 16 digit",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: "Masukkan NIP"
            },
            function(inputValue){
                if(inputValue === false) return false;
                if(inputValue === ""){
                    swal.showInputError("Mohon inputkan NIP");
                    return false;
                }
                var seek = nips.indexOf(inputValue);
                if(seek == -1){
                    swal.close();
                    $('#add-ktp').val(inputValue);
                    $('#modalAdd').modal("toggle");
                }else{
                    swal.showInputError("NIP Sudah Ada");
                    return false;
                }
                // for(i=0;i<nips.length;i++){
                //     if(nips[i].localeCompare(inputValue) == 0){
                //         break;
                //     }
                // }
                // if(seek === true){
                //     swal.showInputError("NIP Sudah Ada");
                //     return false;
                // }else{
                //     swal.close();
                //     $('#modalAdd').modal("toggle");
                // }
            });
        });
        
        {{--$('.btn-upload').on('click', function () {
                            var penduduk_id = $(this).attr('penduduk');
                            $('input[id="penduduk_id_upload"]').val(penduduk_id);
                        });--}}
            function readURL(input){
                if(input.files && input.files[0]){
                    var reader = new FileReader();
         
                    reader.onload = function(e){
                        $('#showImg').attr('src', e.target.result);
                    }
         
                    reader.readAsDataURL(input.files[0]);
                }
            }
    $('#imgInput').change(function(){
        readURL(this);
    });
        
        $(document).ready(
            function(){
                $('#uploadPic').change(
                    function(){
                        if ($(this).val()) {
                            $('#submitUploadPic').removeAttr('disabled'); 
                        } 
                    }
                );
                $(".modal").on("hidden.bs.modal", function() {
                    $("#uploadPic").val("");
                    $('#submitUploadPic').attr('disabled', 'disabled');
                });                
        });
    </script>
@endsection
@section('content')
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row"><div class="col-md-12"> 
                   
                  <p align="center">
                    <!-- /. ROW  -->   
					  <font face="Comic sans MS" size="5">List Pegawai</font></p>
                  <br>
                    @include('flash::message')
                    @include('sweet::alert')
                  <form method="get">
                        <div class="row">
                            <div class="col-md-9">
                                <button type="button" class="btn btn-primary btn-tambah" nips="{{ $nips }}">Tambah Pegawai</button>
                            </div>
                            {{--<div class="col-md-3 col-sm-12 col-xs-12 float-md-right float-sm-none">
                                    <div class="form-group">
                                        <input type="text" class="search form-control" placeholder="Search by No.KTP/Nama" name="search" value="{{ $search or "" }}" >
                                    </div>
                                </div>--}}
                        </div>
                  </form>
                  <br>
                  <div class="table-responsive">
                        <table id="table-penduduk-sortable" class="table table-hover table-sm">
                            <thead>
                                <tr>    
                                    <th class="text-xs-center">#</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th style="text-align: center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($penduduks as $penduduk)
                                <tr>
                                    <td class="text-xs-center">{{ $loop->iteration }}</td>
                                    <td>{{ $penduduk->noKtp }}</td>
                                    <td>{{ $penduduk->nama }}</td>
                                    <td>{{ $penduduk->getJK() }}</td>

                                    <td th style="text-align: center">
                                        <a href="{{ url('/home/detail') }}/{{ $penduduk->id }}" type="button" class="btn btn-success btn-sm">Detail</a>
                                        <button type="button" class="btn btn-info btn-sm btn-edit"
                                                data-toggle="modal" penduduk="{{ $penduduk->id }}"
                                                noKtp="{{ $penduduk->noKtp }}"
                                                nama="{{ $penduduk->nama }}"
                                                tmptLahir="{{ $penduduk->tmptLahir }}"
                                                tglLahir="{{ $penduduk->tglLahir }}"
                                                agama="{{ $penduduk->agama }}"
                                                jk="{{ $penduduk->jk }}"
                                                alamat="{{ $penduduk->alamat }}"
                                                no_telp="{{ $penduduk->no_telp }}"
                                                image_url="{{ $penduduk->image_url }}"
                                                data-target="#modalEdit">Edit
                                        </button>
                                        <button type="button" url="{{ url('/home/delete') }}/{{ $penduduk->id }}"
                                           class="btn btn-danger btn-sm btn-delete">Delete
                                        </button>
                                        {{--<button type="button" data-toggle="modal" data-target="#modalUpload" penduduk="{{ $penduduk->id }}" class="btn btn-upload btn-primary btn-sm">Upload</button>--}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>
                  <br>
                  
                  </div>
                    
                </div>              
                 <!-- /. ROW  -->
                  <hr />
              
                   
                 <!-- /. ROW  -->           
    	  </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
         
    <!-- Modal Add Pegawai-->
    <div class="modal fade" id="modalAdd" tabindex="-1">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modalAddLabel">Tambah Penduduk</h4>
                </div>
                <div class="modal-body">
                    <form class="form" enctype="multipart/form-data" action="{{ url('/home/create') }}" method="post">
                        {{ csrf_field() }}

                        <label>NIP</label>
                        <input class="form-group form-control" type="text" name="noKtp" id="add-ktp" readonly required>

                        <label>Nama</label>
                        <input class="form-group form-control" type="text" name="nama" required>

                        <label>Tempat Lahir</label>
                        <input class="form-group form-control" type="text" name="tmptLahir" required>

                        <label>Tanggal Lahir</label>
                        <small class="form-text text-muted">(format : dd-mm-yy)</small>
                        <input class="form-group form-control" type="text" name="tglLahir" required>

                        <label>Jenis Kelamin</label>
                        <div class="form-group">
                            <select class="form-control" id="selectTipe" name="jk">
                                <option value="1">Laki-Laki</option>
                                <option value="2">Perempuan</option>
                            </select>
                        </div>

                        <label>Agama</label>
                        <input class="form-group form-control" type="text" name="agama" required>

                        <label>Alamat</label>
                        <textarea class="form-group form-control" rows="5" name="alamat" required></textarea>

                        <label>No. Telepon/HP</label>
                        <small class="form-text text-muted">(Terdiri dari 12 digit)</small>
                        <input class="form-group form-control" type="text" name="no_telp" required>

                        <label>Foto</label>
                        <small class="form-text text-muted">(types : *.jpg | *.png)</small>
                        <input type="file" accept=".jpg, .png, .jpeg" name="image_url" class="filestyle form-group" data-buttonName="btn-info" data-placeholder="Tidak ada file" data-buttonText="Upload Foto" data-iconName="glyphicon glyphicon-user" data-buttonBefore="true">

                        {{--<label>Berkas</label>
                                                                        <small class="form-text text-muted">(types : *.pdf | *.ppt |*.pptx | *.doc | *.docx | *.jpg | *.png, etc)</small>
                                                                        <input type="file" name="file_url" class="filestyle form-group" data-buttonName="btn-success" data-placeholder="Tidak ada file" data-buttonText="Upload File" data-iconName="glyphicon glyphicon-file" data-buttonBefore="true">--}}

                        <div class="modal-footer">
                            <hr>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pegawai-->
    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Edit Penduduk</h4>
                </div>
                <div class="modal-body">
                    <form name="form-edit" enctype="multipart/form-data" class="form" action="{{ url('/home/edit') }}" method="post">
                        {{ csrf_field() }}

                        <div class="center-block text-center" style="width:200px">
                            <img class="img-responsive img-thumbnail" id="showImg" src="#" alt="your image">
                            <br>
                        </div>
                        <div class="pull-right">
                            <input id="imgInput" type="file" accept=".jpg, .png, .jpeg" name="image_url" class="filestyle form-group" data-buttonName="btn-info" data-buttonText="Upload Foto" data-iconName="glyphicon glyphicon-upload" data-input="false" style="float: right;">
                        </div>
                        <br>
                        <input id="penduduk_id" style="display: none" name="penduduk_id">

                        <label>NIP</label>
                        <input class="form-group form-control" id="noKtp" type="text" name="noKtp" readonly>

                        <label>Nama</label>
                        <input class="form-group form-control" id="nama" type="text" name="nama" required>

                        <label>Tempat Lahir</label>
                        <input class="form-group form-control" id="tmptLahir" type="text" name="tmptLahir" required>

                        <label>Tanggal Lahir</label>
                        <small class="form-text text-muted">(format : dd-mm-yy)</small>
                        <input class="form-group form-control" id="tglLahir" type="text" name="tglLahir" required>

                        <label>Jenis Kelamin</label>
                        <div class="form-group">
                            <select class="form-control" id="selectTipe" name="jk">
                                <option value="1">Laki-Laki</option>
                                <option value="2">Perempuan</option>
                            </select>
                        </div>

                        <label>Agama</label>
                        <input class="form-group form-control" id="agama" type="text" name="agama" required>

                        <label>Alamat</label>
                        <textarea class="form-group form-control" id="alamat" rows="5" name="alamat" required></textarea>

                        <label>No. Telepon/HP</label>
                        <small class="form-text text-muted">(Terdiri dari 12 digit)</small>
                        <input class="form-group form-control" id="no_telp" type="text" name="no_telp" required>
     
                        {{--<label>Berkas</label>
                                                                        <small class="form-text text-muted">(types : *.pdf | *.ppt |*.pptx | *.doc | *.docx | *.jpg | *.png, etc)</small>
                                                                        <input id="berkas-edit" type="file" name="file_url" class="filestyle form-group" data-buttonName="btn-success" data-placeholder="Tidak ada file" data-buttonText="Upload File" data-iconName="glyphicon glyphicon-file" data-buttonBefore="true">--}}

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--<!-- Modal Upload File-->
            <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form class="form" id="form_upload" action="{{ url('/home/upload') }}" method="post" enctype="multipart/form-data">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">Upload Foto</h4>
                            </div>
                            <div class="modal-body">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label>Upload Foto</label>
                                    <input id="penduduk_id_upload" style="display: none" name="penduduk_id_upload">
        
                                    <input type="file" id="uploadPic" accept=".jpg, .png, .jpeg" name="image_url" class="form-control-file" data-buttonName="btn-info" data-placeholder="Tidak ada file" data-buttonText="Upload Foto" data-iconName="glyphicon glyphicon-user" data-buttonBefore="true">
        
                                    <small class="form-text text-muted">Upload Foto (types : *.jpg | *.png)</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="submitUploadPic" class="btn btn-primary" disabled>Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>--}}
@endsection        