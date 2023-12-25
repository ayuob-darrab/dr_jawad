@extends('layouts.table')

@section('content_table')


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


<link rel="stylesheet" href="{{ asset('modal\modalBootstrapv5.css') }}">


{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"> --}}




<script src="{{ asset('modal\modalBootstrapv5.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script> --}}
<div style="text-align: right">

    جميع المراجعات الخاصة بالمريض :
    <h2 style=" text-align: center;">






            <button type="button" style="width:350px;margin-top: 9px; height: 50px; margin-right: 290px;" class="btn btn-danger" data-bs-toggle="modal"
                data-bs-target="#delete_all{{ $personal_visit->id }}">
                مسح المعلومات الشخصية وجميع المراجعات
            </button>
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
            <th width="150px">مسح المراجعة </th>

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


                        <!-- Button trigger modal -->
                       <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#staticBackdrop{{ $review_visit->id }}">
                       مسح مراجعة
                    </button>



            </td>

        </tr>
        @php
        $i++;
        @endphp
        @endforeach
    </tbody>
</table>








<div class="modal fade" id="delete_all{{ $personal_visit->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 style="text-align: center;" class="modal-title fs-5" id="staticBackdropLabel">
                مسح جميع المعلومات للمريض : {{ $personal_visit->name }}
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 style="text-align: center;">مسح المراجعة وصورة التشخيص بتاريخ

                    الرجاء التحقق من المعلومات المراد مسحها سيتم مسح المعلومات الشخصية وجميع المراجعات ومسح صور التشخص ايضا

                </h5>
            </div>
            {!! Form::open([
            'action' => ['AdminController@destroy', $personal_visit->id],
            'method' => 'POST',
            'autocomplete' => 'off',
            'files' => true,
            ]) !!}
            {!! method_field('DELETE') !!}


            {!! Form::hidden('destroy_all_informations', 'destroy_all_informations') !!}

            <div class="modal-footer">
                <button type="submit" style="width: 100px;height: 50px; margin-right: 200px;"
                    class="btn btn-danger">مسح</button>
                <button type="button" style="width: 100px;height: 50px;" class="btn btn-success"
                    data-bs-dismiss="modal">الغاء</button>

            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>




@foreach ($review_visits as $review_visit)


  <!-- Modal -->
<div class="modal fade" id="staticBackdrop{{ $review_visit->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 style="text-align: center;" class="modal-title fs-5" id="staticBackdropLabel">مسح  المراجعة للمريض : {{ $personal_visit->name }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
           <h5 style="text-align: center;">مسح المراجعة وصورة التشخيص بتاريخ
                <br>
                <br>
                {{$review_visit->check_date}}


                </h5>
            </div>
           {!! Form::open([
            'action' => ['AdminController@destroy', $review_visit->id],
            'method' => 'POST',
            'autocomplete' => 'off',
            'files' => true,
            ]) !!}
            {!! method_field('DELETE') !!}


            {!! Form::hidden('destroy_review', 'destroy_review') !!}

            <div class="modal-footer">
                <button type="submit" style="width: 100px;height: 50px; margin-right: 200px;" class="btn btn-danger">مسح</button>
                <button type="button" style="width: 100px;height: 50px;" class="btn btn-success" data-bs-dismiss="modal">الغاء</button>

            </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>

@endforeach







@endsection
