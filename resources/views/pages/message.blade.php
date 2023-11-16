@extends('layouts.main')
@section('title', 'Messages')
@section('content')
<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow-y: hidden;
    }

    .nowrap {
        white-space: normal;
        overflow-wrap: break-word;
    }

</style>
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i id="icon_title" class="ik ik-message-square bg-blue"></i>
                    <div class="d-inline">
                        <h5>{{ __('Messages Category')}}</h5>
                        <span>{{ __('Lists of Messages Category')}}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">{{ __('Notifications')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Messages Category')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div id="row_form" class="row" style="display:none">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 id="title_form" class="font-weight-bold"></h3>
                </div>
                <div class="card-body">
                    {{-- enctype="multipart/form-data" --}}
                    <form class="forms-sample" id="form_message">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input_category">Select Category<span class="text-red">*</span></label>
                                    <select name="category" id="input_category" class="form-control select2">
                                        {{-- <option value="basic" selected>Basic</option>
                                        <option value="bronze">Bronze</option>
                                        <option value="silver">Silver</option> --}}
                                    </select>
                                    <div id="error_category" class="invalid-feedback" style="display:none">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_title">Title<span class="text-red">*</span></label>
                                    <input id="input_title" type="text" class="form-control" name="title" value="" placeholder="Enter message title" required="">
                                    <div id="error_title" class="invalid-feedback" style="display:none">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Image</label>
                                    {{-- <div id="input_image" class="input-images" data-input-name="image" data-label="Drag & Drop message images here or click to browse"></div> --}}
                                    <img id="image_preview" src="#" alt="Preview Image" style="max-width: 100%; display: none;">
                                    <input type="file" id="input_image" name="image" class="form-control">
                                    <div id="error_image" class="invalid-feedback" style="display:none">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea id="input_description" name="description" class="form-control html-editor h-205" rows="10"></textarea>
                                    <div id="error_description" class="invalid-feedback" style="display:none">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="input_url">URL<span class="text-red">*</span></label>
                                    <input name="url" type="text" class="form-control" id="input_url" placeholder="URL" />
                                    <div id="error_url" class="invalid-feedback" style="display:none">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_label">Label<span class="text-red">*</span></label>
                                    <input name="label" type="text" class="form-control" id="input_label" placeholder="Label" />
                                    <div id="error_label" class="invalid-feedback" style="display:none">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_datetime">Date Time<span class="text-red">*</span></label>
                                    <input name="datetime" type="datetime-local" class="form-control" id="input_datetime" placeholder="">
                                    <div id="error_datetime" class="invalid-feedback" style="display:none">
                                    </div>
                                </div>
                                <button onclick="runFunction(event,'save')" id="button_save" type="submit" class="btn btn-primary mr-2">Save</button>
                                <button onclick="runFunction(event,'cancel')" class="btn btn-light">Cancel</button>
                            </div>
                        </div>

                        {{-- <div class="dropdown d-inline-block">
                            <a class="nav-link dropdown-toggle" href="#" id="moreDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ik ik-more-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="/purchases/1/edit"><i class="ik ik-edit"></i> Edit </a>


                                <a class="dropdown-item" href="#">
                                    <i class="ik ik-trash"></i> Delete </a>
                            </div>
                        </div> --}}
                    </form>
                    <div id="selected_value" style="display:none"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="row_table" class="row">
        <div class="col-md-12">
            {{-- alert-success alert-dismissible --}}
            {{--
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ik ik-x"></i>
                </button>
            --}}
            <div id="notification" class="alert alert-success fade show" role="alert" style="cursor: pointer;display:none">
                <div id="notification_body" class="font-weight-bold"></div>
            </div>
            <div class="card">
                <div class="card-header d-block">
                    <div class="d-flex flex-row">
                        <div>
                            <h3 class="pt-2">Table of message lists</h3>
                        </div>
                        <div class="col col-sm-2">
                            <a onclick="runFunction(event,'add')" href="javascript:void(0)" class="btn btn-primary btn-rounded">Add Message</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dt-responsive">
                        <table id="table_message" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Category</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Description</th>
                                    <th>URL</th>
                                    <th>Label</th>
                                    <th>Datetime</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- push external js -->
