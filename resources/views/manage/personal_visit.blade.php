@extends('layouts.table')

@section('content_table')
    <link rel="stylesheet" href="{{ asset('viewerjs/css/bootstrap.min.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('viewerjs/css/viewer.css') }}">
    <link rel="stylesheet" href="{{ asset('viewerjs/css/main.css') }}">

<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        text-align: center;
    }

    /* The Modal (background) */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin-top: 25px;
            margin-left: 300px;
        padding: 20px;
        border: 1px solid #888;
        width: 60%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 5px;
        position: relative;
    }

    /* Modal Header */
    .modal-header {
        padding: 10px;
        background-color: #0c0c0c;
        color: #fff;
        text-align: center;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }

    /* Modal Body */
    .modal-body {
        padding: 10px 0;
    }

    /* Modal Footer */
    .modal-footer {
        padding: 1px;
        background-color: #1c2122;
        color: #fff;
        text-align: center;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    /* The Close Button */
    .close {
        color: #fff;
        font-size: 20px;
        font-weight: bold;
       position: absolute;
        top: 5px;
        right: 10px;
        cursor: pointer;


    .close:hover {
        color: #ccc;
    }
</style>


    <div style="text-align: right">

        جميع المراجعات الخاصة بالمريض :
        <h2 style=" text-align: center;">

            <button style="width:150px;margin-top: 9px; height: 50px; margin-right: 290px;" type="button" class="myBtn btn btn-info  btn-rounded waves-effect waves-light"
                            data-toggle="modal" data-modal-target="{{ $personal_visit->id }}">
                            اضافة مراجعة <i class="fe-file-text"></i></button>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


            <strong style="background-color: rgb(118, 209, 148); text-align: center;">{{ $personal_visit->name }}</strong>


        </h2>

    </div>
    <p class="text-muted font-13 mb-4">
        @if (Session::has('success'))
            <div class="alert alert-success" style="text-align: center;">
                {{ Session::get('success') }}</div>
        @endif
    </p>




    <table class="table table-bordered data-table" style="text-align: center;" dir="rtl">
        <thead>
            <tr>
                {{-- <th>#</th> --}}
                <th> مراجعات المريض</th>
                <th> تاريخ المراجعات</th>
                <th width="150px">عرض المراجعة </th>

            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($review_visits as $review_visit)
                <tr>
                    {{-- <td>{{ $i }}</td> --}}
                    <td>
                        @php
                            if ($i == 1) {
                                $visit = "اخر مراجعة " ;
                            } else {
                                $visit = $i;
                            }

                        @endphp
                        {{ $visit }}
                    </td>
                    <td>{{ $review_visit->check_date }}</td>

                    <td>
                        <style>
                            .modal-body {
                                text-align: center;
                            }

                            #image-gallery-{{ $review_visit->id }} img {
                                width: 150px;
                                height: 50px;
                                border: 3px solid #000000;
                                transition: border-color 0.3s ease-in-out;
                                /* Transition for hover effect */
                            }

                            #image-gallery-{{ $review_visit->id }} img:hover {
                                /* border-color: #007bff; Border color on hover */
                            }
                        </style>

                        <div class="modal-body">
                            <div id="image-gallery-{{ $review_visit->id }}" class="viewer">
                                <img width="150px" height="50px"
                                    data-original="{{ asset('PatientFiles/' . $review_visit->path) }}"
                                    src="{{ asset('PatientFiles/' . $review_visit->path) }}"
                                    alt="صورة {{ $review_visit->id }}" title="اضغط لعرض التشخيص   ">
                            </div>
                        </div>


                        <!-- Modal -->
                        <div class="modal fade" id="imageModal{{ $review_visit->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="imageModalLabel{{ $review_visit->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="modal-body">
                                            <div id="image-gallery-{{ $review_visit->id }}" class="viewer">
                                                <img width="100px" height="50px"
                                                    src="{{ asset('PatientFiles/' . $review_visit->path) }}"
                                                    alt="صورة {{ $review_visit->id }}">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var gallery = document.getElementById('image-gallery-{{ $review_visit->id }}');
                                var viewer = new Viewer(gallery);

                                // Open the modal programmatically
                                $('#imageModal{{ $review_visit->id }}').modal('show');
                            });
                        </script>

                    </td>

                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        </tbody>
    </table>




 {{-- $personal_visit->name --}}
    <!-- The Modal -->
    <div class="modal" id="myModal{{ $personal_visit->id }}"  >
        <!-- Modal content -->
        <div class="modal-content" >
            <div class="modal-header" dir="rtl">
                <span class="close" data-modal-id="{{ $personal_visit->id }}">&times;</span>
                <h2 class="modal-title">اضافة مراجعة جديدة للمريض  : {{ $personal_visit->name }} </h2>
            </div>
            <div class="modal-body">
                {!! Form::open([
                    'action' => ['AdminController@update', $personal_visit->id],
                    'method' => 'POST',
                    'autocomplete' => 'off',
                    'files' => true,
                    'class' => 'needs-validation',
                ]) !!}
                {{ Form::hidden('add_patient_file', 'add_patient_file') }}
                {{ form::hidden('_method', 'PUT') }}

                <input hidden name="patient__id__" value="{{ $personal_visit->id }}">

                <div class="mb-3">
                    <label for="patient_name" class="form-label">{{ __('اسم الريض ') }}</label>
                    <input style="text-align: center;" disabled id="patient_name" type="text" class="form-control" name="patient_name"
                           placeholder="{{ __('Patient Name') }}" value="{{ $personal_visit->name }}" required>
                    @error('patient_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="patient_phone" class="form-label">{{ __('رقم التلفون ') }}</label>
                    <input style="text-align: center;" id="patient_phone" type="text" class="form-control" name="patient_phone"
                           placeholder="{{ __('رقم التلفون') }}" value="{{ $personal_visit->id }}" required>
                    @error('patient_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


<div class="mb-3">
    <label for="note_patient" class="form-label">{{ __('ملاحظات') }}</label>
    <textarea style="text-align: center;" id="note_patient" class="form-control" name="note_patient"
              placeholder="{{ __('ملاحظات') }}" required>{{ $personal_visit->id }}</textarea>
    @error('note_patient')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
                <div class="mb-3" dir="rtl">
                    <label style="text-align: right;" for="patient_file" class="form-label">{{ __('رفع التشخيص ') }}</label>
                    <input style="text-align: center;" id="patient_file" accept="image/jpeg, image/png, image/jpg, image/gif" type="file"
                           class="form-control" name="patient_file" required>
                    @error('patient_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 text-end" style="text-align: center;">
                    <button type="submit" class="btn btn-primary">{{ __('اضافة مراجعة جديدة  ') }}</button>
                </div>

                {!! Form::close() !!}
            </div>
            <div class="modal-footer" >
                <button  style="width: 850px;height: 50px;"  class="btn btn-secondary close-btn " data-modal-id="{{ $personal_visit->id }}">اغلاق الصفحة</button>
            </div>
        </div>
    </div>



<script>
    // Add click event listeners to buttons
    var buttons = document.querySelectorAll('.myBtn');
    var closeButtons = document.querySelectorAll('.close, .close-btn');

    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            var modalId = button.getAttribute('data-modal-target');
            openModal(modalId);
        });
    });

    closeButtons.forEach(function(closeButton) {
        closeButton.addEventListener('click', function() {
            var modalId = closeButton.getAttribute('data-modal-id');
            closeModal(modalId);
        });
    });

    // Open modal function
    function openModal(modalId) {
        var modal = document.getElementById("myModal" + modalId);
        modal.style.display = "block";
    }

    // Close modal function
    function closeModal(modalId) {
        var modal = document.getElementById("myModal" + modalId);
        modal.style.display = "none";
    }
</script>


    <!-- Scripts -->
    <script src="{{ asset('viewerjs/js/jquery.slim.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('viewerjs/js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('viewerjs/js/google-analytics.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('viewerjs/js/viewer.js') }}"></script>
    <script src="{{ asset('viewerjs/js/main.js') }}"></script>
@endsection
