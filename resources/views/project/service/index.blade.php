@extends('layouts.project.main')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>System Setup
                            <button
                                data-toggle="modal" data-target="#addService" class="btn btn-danger"><i
                                    class="nav-icon fas fa-plus"></i> New Service
                            </button>
                        </h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Setup</a></li>
                            <li class="breadcrumb-item active">Services</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>


        <section class="content">
            <div class="container-fluid">
                <div class="card">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-body p-0">

                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('project.service.partials._add')
    @include('project.service.partials._edit')
    @include('project.service.partials._delete')
@endsection
@push('page-script')

    @include('project.service.script._js')

@endpush
