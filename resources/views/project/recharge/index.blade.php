@extends('layouts.project.main')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Recharge
                            <button
                                data-toggle="modal" data-target="#recharge" class="btn btn-danger recharge"><i
                                    class="nav-icon fas fa-plus "></i> Recharge Here
                            </button>
                        </h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Recharge</a></li>
                            <li class="breadcrumb-item active">Recharge Here</li>
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
                                        <th>Transaction Ref #</th>
                                        <th>Service</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
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

    @include('project.recharge.partials._recharge')

@endsection
@push('page-script')

    @include('project.recharge.script._js')

@endpush
