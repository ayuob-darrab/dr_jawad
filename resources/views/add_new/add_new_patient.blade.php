@extends('layouts.table')

@section('content_table')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <p class="text-muted font-13 mb-4">
                    @if (Session::has('success'))
                        <div class="alert alert-success" style="text-align: center;">
                            {{ Session::get('success') }}</div>
                    @endif
                </p>
                <div class="card">
                    <h3 class="card-header text-center">{{ __(' اضافة المعلومات الخاصة بالمريض الجديد') }}</h3>

                    <div class="card-body" dir="rtl">
                        {{-- <form method="POST" action="{{ route('register') }}">
                        @csrf --}}
                        {!! Form::open([
                            'action' => 'AdminController@store',
                            'method' => 'POST',
                            'autocomplete' => 'off',
                            'files' => true,
                        ]) !!}
                        {!! Form::hidden('add_new_patient', 'add_new_patient') !!}

                        <div class="row mb-3">
                            <label for="patient_name"
                                class="col-md-4 col-form-label text-md-end">{{ __('اسم المريض') }}</label>

                            <div class="col-md-6">
                                <input id="patient_name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="patient_name"
                                    placeholder="اسم المريض" value="{{ old('patient_name') }}" required
                                    autocomplete="patient_name" autofocus>

                                @error('patient_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="patient_age"
                                class="col-md-4 col-form-label text-md-end">{{ __(' عمر المريض') }}</label>

                            <div class="col-md-6">
                                <input id="patient_age" type="number" max="100" min="1"
                                    class="form-control @error('patient_age') is-invalid @enderror" name="patient_age"
                                    value="{{ old('patient_age') }}" placeholder="  عمر المريض " required
                                    autocomplete="patient_age">

                                @error('patient_age')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="patient_phone"
                                class="col-md-4 col-form-label text-md-end">{{ __('  رقم التلفون') }}</label>

                            <div class="col-md-6">
                                <input id="patient_phone" type="text" max="200" min="1"
                                    class="form-control @error('patient_phone') is-invalid @enderror"
                                    placeholder="رقم التلفون" name="patient_phone" required
                                    autocomplete="new-patient_phone">

                                @error('patient_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="type"
                                class="col-md-4 col-form-label text-md-end">{{ __('جنس المريض ') }}</label>

                            <div class="col-md-6">
                                <select id="type_patient" class="form-control" required name="type_patient">
                                    <option> </option>
                                    <option value="1">ذكر</option>
                                    <option value="2">انثى</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="note_patient" style="text-align: center;" class="form-label">{{ __('ملاحظات') }}</label>
                            <textarea  id="note_patient" class="form-control" name="note_patient"
                                placeholder="{{ __('ملاحظات') }}" required>
لا يوجد
                            </textarea>
                            @error('note_patient')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <br>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('اضافة المريض') }}
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @endif --}}
@endsection
