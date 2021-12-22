@extends('layouts.custom-app')

<head>
    <script src="{{ asset('') }}"></script>
    <link type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">

    <style>
        #potentialdatatable {}

        #potentialdatatable td,
        #potentialdatatable th {
            border-bottom: 1px solid #ddd;
            padding: 8px;
        }

        #potentialdatatable tr:last-child {
            border-bottom: 1px solid #ddd;
        }

        .dataTables_filter input[type=search] {
            border: none;
            border-bottom: 1px solid #ddd;
            outline: none;
        }
    </style>
</head>
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <h2 class="h4">All clients</h2>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <button data-bs-toggle="modal" data-bs-target="#newClient" type="button" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
            <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
            add new
        </button>
        <div class="btn-group ms-2 ms-lg-3">
            <a type="button" href="/sendmassemails" class="btn btn-sm btn-outline-gray-600">Notify All</a>
            <button type="button" class="btn btn-sm btn-outline-gray-600">Export</button>
        </div>
    </div>
</div>
@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card card-body border-0 shadow table-wrapper table-responsive">
    <table class="table table-hover" id="potentialdatatable">
        <thead>
            <tr>
                <th class="border-gray-200">Names</th>
                <th class="border-gray-200">Email</th>
                <th class="border-gray-200">Status</th>
                <th class="border-gray-200">Remarks</th>
                <th class="border-gray-200">Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($clients as $client)
            <tr>
                <td>
                    <span class="fw-normal">{{ $client->username }}</span>
                </td>
                <td><span class="fw-normal">{{ $client->email }}</span></td>
                <td><span class="fw-bold text-warning">{{ $client->status }}</span></td>
                <td><span class="fw-normal">{{ $client->remarks }}</span></td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="icon icon-sm">
                                <span class="fas fa-ellipsis-h icon-dark"></span>
                            </span>
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu py-0">
                            <a class="dropdown-item rounded-top" href="#"><span class="fas fa-eye me-2"></span>View
                                Details</a>
                            <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#editClient{{$client->id}}"><span class="fas fa-edit me-2"></span>Edit</button>
                            <a class="dropdown-item text-danger rounded-bottom" href="#"><span class="fas fa-trash-alt me-2"></span>Remove</a>
                        </div>
                    </div>
                </td>
            </tr>
            <!-- Edit Client Modal -->
            <div class="modal fade" id="editClient{{$client->id}}" tabindex="-1" role="dialog" aria-labelledby="editClientScrollableTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newClientScrollableTitle">Edit client</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="/edit-client/{{$client->id}}" autocomplete="off" class="form-horizontal">

                                @csrf
                                @method('put')
                                <div class="card ">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-sm-12 px-0 mx-0 my-0 py-0">
                                                <label class="col-sm-12 col-form-label py-0 my-0"><small>Name</small></label>
                                                <div class="col-sm-12">
                                                    <div class="form-group{{ $errors->has('') ? ' has-danger' : '' }}">
                                                        <input class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" id="input-username" type="text" required="true" aria-required="true" value="{{ old('username') ?? $client->username  }}">
                                                        @if ($errors->has('username'))
                                                        <span id="username-error" class="error text-danger" for="input-username">{{ $errors->first('username') }}</span>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-sm-12 px-0 mx-0 my-0 py-0">
                                                <label class="col-sm-12 col-form-label py-0 my-0"><small>Email</small></label>
                                                <div class="col-sm-12">
                                                    <div class="form-group{{ $errors->has('') ? ' has-danger' : '' }}">
                                                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="input-email" type="email" required="true" aria-required="true" value="{{ old('email') ?? $client->email }}">
                                                        @if ($errors->has('email'))
                                                        <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-sm-12 px-0 mx-0 my-0 py-0">
                                                <label class="col-sm-12 col-form-label py-0 my-0"><small>Description</small></label>
                                                <div class="col-sm-12">
                                                    <div class="form-group{{ $errors->has('') ? ' has-danger' : '' }}">
                                                        <textarea class="form-control{{ $errors->has('remarks') ? ' is-invalid' : '' }}" name="remarks" id="input-remarks" type="text" required="true" aria-required="true">{{ old('remarks')??$client->remarks }}</textarea>
                                                        @if ($errors->has('remarks'))
                                                        <span id="remarks-error" class="error text-danger" for="input-remarks">{{ $errors->first('remarks') }}</span>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>


                                            <div class="modal-footer col-md-12 my-0 mx-0 py-0">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary ml-1">{{ __('save details') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>

    </table>

</div>

<!-- Add Potential Client Modal -->
<div class="modal fade" id="newClient" tabindex="-1" role="dialog" aria-labelledby="newClientScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newClientScrollableTitle">New client</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" autocomplete="off" class="form-horizontal">
                    @csrf
                    <div class="card ">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-sm-12 px-0 mx-0 my-0 py-0">
                                    <label class="col-sm-12 col-form-label py-0 my-0"><small>Name</small></label>
                                    <div class="col-sm-12">
                                        <div class="form-group{{ $errors->has('') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" id="input-username" type="text" required="true" aria-required="true" value="{{ old('username') ?? $client->username}}">
                                            @if ($errors->has('username'))
                                            <span id="username-error" class="error text-danger" for="input-username">{{ $errors->first('username') }}</span>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-12 px-0 mx-0 my-0 py-0">
                                    <label class="col-sm-12 col-form-label py-0 my-0"><small>Email</small></label>
                                    <div class="col-sm-12">
                                        <div class="form-group{{ $errors->has('') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="input-email" type="email" required="true" aria-required="true" value="{{ old('email') }}">
                                            @if ($errors->has('email'))
                                            <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-12 px-0 mx-0 my-0 py-0">
                                    <label class="col-sm-12 col-form-label py-0 my-0"><small>Description</small></label>
                                    <div class="col-sm-12">
                                        <div class="form-group{{ $errors->has('') ? ' has-danger' : '' }}">
                                            <textarea class="form-control{{ $errors->has('remarks') ? ' is-invalid' : '' }}" name="remarks" id="input-remarks" type="text" required="true" aria-required="true">{{ old('remarks') }}</textarea>
                                            @if ($errors->has('remarks'))
                                            <span id="remarks-error" class="error text-danger" for="input-remarks">{{ $errors->first('remarks') }}</span>
                                            @endif
                                        </div>

                                    </div>
                                </div>


                                <div class="modal-footer col-md-12 my-0 mx-0 py-0">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary ml-1">{{ __('save details') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
    $('#potentialdatatable').DataTable({
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": [1, 2, 3, 4]
        }]
    });
</script>
@endsection