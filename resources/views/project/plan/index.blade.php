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
                                data-toggle="modal" data-target="#addPlan" class="btn btn-danger addPlan"><i
                                    class="nav-icon fas fa-plus "></i> New Plan and Subscription
                            </button>
                        </h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Setup</a></li>
                            <li class="breadcrumb-item active">Plan and Subscription</li>
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
                                        <th>Plan Name</th>
                                        <th>Amount</th>
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

    @include('project.plan.partials._add')
    @include('project.plan.partials._edit')
    @include('project.plan.partials._delete')
@endsection
@push('page-script')

    @include('project.plan.script._js')

@endpush
