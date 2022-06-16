@extends('admin.layouts.app')
<title>Daftar Siswa</title>
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
    <div class="content">
        <div class="block bg-body-light shadow-sm">
            <div class="content content-full bg-header-tentor" style="
                    background-image:url({{ asset('images/Asset/header-tentors.png') }});">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <div class="flex-grow-1">
                        <h1 class="h3 fw-bold mb-2">
                            Daftar Siswa
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
                                <a class="link-fx" href="{{ route('admin.student.all.all') }}">Daftar Siswa</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 order-xl-0">
                <!-- Dynamic Table Full -->
                <div class="block">
                    <div class="block-content block-content-full">
                        <div class="row items-push float-sm-left ">
                            <button type="button" class="btn btn-sm btn-alt-secondary ml-1" title="Add New Student">
                                <a href="{{ route('admin.student.all.addnewstudent') }}"
                                    class="btn btn-sm btn-neo pull-right">Tambah Daftar Siswa</a>
                            </button>
                        </div>
                        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
                        <div class="table-responsive py-1">
                            <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 1%;">#</th>
                                        <th style="width: 15%;">Nama Lengkap</th>
                                        <th class="d-none d-sm-table-cell" style="width: 20%;">Alamat</th>
                                        <th style="width: 10%;">Cabang</th>
                                        <th style="width: 10%;">Status</th>
                                        <th style="width: 5%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="font-w600 fw-semibold">
                                                <a
                                                    href="{{ route('admin.student.all.view', ['id' => $student->id]) }}">{{ $student->first_name . ' ' . $student->last_name }}</a>
                                            </td>
                                            <td class="fs-sm">
                                                {{ $student->address }}
                                            </td>
                                            <td class="fs-sm">
                                                {{ $student->branch_name }}
                                            </td>
                                            <td class="fs-sm text-center">
                                                @if ($student->status == -100)
                                                    <span
                                                        class="d-inline-block py-1 px-3 rounded-pill bg-danger text-white fs-sm">Blacklist</span>
                                                @elseif ($student->status == 0)
                                                    <span
                                                        class="d-inline-block py-1 px-3 rounded-pill bg-info text-white fs-sm">Belum Bayar</span>
                                                @elseif ($student->status == 100)
                                                    <span
                                                        class="d-inline-block py-1 px-3 rounded-pill bg-success text-white fs-sm">Sudah Bayar</span>
                                                @endif
                                            </td>
                                            <td class="d-sm-table-cell text-center">
                                                <div class="btn-group center">
                                                    <button type="button" class="btn btn-sm btn-alt-secondary"
                                                        data-bs-toggle="tooltip" title="Detail">
                                                        <a href="{{ route('admin.student.all.view', ['id' => $student->id]) }}"
                                                            class="btn btn-sm btn-neo pull-right">Detail</a>
                                                    </button>
                                                </div>
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
        <!-- END Dynamic Table Full -->
    </div>
    <!-- END Page Content -->
@endsection
