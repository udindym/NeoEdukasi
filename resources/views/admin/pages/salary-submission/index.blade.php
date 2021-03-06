<title>Pengajuan Gaji Tentor</title>
@extends('admin.layouts.app')

@section('css_before')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
@endsection

@section('js_after')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/buttons/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/buttons/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/buttons/buttons.colVis.min.js') }}"></script>

    <!-- Page JS Code -->
    <script src="{{ asset('js/pages/tables_datatables.js') }}"></script>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="block bg-body-light shadow-sm">
            <div class="content content-full bg-header-tentor" style="
                    background-image:url({{ asset('images/Asset/header-tentors.png') }});">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <div class="flex-grow-1">
                        <h1 class="h3 fw-bold mb-2">
                            Pengajuan Gaji Tentor
                        </h1>
                    </div>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">
                                {{ ucwords(
                                    Auth::user()->getRoleNames()->first(),
                                ) }}
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx"
                                    href="{{ route('admin.submission.salary-submission.index') }}">Pengajuan Gaji Tentor</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="block block-rounded tab-content px-3 px-sm-0 shadow-sm border-right-neo" id="nav-tabContent">
            <div class="bg-white p-2 push">
                <div class="d-lg-none">
                    <button type="button"
                        class="btn w-100 btn-alt-secondary d-flex justify-content-between align-items-center"
                        data-toggle="class-toggle" data-target="#horizontal-navigation-hover-centered"
                        data-class="d-none">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
                <nav>
                    <div id="horizontal-navigation-hover-centered" class="d-none d-lg-block ">
                        <ul class="nav nav-main nav-main-horizontal nav-main-hover nav-main-horizontal-center">
                            <li class="nav-main-item tab-pane">
                                <a class="nav-main-link link-fx active tab-pane" id="nav-interview-tab" data-toggle="tab"
                                    href="#nav-interview" role="tab" aria-controls="nav-home" aria-selected="true">
                                    <i class="nav-main-link-icon fa fa-paperclip"></i>
                                    <span class="nav-main-link-name">Pengajuan Gaji &nbsp</span>
                                </a>
                            </li>
                            <li class="nav-main-item tab-pane">
                                <a class="nav-main-link link-fx" id="nav-shortlist-tab" data-toggle="tab"
                                    href="#nav-shortlist" role="tab" aria-controls="nav-home" aria-selected="true">
                                    <i class="nav-main-link-icon fa fa-history"></i>
                                    <span class="nav-main-link-name">Riwayat Pengajuan Gaji &nbsp</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            @if ($errors->has('errors'))
                <div class="block-content">
                    <div class="alert alert-danger text-center">{{ $errors->first('errors') }}</div>
                </div>
                <div class="error">{{ $errors->first('firstname') }}</div>
            @endif
            <div class="col-xl-12 order-xl-0 tab-pane fade show active" id="nav-interview" role="tabpanel"
                aria-labelledby="nav-vacancyInformation-tab">
                <div class="block">
                    <div class="block-content block-content-full">
                        <div class="row items-push float-end ">
                            <div class="col-12 col-md-3 pb-3">
                                <a href="{{ route('admin.submission.salary-submission.create') }}"
                                    class="btn btn-sm btn-neo btn-block pull-right">Tambah Pengajuan Gaji</a>
                            </div>
                        </div>
                        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
                        <div class="row g-3 col-12 ">
                            <div class="table-responsive py-1">
                                <table
                                    class="table table-bordered table-striped table-vcenter js-dataTable-full no-footer dtr-inline collapsed">
                                    <thead>
                                        <tr>
                                            <th class="d-none d-md-table-cell fs-sm text-center" style="width: 1%;">#</th>
                                            <th style="width: 10%;">Nama Tentor</th>
                                            <th style="width: 10%;">Nama Siswa</th>
                                            <th style="width: 10%;">Mata Pelajaran</th>
                                            <th class="d-sm-table-cell fs-sm" style="width: 5%;">Bulan</th>
                                            <th class="d-none d-sm-table-cell fs-sm" style="width: 5%;">Status</th>
                                            <th class="d-none d-sm-table-cell fs-sm" style="width: 10%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $studentProgress)
                                            <tr>
                                                <td class="d-none d-md-table-cell fs-sm text-center">
                                                    {{ $loop->iteration }}</td>
                                                <td class="fs-sm">
                                                    <a
                                                        href="{{ route('admin.submission.salary-submission.detail', ['id' => $studentProgress->id]) }}">{{ $studentProgress->tntrFirstName . ' ' . $studentProgress->tntrLastName }}</a>
                                                </td>
                                                <td class="fs-sm">
                                                    <a
                                                        href="{{ route('admin.submission.salary-submission.detail', ['id' => $studentProgress->id]) }}">{{ $studentProgress->stdFirstName . ' ' . $studentProgress->stdLastName }}</a>
                                                </td>
                                                <td class="fs-sm">
                                                    {{ $studentProgress->subject }}
                                                </td>
                                                <td class="fs-sm">
                                                    {{ date('F Y', strtotime($studentProgress->month)) }}
                                                </td>
                                                <td class="d-none d-sm-table-cell fs-sm text-center">
                                                    @if ($studentProgress->status == 0)
                                                        <span
                                                            class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-warning-light text-warning">Diajukan</span>
                                                    @elseif ($studentProgress->status == -10)
                                                        <span
                                                            class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-danger-light text-danger">Ditolak</span>
                                                    @else
                                                        <span
                                                            class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-success-light text-success">Diterima</span>
                                                    @endif
                                                </td>
                                                <td class="d-none d-sm-table-cell fs-sm text-center">

                                                    <a href="{{ route('admin.submission.salary-submission.detail', ['id' => $studentProgress->id]) }}"
                                                        class="btn btn-sm btn-neo">Detail</a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 order-xl-0 tab-pane fade " id="nav-shortlist" role="tabpanel"
                aria-labelledby="nav-shortlist-tab">
                <!-- Dynamic Table Full -->
                <div class="block">
                    <div class="block-content block-content-full">
                        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
                        <div class="row g-3 col-12 ">
                            <div class="table-responsive py-1">
                                <table
                                    class="table table-bordered table-striped table-vcenter js-dataTable-full no-footer dtr-inline collapsed">
                                    <thead>
                                        <tr>
                                            <th class="d-none d-md-table-cell fs-sm text-center" style="width: 1%;">#</th>
                                            <th style="width: 10%;">Nama Tentor</th>
                                            <th style="width: 10%;">Nama Siswa</th>
                                            <th style="width: 10%;">Mata Pelajaran</th>
                                            <th class="d-sm-table-cell fs-sm" style="width: 5%;">Bulan</th>
                                            <th class="d-none d-sm-table-cell fs-sm" style="width: 5%;">Status</th>
                                            <th class="d-none d-sm-table-cell fs-sm" style="width: 10%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($history as $studentProgress)
                                            <tr>
                                                <td class="d-none d-md-table-cell fs-sm text-center">
                                                    {{ $loop->iteration }}</td>
                                                <td class="fs-sm">
                                                    <a
                                                        href="{{ route('admin.submission.salary-submission.detail', ['id' => $studentProgress->id]) }}">{{ $studentProgress->tntrFirstName . ' ' . $studentProgress->tntrLastName }}</a>
                                                </td>
                                                <td class="fs-sm">
                                                    <a
                                                        href="{{ route('admin.submission.salary-submission.detail', ['id' => $studentProgress->id]) }}">{{ $studentProgress->stdFirstName . ' ' . $studentProgress->stdLastName }}</a>
                                                </td>
                                                <td class="fs-sm">
                                                    {{ $studentProgress->subject }}
                                                </td>
                                                <td class="fs-sm">
                                                    {{ date('F Y', strtotime($studentProgress->month)) }}
                                                </td>
                                                <td class="d-none d-sm-table-cell fs-sm text-center">
                                                    @if ($studentProgress->status == 0)
                                                        <span
                                                            class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-warning-light text-warning">Diajukan</span>
                                                    @elseif ($studentProgress->status == -10)
                                                        <span
                                                            class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-danger-light text-danger">Ditplak</span>
                                                    @else
                                                        <span
                                                            class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-success-light text-success">Diterima</span>
                                                    @endif
                                                </td>
                                                <td class="d-none d-sm-table-cell fs-sm text-center">

                                                    <a href="{{ route('admin.submission.salary-submission.detail', ['id' => $studentProgress->id]) }}"
                                                        class="btn btn-sm btn-neo">Detail</a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- END Dynamic Table Full -->
    </div>
    <!-- END Page Content -->
@endsection
