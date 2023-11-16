@extends('layouts.main')
@section('title', 'Level Membership')
@section('content')
    <style>
        #table-data {
            width: 100%;
            min-width: 100%;
        }
    </style>
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i id="icon_title" class="ik ik-star bg-yellow"></i>
                        <div class="d-inline">
                            <h5>{{ __('Level Membership') }}</h5>
                            <span>{{ __('Lists of level membership') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">{{ __('Membership') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Level Membership') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div id="row_form" class="row" style="display:none">
            <div class="col-md-12">
                <div class="card card-484">
                    <div class="card-header">
                        <h3 id="title_form" class="font-weight-bold"></h3>
                    </div>
                    <div class="card-body">
                        <form class="forms-sample" id="form_level">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="input_level">Level</label>
                                <div class="col-sm-9">
                                    <input name="level" type="text" class="form-control" id="input_level"
                                        placeholder="Name of Level" />
                                    <div id="error_level" class="invalid-feedback" style="display:none">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input_point" class="col-sm-3 col-form-label">Point</label>
                                <div class="col-sm-9">
                                    <input name="point" type="range" class="form-control" id="input_point"
                                        placeholder="0">
                                    <div id="error_point" class="invalid-feedback" style="display:none">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input_expiry" class="col-sm-3 col-form-label">Expiry</label>
                                <div class="col-sm-9">
                                    <input name="expiry" type="month" class="form-control" id="input_expiry"
                                        placeholder="">
                                    <div id="error_expiry" class="invalid-feedback" style="display:none">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input_description" class="col-sm-3 col-form-label">Description</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control html-editor h-205" rows="10" name="description" id="input_description">{{ old('description') }}</textarea>
                                    <div id="error_description" class="invalid-feedback" style="display:none">
                                    </div>
                                </div>
                            </div>
                            <button onclick="runFunction(event,'save')" id="button_save" type="submit"
                                class="btn btn-primary mr-2">Save</button>
                            <button onclick="runFunction(event,'cancel')" class="btn btn-light">Cancel</button>
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
                <div id="notification" class="alert alert-success fade show" role="alert"
                    style="cursor: pointer;display:none">
                    <div id="notification_body" class="font-weight-bold"></div>
                </div>
                <div class="card">
                    <div class="card-header d-block">
                        <div class="d-flex flex-row">
                            <div>
                                <h3 class="pt-2">Table of membership lists</h3>
                            </div>
                            <div class="col col-sm-2">
                                <a onclick="runFunction(event,'add')" href="javascript:void(0)"
                                    class="btn btn-primary btn-rounded">Add Level Membership</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="dt-responsive">
                            <table id="table-data" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Level</th>
                                        <th>Point</th>
                                        <th>Expiry</th>
                                        <th>Description</th>
                                        <th>Created</th>
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
            $.ajax({
                url: url,
                type: type,
                cache: false,
                dataType: 'json',
                data: data,
                success: function(result) {
                    if (result.data === true) {
                        if (from == "save" || from == "edit" || from == "delete") {
                            notif('success');
                            runFunction(event, 'cancel');

                            $('#notification_body').html(result.notif);
                            $('#notification').show();
                            $('#table-data').DataTable().ajax.reload();
                        } else if (from == "table") {
                            $('#table-data').DataTable().ajax.reload();
                        } else if (from == "open_edit") {
                            $.each(result.array, function(key, value) {
                                $('#input_' + key).val(value);
                                $('#input_' + key).prop('readonly', false);
                            });
                        } else if (from == "open_delete") {
                            $.each(result.array, function(key, value) {
                                $('#input_' + key).val(value);
                                $('#input_' + key).prop('readonly', true);
                            });
                        }
                    } else {
                        //
                    }
                },
                error: function(xhr, status, error) {
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

            var arrInput = ['level', 'point', 'expiry', 'description'];
            $.each(arrInput, function(key, value) {
                if (value == 'level') {
                    $('#input_' + value).removeClass('is-invalid').prop('disabled', false);
                    $('#error_' + value).hide();
                } else {
                    $('#input_' + value).removeClass('is-invalid').prop('readonly', false);
                    $('#error_' + value).hide();
                }
            });

            if (value == "table") {
                var from = value;
                var url = "{{ route('getMembership') }}";
                var type = "GET";
                var data = {
                    ajax: 'true'
                };

                ajaxCall(from, url, type, data);
            } else if (value == "save") {
                var text = $('#button_save').text();
                if (text == "Create") {
                    var url = "{{ route('addMembership') }}";

                    var from = value;
                    var type = "POST";
                    var data = 'parameter=' + text + '&' + $('#form_level').serialize();
                    var dataURL = new URLSearchParams(data);
                    var serialize = Object.fromEntries(dataURL);
                } else if (text == "Edit") {
                    var url = "{{ route('editMembership') }}";

                    var value = $('#selected_value').text();
                    var from = 'edit';
                    var type = "POST";
                    var data = 'parameter=save&value=' + value + '&' + $('#form_level').serialize();
                    var dataURL = new URLSearchParams(data);
                    var serialize = Object.fromEntries(dataURL);
                } else if (text == "Delete") {
                    var url = "{{ route('deleteMembership') }}";

                    var value = $('#selected_value').text();
                    var from = 'delete';
                    var type = "POST";
                    var data = 'parameter=confirm&value=' + value + '&' + $('#form_level').serialize();
                    var dataURL = new URLSearchParams(data);
                    var serialize = Object.fromEntries(dataURL);
                }
                ajaxCall(from, url, type, serialize);
            } else if (value == "add") {
                $('#button_save').removeClass('btn-success btn-danger').addClass('btn-primary').html('Create');
                $('#title_form').html('Add Level Membership');
                $('#row_form').show();
                $('#row_table').hide();
            } else if (value == "cancel") {
                $('#button_save').removeClass('btn-success btn-danger').addClass('btn-primary').html('Create');
                $('#form_level').trigger('reset');
                $('#row_form').hide();
                $('#row_table').show();

                runFunction(event, 'table');
            } else if (value == "open_edit") {
                $('#selected_value').html(data);
                $('#button_save').removeClass('btn-primary btn-danger').addClass('btn-success').html('Edit');
                $('#title_form').html('Edit Level Membership');
                $('#row_form').show();
                $('#row_table').hide();

                var from = value;
                var url = "{{ route('editMembership') }}";
                var type = "POST";
                var data = {
                    parameter: 'get',
                    value: data
                };

                ajaxCall(from, url, type, data);
            } else if (value == "open_delete") {
                $('#selected_value').html(data);
                $('#button_save').removeClass('btn-primary btn-success').addClass('btn-danger').html('Delete');
                $('#title_form').html('Delete This Level Membership?');
                $('#row_form').show();
                $('#row_table').hide();

                var from = value;
                var url = "{{ route('deleteMembership') }}";
                var type = "POST";
                var data = {
                    parameter: 'get',
                    value: data
                };

                ajaxCall(from, url, type, data);
            }
        }

        $('#form_level').on('keypress', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                runFunction(event, 'save');
            }
        });

        $('#notification').click(function() {
            $('#notification').hide();
        });

        $(document).ready(function() {
            //setTimeout(run, 1000);

            //function run() {
            runFunction(event, 'table');
            //}

            var urlMember = "{{ route('getMembership') }}";
            $('#table-data').DataTable({
                processing: true,
                serverSide: true,
                ajax: urlMember,
                columns: [{
                    data: "no",
                    name: "no"
                }, {
                    data: "level",
                    name: "level"
                }, {
                    data: "point",
                    name: "point"
                }, {
                    data: "expiry",
                    name: "expiry"
                }, {
                    data: "description",
                    name: "description"
                }, {
                    data: "created_at",
                    name: "created_at"
                }, {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false
                }, ],
                lengthMenu: [
                    [10, 20, 50, 100, -1],
                    [10, 20, 50, 100, "All"],
                ],
                scrollX: true,
                scrollCollapse: true
            });
        });
    </script>


@endsection
