@extends('layouts.admin')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Permission</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">Permissions</a></li>
                        <li class="breadcrumb-item active">Edit Permission</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <form action="{{ route('admin.permissions.update', $permission) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
{{--                        <p class="text-info">--}}
{{--                            <i class="fas fa-info"></i>--}}
{{--                            Note: Use plural for models for consistent naming convention.--}}
{{--                        </p>--}}
                        <input type="hidden" name="id" value="{{ $permission->id }}">
                        <div class="form-group">
                            <label for="name">Name </label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" placeholder="Admin" value="{{ old('name', $permission->name) }}" readonly>
                            @error('name')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="guard_name">Guard Name </label>
                            <select class="form-control @error('guard_name') is-invalid @enderror" name="guard_name" id="guard_name" readonly>
                                @foreach ($guards as $guard)
                                    <option value="{{ $guard }}" @if(old('guard_name', $permission->guard_name) == $guard) selected @endif>{{ $guard }}</option>
                                @endforeach
                            </select>
                            @error('guard_name')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="description" class="required">Description </label>
                            <input class="form-control @error('description') is-invalid @enderror" type="text" name="description" id="description" placeholder="Description" value="{{ old('description', $permission->description) }}">
                            @error('description')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row justify-content-between mx-0">
                            <div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a class="btn mr-2" href="{{ route('admin.permissions.index') }}">Back to List</a>
                            </div>
{{--                            <div>--}}
{{--                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete">--}}
{{--                                    Delete--}}
{{--                                </button>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

{{--@section('modal')--}}
{{--    <div class="modal fade" id="modal-delete">--}}
{{--        <div class="modal-dialog">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h4 class="modal-title">Confirm Delete</h4>--}}
{{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                        <span aria-hidden="true">×</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <p>Are you sure you want to delete this item?</p>--}}
{{--                </div>--}}
{{--                <div class="modal-footer justify-content-between">--}}
{{--                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>--}}
{{--                    <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST">--}}
{{--                        @csrf--}}
{{--                        @method('DELETE')--}}
{{--                        <button type="submit" class="btn btn-danger">Confirm</button>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- /.modal-content -->--}}
{{--        </div>--}}
{{--        <!-- /.modal-dialog -->--}}
{{--    </div>--}}
{{--@endsection--}}
