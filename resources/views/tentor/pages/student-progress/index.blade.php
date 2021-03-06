<title>Laporan Perkembangan Siswa</title>
@extends('tentor.layouts.app')

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
    <!-- Hero -->

    <!-- END Hero -->
    <div class="content">    
        <div class="row block bg-body-light shadow-sm">
        <div class="content content-full bg-header-tentor" style="
        background-image:url({{ asset('images/Asset/header-tentors.png') }});">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2">
                    Daftar Laporan Perkembangan Siswa <small
                        class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted"></small>
                </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">Laporan Perkembangan Siswa</li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a class="link-fx" href="">Dashboard</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
        <div class="row block shadow-sm">
            <div class="block-content block-content-full">
                <div class="row items-push float-end ">
                    <div class="col-12 col-md-3 py-2">
                        <a href="{{ route('tentor.progress-report.addnew') }}"
                            class="btn btn-sm btn-neo btn-block pull-right">Tambah Laporan</a>
                    </div>
                </div>
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
                    <div class="table-responsive py-1">
                        <table
                            class="table table-bordered table-striped table-vcenter js-dataTable-full no-footer dtr-inline collapsed">
                            <thead>
                                <tr>
                                    <th class="d-none d-md-table-cell fs-sm text-center" style="width: 1%;">#</th>
                                    <th style="width: 10%;">Nama</th>
                                    <th style="width: 10%;">Mata Pelajaran</th>
                                    <th class="d-sm-table-cell fs-sm" style="width: 5%;">Bulan</th>
                                    <th class="d-none d-sm-table-cell fs-sm" style="width: 10%;">Status</th>
                                    <th class="d-none d-sm-table-cell fs-sm" style="width: 5%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stdProgress as $studentProgress)
                                    <tr>
                                        <td class="d-none d-md-table-cell fs-sm text-center">{{ $loop->iteration }}</td>
                                        <td class="fs-sm">
                                            <a
                                                href="{{ route('tentor.progress-report.detail', ['id' => Crypt::encrypt($studentProgress->id)]) }}">{{ $studentProgress->stdFirstName . ' ' . $studentProgress->stdLastName }}</a>
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
                                                    class="span1 btn-block fs-xs fw-semibold d-inline-block py-1 px-3 bg-success-light text-success">Diajukan</span>
                                            @elseif ($studentProgress->status == -10)
                                                <span
                                                    class="span1 btn-block fs-xs fw-semibold d-inline-block py-1 px-3 bg-danger-light text-danger">Ditolak</span>
                                            @else
                                                <span
                                                    class="span1 btn-block fs-xs fw-semibold d-inline-block py-1 px-3 bg-success-light text-success">Diterima</span>
                                            @endif
                                        </td>
                                        <td class="d-none d-sm-table-cell fs-sm text-center">
                                            <a href="{{ route('tentor.progress-report.detail', ['id' => Crypt::encrypt($studentProgress->id)]) }}"
                                                class="btn btn-sm btn-neo">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
        <!-- END Dynamic Table Full -->
    </div>
    <!-- Page Content -->
    <!-- END Page Content -->
@endsection
