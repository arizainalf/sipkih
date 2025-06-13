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
            <h1>Edit Periksa Kehamilan</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-primary">Form Edit Pemeriksaan</h4>
                </div>

                <div class="card-body">
                    <form id="editWizardForm">
                        @csrf
                        @method('PUT')

                        <div id="formSteps"></div>

                        <div class="d-flex justify-content-between mt-3">
                            <button type="button" class="btn btn-secondary" id="prevBtn"
                                style="display:none;">Previous</button>
                            <div>
                                <button type="button" class="btn btn-primary" id="nextBtn"
                                    style="display:none;">Next</button>
                                <button type="submit" class="btn btn-success" id="submitBtn" style="display:none;">Simpan
                                    Perubahan</button>
                            </div>
                        </div>

                        <div class="progress mt-3" style="display:none;">
                            <div class="progress-bar" role="progressbar" id="progressBar" style="width: 0%"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        let currentStep = 1;
        let totalSteps = 0;
        const fieldsPerStep = 10;

        const selectedItems = @json($selectedItems ?? []); // array id form yang sudah dipilih → dari controller
        console.log(selectedItems);

        $(document).ready(function() {
            $.get('{{ route('admin.periksa.form.edit' ) }}', function(res) {
                console.log(res)
                const items = res.data;
                const itemCount = items.length;

                if (itemCount === 0) {
                    $('#formSteps').html('<p>Tidak ada form.</p>');
                    return;
                }

                if (itemCount < fieldsPerStep) {
                    let html = '';
                    items.forEach(item => {
                        html += generateCheckbox(item);
                    });
                    $('#formSteps').html(html);
                    $('#submitBtn').show();
                } else {
                    totalSteps = Math.ceil(itemCount / fieldsPerStep);
                    let steps = '';

                    for (let step = 0; step < totalSteps; step++) {
                        const start = step * fieldsPerStep;
                        const chunk = items.slice(start, start + fieldsPerStep);

                        steps += `<div class="form-step" id="step-${step + 1}" style="display:none;">`;
                        chunk.forEach(item => {
                            steps += generateCheckbox(item);
                        });
                        steps += `</div>`;
                    }

                    $('#formSteps').html(steps);
                    $('#prevBtn').show();
                    $('#nextBtn').show();
                    $('.progress').show();
                    showStep(currentStep);
                }
            });

            function generateCheckbox(item) {
                const isChecked = selectedItems.includes(item.id) ? 'checked' : '';
                return `
                <div class="form-check mb-3 p-3 border rounded shadow-sm">
                    <input class="form-check-input custom-checkbox" disabled type="checkbox" name="items[]" value="${item.id}" id="item-${item.id}" ${isChecked} style="transform: scale(1.5); margin-right: 10px;">
                    <label class="form-check-label fw-bold fs-5" for="item-${item.id}">${item.nama}</label>
                </div>
            `;
            }

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

                if (step === totalSteps) {
                    $('#nextBtn').hide();
                    $('#submitBtn').show();
                } else {
                    $('#nextBtn').show();
                    $('#submitBtn').hide();
                }
            }
        });
    </script>
@endpush
