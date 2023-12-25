@extends('layouts.table')

@section('content_table')
    {{-- <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style> --}}


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
            /* margin: 10% auto; */
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


    <div class="text-muted font-13 mb-4">
        @if (Session::has('danger'))
            <div class="alert alert-danger" style="text-align: center;">
                {{ Session::get('danger') }}</div>
        @endif
        @if (Session::has('success'))
            <div class="alert alert-success" style="text-align: center;">
                {{ Session::get('success') }}</div>
        @endif
    </div>


    <form action="search" method="get">
        <div class="input-group mb-3">
            <input type="text" class="form-control custom-input text-right" id="search_name" required name="search_name"
                value="{{ $searchText }}" placeholder="ابحث عن اسم المريض">
            <button  style="width: 150px;" class="btn btn-primary">ابحث</button>
        </div>


    </form>


    <table class="table table-bordered data-table" style="text-align: center;" dir="rtl">
        <thead>
            <tr>
                <th>#</th>
                <th>اسم المريض</th>
                <th>عمر المريض</th>
                <th> التلفون</th>
                {{-- <th> عدد المراجعات</th> --}}

                <th width="150px">عرض </th>
                <th width="150px">اضافة مراجعة </th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($all_patients as $patient)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $patient->name }}</td>
                    <td>
                        @php

                            $birthdate = \Carbon\Carbon::parse($patient->birthday);
                            $today = \Carbon\Carbon::now();
                            $age = $today->diffInYears($birthdate);
                        @endphp

                        {{ $age }}</td>
                    <td>{{ $patient->patient_phone }}</td>
                    <td>
                        <a href="manage_patient_visit/{{ $patient->id }}">
                            <button id="modal-btn" class="btn btn-primary btn-rounded waves-effect waves-light"
                                style="width: 125px;">عرض تفاصيل</button></a>
                    </td>
                    <td>
                        <button type="button" class="myBtn btn btn-info  btn-rounded waves-effect waves-light"
                            data-toggle="modal" data-modal-target="{{ $patient->id }}">

                            اضافة مراجعة <i class="fe-file-text"></i></button>


                        {{-- <button class="myBtn" data-modal-target="{{ $patient->id }}">Open Modal {{ $patient->id }}</button> --}}


                    </td>
                </tr>

                @php
                    $i++;
                @endphp
            @endforeach
        </tbody>
    </table>
    {{ $all_patients->links() }}

    </div>


    @foreach ($all_patients as $patient)
        <!-- The Modal -->
        <div class="modal" id="myModal{{ $patient->id }}">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header" dir="rtl">
                    <span class="close" data-modal-id="{{ $patient->id }}">&times;</span>
                    <h2 class="modal-title">اضافة مراجعة جديدة للمريض : {{ $patient->name }} </h2>
                </div>
                <div class="modal-body">
                    {!! Form::open([
                        'action' => ['AdminController@update', $patient->id],
                        'method' => 'POST',
                        'autocomplete' => 'off',
                        'files' => true,
                        'class' => 'needs-validation',
                    ]) !!}
                    {{ Form::hidden('add_patient_file', 'add_patient_file') }}
                    {{ form::hidden('_method', 'PUT') }}

                    <input hidden name="patient__id__" value="{{ $patient->id }}">

                    <div class="mb-3">
                        <label for="patient_name" class="form-label">{{ __('اسم الريض ') }}</label>
                        <input style="text-align: center;" disabled id="patient_name" type="text" class="form-control"
                            name="patient_name" placeholder="{{ __('Patient Name') }}" value="{{ $patient->name }}"
                            required>
                        @error('patient_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="patient_phone" class="form-label">{{ __('رقم التلفون ') }}</label>
                        <input style="text-align: center;" id="patient_phone" type="text" class="form-control"
                            name="patient_phone" placeholder="{{ __('Phone Number') }}" value="{{ $patient->id }}"
                            required>
                        @error('patient_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="note_patient" class="form-label">{{ __('ملاحظات') }}</label>
                        <textarea style="text-align: right;" id="note_patient" class="form-control" name="note_patient"
                            placeholder="{{ __('ملاحظات') }}" required>{{ $patient->id }}</textarea>
                        @error('note_patient')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" dir="rtl">
                        <label style="text-align: right;" for="patient_file"
                            class="form-label">{{ __('رفع التشخيص ') }}</label>
                        <input style="text-align: center;" id="patient_file"
                            accept="image/jpeg, image/png, image/jpg, image/gif" type="file" class="form-control"
                            name="patient_file" required>
                        @error('patient_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 text-end" style="text-align: center;">
                        <button type="submit" class="btn btn-primary">{{ __('اضافة مراجعة جديدة  ') }}</button>
                    </div>

                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button style="width: 850px;height: 50px;" class="btn btn-secondary close-btn "
                        data-modal-id="{{ $patient->id }}">اغلاق الصفحة</button>
                </div>
            </div>
        </div>
    @endforeach



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
@endsection
