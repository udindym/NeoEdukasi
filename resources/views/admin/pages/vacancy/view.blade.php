<title>Vacancy Detail</title>
@extends('admin.layouts.app')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"
    rel="stylesheet" />

@section('content')
    <div class="content block-rounded">
        <div class="bg-image">

            <img class="rounded" src="{{ asset('images/Asset/header-vacancy-detail.png') }}" alt="Header Avatar"
                style="max-width:100%;">
        </div>
        <div class="bg-white border-bottom shadow-sm border-left-neo2">
            <div class="content content-boxed">
                <div class="row items-push">
                    <div class="col-3 col-md-1">
                        <img class="img-avatar" src="{{ asset('asset/images/avatars/avatar.png') }}"
                            alt="Header Avatar">
                    </div>
                    <div class="col-9 col-md-9">
                        <div class="font-size-h3 tittle-neo-header">
                            {{ $vacancy->first_name . ' ' . $vacancy->last_name }}
                        </div>
                        <div class="font-size-sm font-w600 text-muted text-uppercase">{{ $vacancy->branch_name }}</div>
                    </div>
                    <div class="col-12 col-md-2">
                        <div class="row items-push float-sm-right ">
                            <button type="button" class="btn btn-md btn-alt-secondary" title="Add New Student">
                                <a href="#div-input" id="editButton" class="btn btn-sm btn-neo pull-right">Edit
                                    Vacancy</a>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row items-push">
                    <div class="col-6 col-md-12">
                        <div class="font-size-sm font-w600 text-muted">Posted on
                            {{ date('d-M-y', strtotime($vacancy->vacancyCreateDate)) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="block block-rounded shadow-sm">
            <div class="block-content block-content-full border-right-neo">
                <div class="row ">
                    <div class="col-xl-12 order-xl-0">
                        <div class="col-12-line1">
                            <label class="form-label tittle">Student Detail</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 order-xl-0">
                        <div class="row g-3 col-12 py-2">
                            <div class="col-12">
                                <label class="form-label tittle-neo">Full Name</label>
                                <input type="text" name="first_name" class="form-control" placeholder="First Name"
                                    value="{{ $vacancy->first_name . ' ' . $vacancy->last_name }}" disabled>
                            </div>
                            <div class="col-12">
                                <label class="form-label tittle-neo">Address</label>
                                <input type="text" name="first_name" class="form-control"
                                    value="{{ $vacancy->address }}" disabled>
                            </div>
                            <div class="col-6">
                                <label class="form-label tittle-neo">Class</label>
                                <input type="text" name="first_name" class="form-control" value="{{ $vacancy->class }}"
                                    disabled>
                            </div>
                            <div class="col-6">
                                <label class="form-label tittle-neo">Curriculum</label>
                                <input type="text" name="first_name" class="form-control"
                                    value="{{ $vacancy->curriculum }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block block-rounded shadow-sm" id="div-input">
            <div class="block-content block-content-full border-right-neo">
                <form method="POST" id="editVacancy" action="{{ route('admin.vacancy.job-vacancy.update') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="block">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row ">
                            <div class="col-xl-12 order-xl-0">
                                <div class="col-12-line1 py-2">
                                    <div class="items-push float-lg-right">
                                        <select class="form-select form-control-xs selectpicker" id="status" title="Status"
                                            name="status">
                                            {{-- <option value="" readonly selected>Status</option> --}}
                                            <option value="-10" {{ $vacancy->vacancyStatus == -10 ? 'selected' : '' }}
                                                data-content='<span class="btn-success btn-sm btn-block text-center">Open</span>'>
                                            </option>
                                            <option value="10" {{ $vacancy->vacancyStatus == 10 ? 'selected' : '' }}
                                                data-content='<span class="btn-danger btn-sm btn-block text-center">Closed</span>'>
                                            </option>
                                        </select>
                                    </div>
                                    <label class="form-label tittle">Job Description</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 col-12 py-2">
                            <div class="col-12">
                                <label class="form-label tittle-neo">Subject</label>
                                <input type="text" id="subject" name="subject" class="form-control" placeholder="Subject"
                                    value="{{ $vacancy->subject }}" disabled>
                            </div>
                            <input name="id" type="hidden" value="{{ $vacancy->vacancyId }}">

                            <div class="col-12" id="dynamicAddRemove">
                                <label class="form-label tittle-neo">Criteria</label>
                                @foreach (explode('~', $vacancy->criteria) as $info)
                                    {!! $loop->first ? '<div class="input-group mb-3"><input type="text" name="criteria[' . ($loop->iteration - 1) . ']" placeholder="Criteria" class="form-control" value="' . $info . '" disabled /> <div class="input-group-append"><button type="button" name="add" id="dynamic-ar" class="btn btn-primary" type="button" disabled>+</button></div></div>' : '<div id="removeit"class="input-group mb-3"><input type="text" name="criteria[' . ($loop->iteration - 1) . ']" placeholder="Criteria" value="' . $info . '"class="form-control" disabled /> <div class="input-group-append"><button type="button" class="btn btn-danger remove-input-field" disabled>x</button></div></div>' !!}
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <div class="invisible" id="saveChanges" data-toggle="appear" style="display: none">
                        <div class="block-content block-content-full">
                            <div class="mb-4 col-12 text-center">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-12 col-sm-2 mb-3">
                                        <button type="button" id="removeButton" class="btn btn-sm btn-danger btn-block">
                                            Delete Record
                                        </button>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <button type="submit" name="submit" class="btn btn-sm btn-neo btn-block">
                                            Save Changes
                                        </button>
                                    </div>
                                    <div class="col-12 col-sm-1">
                                        <a href="#\" id="cancelButton" class="btn btn-sm btn-secondary">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var i = {{ $criteria }};
        $("#dynamic-ar").click(function() {
            ++i;
            $("#dynamicAddRemove").append(
                '<div id="removeit"class="input-group mb-3"><input type="text" name="criteria[' + i +
                ']" placeholder="Criteria" class="form-control" /> <div class="input-group-append"><button type="button" class="btn btn-danger remove-input-field">x</button></div></div>'
            );
        });
        $(document).on('click', '.remove-input-field', function() {
            $(this).parents('#removeit').remove();
        });


        $(function() {
            $('#subject').on('input', function() {
                var nameValisession = $(this).val();
                document.getElementById('preview-subject').value = nameValisession;
            });
            $("#ijazah-status").on("change", function() {
                if ($(this).val() === "1") {
                    document.getElementById('ijazah-status-review').value = "Accept";
                } else {
                    document.getElementById('ijazah-status-review').value = "Decline";
                }
            });
        });
    </script>

    <script>
        var elem = document.getElementById('saveChanges');
        $("a#editButton").click(function(event) {
            if ($("#editVacancy :input").is(':disabled')) {
                $("#editVacancy :input").prop("disabled", false);
                elem.style.display = 'block';
            } else {
                $("#editVacancy :input").prop("disabled", true);
                elem.style.display = 'none';
            }
        });

        $("a#cancelButton").click(function(event) {
            $("#editVacancy :input").prop("disabled", true);
            elem.style.display = 'none';
        });
    </script>

    <script>
        $("#removeButton").click(function(event) {
            event.preventDefault();
            let id = "{{ $vacancy->vacancyId }}";
            Swal.fire({
                title: 'Are You Sure?',
                text: "You will not be able to recover this record!",
                icon: 'info',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete it',
                confirmButtonColor: "#d26a5c"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('admin.vacancy.job-vacancy.delete') }}",
                        type: "POST",
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            Swal.fire({
                                title: 'Delete Status :',
                                text: data,
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            setTimeout(function() {
                                window.location.replace(
                                    "{{ route('admin.vacancy.job-vacancy.index') }}"
                                );
                            }, 3000);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $('#status').on('change', function() {
            var selected = $(this).val();
            if (selected == -10) {
                var selectedName = "Open";
                var buttonColor = "#6fa306";
            } else {
                var selectedName = "Close";
                var buttonColor = "#dc3545";
            }
            Swal.fire({
                title: 'Vacancy Status',
                text: "Are you Sure update vacancy status to " + selectedName + "?",
                icon: 'info',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: selectedName,
                confirmButtonColor: buttonColor
            }).then((result) => {
                if (result.value) {
                    //loading
                    Swal.fire({
                        title: "",
                        text: "Please wait...",
                        imageUrl: "https://mir-s3-cdn-cf.behance.net/project_modules/disp/583b6136197347.571361641da25.gif",
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                    $.ajax({
                        url: "{{ route('admin.vacancy.job-vacancy.update_status') }}",
                        method: "POST",
                        data: {
                            id: "{{ $vacancy->vacancyId }}",
                            status: selected,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            Swal.fire({
                                title: 'Tentor Status Update',
                                text: data,
                                icon: 'success',
                                showConfirmButton: false,
                            });
                            setTimeout(function() {
                                document.location.reload()
                            }, 500);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });
        });
    </script>
    <!-- END Page Content -->
@endsection
