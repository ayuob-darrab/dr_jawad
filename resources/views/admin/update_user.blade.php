@extends('layouts.app')

@section('content')
@if (Auth::check() && Auth::user()->type === '1' )
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
                    <div class="card-header">{{ __(' تحديث المعلومات') }}</div>

                    <div class="card-body" dir="rtl">
                        {!! Form::open([
                            'action' => ['AdminController@update', $EditUser->id],
                            // 'method' => 'POST',
                            'autocomplete' => 'off',
                            'files' => true,
                        ]) !!}
                                 {!! method_field('PUT') !!}
                                 {!! Form::hidden('Update_user_info', 'Update_user_info') !!}

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('الاسم') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    placeholder="الاسم" value="{{ $EditUser->name }}" required autocomplete="name"
                                    autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="username"
                                class="col-md-4 col-form-label text-md-end">{{ __('اسم المستخدم') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text"
                                    class="form-control @error('username') is-invalid @enderror" name="username"
                                    value="{{ $EditUser->username }}" placeholder="اسم المستخدم" required
                                    autocomplete="username">

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="type"
                                class="col-md-4 col-form-label text-md-end">{{ __('نوع المستخدم') }}</label>

                            <div class="col-md-6">
                                <select id="type" class="form-control" name="type_user">
                                    <option disabled>اختار نوع المستخدم</option>
                                    <option @if ($EditUser->type == '1') selected @endif value="1">ادمن</option>
                                    <option @if ($EditUser->type == '2') selected @endif value="2">مستخدم</option>
                                </select>
                            </div>
                        </div>

                        {{-- <label for="enableInput">Enable Input</label>
    <input type="checkbox" id="enableInput" onchange="toggleInput()"> --}}

                        <div class="row mb-3">
                            <label for="enableInput"
                                class="col-md-4 col-form-label text-md-end">{{ __('تحديث كلمة  المرور') }}</label>

                            <div class="col-md-2">
                                <input type="checkbox" id="enableInput" onchange="toggleInput()" style="height: 35px; width:25px;" name="check_password">

                            </div>
                        </div>






                        <div class="row mb-3">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-end">{{ __('كلمة المرور الجديدة') }}</label>

                            <div class="col-md-6">
                                <input type="text" id="textInput" disabled
                                    class="form-control @error('password') is-invalid @enderror" placeholder="كلمة المرور الجديدة"
                                    name="new_password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __(' تحديث المعلومات') }}
                                </button>
                            </div>

                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        // JavaScript function to toggle the input field's disabled attribute
        function toggleInput() {
            var inputField = document.getElementById("textInput");
            var checkbox = document.getElementById("enableInput");

            // Enable/disable the input field based on the checkbox status
            if (!checkbox.checked) {
                inputField.disabled = true;
                inputField.value = "";
            } else {
                inputField.disabled = false;
            }
        }
    </script>
    @endif
@endsection
