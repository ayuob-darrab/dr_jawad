@extends('layouts.app')

@section('content')
@if (Auth::check() && Auth::user()->type === '1' )
    <br>
    <div  class="col-lg-10">
        <div class="card" style="margin-left: 350px;" >
            @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}</div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}</div>
            @endif


            @if (Auth::user()->type === '1' && Auth::user()->type !== '2')
            <div class="card-body">
                <h4 class="mb-3 header-title" style="text-align: right;">رفع المعلومات الجديدة</h4>

                {!! Form::open([
                    'action' => 'AdminController@store',
                    'method' => 'POST',
                    'autocomplete' => 'off',
                    'files' => true,
                ]) !!}

                {!! Form::hidden('Upload_new_information', 'Upload_new_information') !!}
                <div class="form-group"> </div>
                <div class="form-group mb-0">
                    <h4 style="text-align: right;">اختيار الملف الصحيح</h4>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" required name="upload_information"
                                accept=".xlsx,.xls,csv" id="inputGroupFile04">
                            <label class="custom-file-label" for="inputGroupFile04">اختبار الملف</label>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3"></div>
                <button type="submit" class="btn btn-primary waves-effect waves-light" style="width: 200px;">تحميل المعلومات</button>
                {!! Form::close() !!}
                @if ($errors->any())
                    <h4 style="color: red"> تاكد من الملف</h4>
                    <ol>
                        @foreach ($errors->all() as $error)
                            <li>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ol>
                @endif
            </div>
            @endif
            <!-- end card-body-->

            <!-- end card-body-->
        </div> <!-- end card-->

    </div>

    @endif
@endsection
