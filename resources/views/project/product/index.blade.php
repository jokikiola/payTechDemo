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
                                data-toggle="modal" data-target="#addProduct" class="btn btn-danger addProduct"><i
                                    class="nav-icon fas fa-plus "></i> New Product
                            </button>
                        </h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Setup</a></li>
                            <li class="breadcrumb-item active">Product</li>
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
                                        <th>Service</th>
                                        <th>Product Name</th>
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

    @include('project.product.partials._add')
    @include('project.product.partials._edit')
    @include('project.product.partials._delete')
@endsection
@push('page-script')

    @include('project.product.script._js')

@endpush
