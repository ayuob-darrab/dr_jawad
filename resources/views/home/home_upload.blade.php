@extends('layouts.app')

@section('content')
<br>
<br>
<br>
    <div class="container">
        <div style="text-align: center ; margin-top: -25px;">
            <img src="{{ asset('img/dr.png') }}" width="200px" height="200px" alt="">

        </div>
         <br>
         <br>
         <br>
        <div class="row justify-content-center">

            <div class="col-md-8">
                @if (Auth::check() && Auth::user()->type === '1')
                <br>

                    {{-- <a href="/operations/all_reports_recive" class="btn btn-secondary btn-lg btn-block"> --}}
                    <a href="upload_information" class="btn btn-secondary btn-lg btn-block">
                        <h2>رفع المعلومات</h2>
                    </a>
                    <br>
                    <a href="upload_department" class="btn btn-secondary btn-lg btn-block">
                        <h2> رفع الصور</h2>
                    </a>

                @endif
                <br>
            </div>
        </div>
    </div>
@endsection