@push('script')
<script src="{{ asset('js/form-components.js') }}"></script>
<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('plugins/DataTables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/datatables.js') }}"></script>
@endpush


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function notif(value) {
        if (value == "success") {
            $('#notification').removeClass('alert-danger').addClass('alert-success');
        } else if (value == "error") {
            $('#notification').removeClass('alert-success').addClass('alert-danger');
        }
    }

    function ajaxCall(from, url, type, data) {
        if (from == "save" || from == "edit" || from == "delete") {
            var combinedFormData = new FormData();

            for (var key in data) {
                combinedFormData.append(key, data[key]);
            }

            $.each($('#input_image')[0].files, function(i, file) {
                combinedFormData.append('image[]', file);
            });

            data = combinedFormData;
        }

        $.ajax({
            url: url
            , type: type
            , cache: false
            , dataType: 'json'
            , enctype: 'multipart/form-data'
            , processData: (from == "save" || from == "edit" || from == "delete") ? false : true
            , contentType: (from == "save" || from == "edit" || from == "delete") ? false : 'application/x-www-form-urlencoded'
            , data: data
            , success: function(result) {
                if (result.data === true) {
                    if (from == "save" || from == "edit" || from == "delete") {
                        notif('success');
                        runFunction(event, 'cancel');

                        $('#notification_body').html(result.notif);
                        $('#notification').show();
                        $('#table_message').DataTable().ajax.reload();
                    } else if (from == "getOption") {
                        var option = "";
                        $.each(result.array, function(key, value) {
                            if (key == 0) {
                                option += "<option value='" + value + "' selected>" + value + "</option>";
                            } else {
                                option += "<option value='" + value + "'>" + value + "</option>";
                            }
                        });
                        $('#input_category').html(option);
                    } else if (from == "table") {
                        $('#table_message').DataTable().ajax.reload();
                    } else if (from == "open_edit") {
                        $.each(result.array, function(key, value) {
                            if (key == "category") {
                                $('#input_' + key).val(value).trigger('change');
                                $('#input_' + key).prop('disabled', false);
                            } else if (key == "description") {
                                $('#input_' + key).summernote('code', value);
                                $('#input_' + key).summernote('enable');
                            } else {
                                $('#input_' + key).val(value);
                                $('#input_' + key).prop('readonly', false);
                            }
                        });
                    } else if (from == "open_delete") {
                        $.each(result.array, function(key, value) {
                            if (key == "category") {
                                $('#input_' + key).val(value).trigger('change');
                                $('#input_' + key).prop('disabled', true);
                            } else if (key == "description") {
                                $('#input_' + key).summernote('code', value);
                                $('#input_' + key).summernote('disable');
                            } else {
                                $('#input_' + key).val(value);
                                $('#input_' + key).prop('readonly', true);
                            }
                        });
                    }
                } else {
                    //
                }
            }
            , error: function(xhr, status, error) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, message) {
                        $('#input_' + field).addClass('is-invalid');
                        $('#error_' + field).html(message).show();
                    });
                } else {
                    notif('error');
                    runFunction(event, 'cancel');

                    $('#notification_body').html('Error attempt, after ajax request!');
                    $('#notification').show();
                }
            }
        });
    }

    function runFunction(event, value, data) {
        $('#notification').hide();

        if (event) {
            event.preventDefault();
        }

        if (value == "getOption") {
            var from = value;
            var url = "{{ route('getOptionCategory') }}";
            var type = "GET";
            var data = {
                parameter: 'get_option'
            };

            ajaxCall(from, url, type, data);
        } else if (value == "table") {
            var from = value;
            var url = "{{ route('getMessage') }}";
            var type = "GET";
            var data = {
                parameter: 'get_table'
            };

            ajaxCall(from, url, type, data);
        } else if (value == "save") {
            var text = $('#button_save').text();
            if (text == "Create") {
                var url = "{{ route('addMessage') }}";

                var from = value;
                var type = "POST";
                var data = 'parameter=' + text + '&' + $('#form_message').serialize();
                var dataURL = new URLSearchParams(data);
                var serialize = Object.fromEntries(dataURL);
            } else if (text == "Edit") {
                var url = "{{ route('editMessage') }}";

                var value = $('#selected_value').text();
                var from = 'edit';
                var type = "POST";
                var data = 'parameter=save&value=' + value + '&' + $('#form_message').serialize();
                var dataURL = new URLSearchParams(data);
                var serialize = Object.fromEntries(dataURL);
            } else if (text == "Delete") {
                var url = "{{ route('deleteMessage') }}";

                var value = $('#selected_value').text();
                var from = 'delete';
                var type = "POST";
                var data = 'parameter=confirm&value=' + value + '&' + $('#form_message').serialize();
                var dataURL = new URLSearchParams(data);
                var serialize = Object.fromEntries(dataURL);
            }
            ajaxCall(from, url, type, serialize);
        } else if (value == "add") {
            $('#button_save').removeClass('btn-success btn-danger').addClass('btn-primary').html('Create');
            $('#title_form').html('Add Message');
            $('#row_form').show();
            $('#row_table').hide();
        } else if (value == "cancel") {
            $('#button_save').removeClass('btn-success btn-danger').addClass('btn-primary').html('Create');
            $('#form_message').trigger('reset');
            $('#row_form').hide();
            $('#row_table').show();

            runFunction(event, 'table');
        } else if (value == "open_edit") {
            $('#selected_value').html(data);
            $('#button_save').removeClass('btn-primary btn-danger').addClass('btn-success').html('Edit');
            $('#title_form').html('Edit Message');
            $('#row_form').show();
            $('#row_table').hide();

            var from = value;
            var url = "{{ route('editMessage') }}";
            var type = "POST";
            var data = {
                parameter: 'get'
                , value: data
            };

            ajaxCall(from, url, type, data);
        } else if (value == "open_delete") {
            $('#selected_value').html(data);
            $('#button_save').removeClass('btn-primary btn-success').addClass('btn-danger').html('Delete');
            $('#title_form').html('Delete This Message?');
            $('#row_form').show();
            $('#row_table').hide();

            var from = value;
            var url = "{{ route('deleteMessage') }}";
            var type = "POST";
            var data = {
                parameter: 'get'
                , value: data
            };

            ajaxCall(from, url, type, data);
        }

        restate();

        function restate() {
            var arrInput = ['category', 'title', 'image', 'description', 'url', 'label', 'datetime'];
            $.each(arrInput, function(key, value) {
                if (value == 'category') {
                    $('#input_' + value).removeClass('is-invalid').prop('disabled', false);
                    $('#error_' + value).hide();
                } else if (value == 'description') {
                    $('#input_' + value).summernote('enable');
                    $('#input_' + value).summernote('code', '');
                    $('#error_' + value).hide();
                } else {
                    $('#input_' + value).removeClass('is-invalid').prop('readonly', false);
                    $('#error_' + value).hide();
                }
            });
            $('#image_preview').hide();
        }
    }

    $('#form_message').on('keypress', function(e) {
        if (e.which == 13) {
            e.preventDefault();
            //runFunction(event, 'save');
        }
    });

    $('#notification').click(function() {
        $('#notification').hide();
    });

    $('#input_image').on('change', function() {
        var input = this;

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#image_preview').attr('src', e.target.result);
                $('#image_preview').show();
            };

            reader.readAsDataURL(input.files[0]);
        }
    });

    $(document).ready(function() {
        runFunction(event, 'getOption');
        runFunction(event, 'table');

        var url = "{{ route('getMessage') }}";
        $('#table_message').DataTable({
            processing: true
            , serverSide: true
            , ajax: url
            , columns: [{
                    data: "no"
                    , name: "no"
                }
                , {
                    data: "category"
                    , name: "category"
                }, {
                    data: "title"
                    , name: "title"
                }, {
                    data: "image"
                    , name: "image"
                }, {
                    data: "description"
                    , name: "description"
                }, {
                    data: "url"
                    , name: "url"
                }, {
                    data: "label"
                    , name: "label"
                }, {
                    data: "datetime"
                    , name: "datetime"
                }
                , {
                    data: "action"
                    , name: "action"
                    , orderable: false
                    , searchable: false
                }
            ]
            , lengthMenu: [
                [10, 20, 50, 100, -1]
                , [10, 20, 50, 100, "All"]
            , ]
            , scrollX: true
            , scrollCollapse: true
        });
    });

</script>


@endsection
