@extends('layouts.app')
@section('title', 'Periksa Kehamilan')
@push('styles')
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet"
        href="{{ asset('') }}assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">

    <style>
        .form-check-label {
            font-size: 1.2rem;
        }

        .form-check-input {
            transform: scale(1.5);
            margin-right: 10px;
        }

        #wizardForm .btn {
            padding: 0.5rem 1.5rem;
            font-size: 1rem;
            border-radius: 0.5rem;
        }
    </style>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>@yield('title')</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route(activeGuard() . '.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">@yield('title')</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title font-weight-bolder">
                                <h4 class="text-primary">@yield('title')
                                </h4>
                                <p>Centang dengan benar jika anda mengalami gejala tersebut.</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <form id="wizardForm">
                                    <input type="hidden" name="kehamilan_id" value="{{ $kehamilan->id }}">

                                    <div id="formSteps"></div>

                                    <div class="d-flex justify-content-between mt-3">
                                        <button type="button" style="display:none;" class="btn btn-secondary"
                                            id="prevBtn">Previous</button>
                                        <div>
                                            <button type="button" style="display:none;" class="btn btn-primary"
                                                id="nextBtn">Next</button>
                                            <button type="submit" class="btn btn-success" id="submitBtn"
                                                style="display:none;">Simpan</button>
                                        </div>
                                    </div>

                                    <div class="progress mt-3" style="display:none;">
                                        <div class="progress-bar" role="progressbar" id="progressBar" style="width: 0%">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('') }}assets/modules/datatables/datatables.min.js"></script>
    <script src="{{ asset('') }}assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('') }}assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="{{ asset('') }}assets/modules/jquery-ui/jquery-ui.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('') }}assets/js/page/modules-datatables.js"></script>

    <script>
        let currentStep = 1;
        let totalSteps = 0;
        const fieldsPerStep = 1;

        $(document).ready(function() {
            $.get('{{ route('ibu.periksa.form') }}', function(res) {
                const items = res.data;
                const itemCount = items.length;

                if (itemCount === 0) {
                    $('#formSteps').html('<p>Tidak ada form.</p>');
                    return;
                }

                // Kalau data kurang dari 5 → tampilkan langsung semua + tombol Simpan
                if (itemCount < fieldsPerStep) {
                    let html = '';
                    items.forEach(item => {
                        html += `
       <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="items[]" value="${item.id}" id="item-${item.id}">
                            <label class="form-check-label" for="item-${item.id}">${item.nama}</label>
                        </div>`;
                    });
                    $('#formSteps').html(html);
                    $('#submitBtn').show();
                    $('#prevBtn').hide();
                    $('#nextBtn').hide();
                    $('.progress').hide();
                } else {
                    // Kalau data >= 5 → tampilkan wizard
                    totalSteps = Math.ceil(itemCount / fieldsPerStep);
                    let steps = '';

                    for (let step = 0; step < totalSteps; step++) {
                        const start = step * fieldsPerStep;
                        const chunk = items.slice(start, start + fieldsPerStep);

                        steps += `<div class="form-step" id="step-${step + 1}" style="display:none;">`;
                        chunk.forEach(item => {
                            steps += `
                             <div class="form-check mb-3 p-3 border rounded shadow-sm">
                    <input class="form-check-input custom-checkbox" type="checkbox" name="items[]" value="${item.id}" id="item-${item.id}" style="transform: scale(1.5); margin-right: 10px;">
                    <label class="form-check-label fw-bold fs-5" for="item-${item.id}">${item.nama}</label>
                </div>
                        `;
                        });
                        steps += `</div>`;
                    }

                    $('#formSteps').html(steps);
                    $('#navButtons').show();
                    $('#prevBtn').show();
                    $('#nextBtn').show();
                    $('.progress').show();
                    showStep(currentStep);
                }
            });

            $('#nextBtn').click(function() {
                if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);
                }
            });

            $('#prevBtn').click(function() {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            function showStep(step) {
                $('.form-step').hide();
                $(`#step-${step}`).show();
                $('#progressBar').css('width', `${(step / totalSteps) * 100}%`);

                if (step === 1) {
                    $('#prevBtn').hide();
                } else {
                    $('#prevBtn').show();
                }

                if (step === totalSteps) {
                    $('#nextBtn').hide();
                    $('#submitBtn').show();
                } else {
                    $('#nextBtn').show();
                    $('#submitBtn').hide();
                }
            }

            $(document).on('submit', '#wizardForm', function(e) {
                e.preventDefault();

                const items = [];
                $('input[name="items[]"]:checked').each(function() {
                    items.push($(this).val());
                });

                const data = {
                    kehamilan_id: $('input[name="kehamilan_id"]').val(),
                    items: items,
                };

                const url = "{{ route('ibu.periksa.store') }}";
                const successCallback = function(response) {
                    handleSuccess(response, null, "/ibu/periksa")
                }

                const errorCallback = function(error) {
                    handleValidationErrors(error, '#wizardForm')
                }

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            })

        });
    </script>
@endpush
