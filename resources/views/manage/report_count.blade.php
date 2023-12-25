@extends('layouts.table')

@section('content_table')


<div style="text-align: right">

    جميع المراجعات الخاصة بالمريض :
    <h2 style=" text-align: center;">






        {{-- <button type="button" style="width:350px;margin-top: 9px; height: 50px; margin-right: 290px;"
            class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete_all{{ $personal_visit->id }}">
            مسح المعلومات الشخصية وجميع المراجعات
        </button> --}}
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


        {{-- <strong style="background-color: rgb(118, 209, 148); text-align: center;">{{ $personal_visit->name
            }}</strong> --}}


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
            <th>#</th>
            <th>  نوع التقرير</th>
            <th>  العدد</th>


        </tr>
    </thead>
    <tbody>
        @php
        $i = 1;
        @endphp

        <tr>
            <td>{{ $i }}</td>
            <td>التقرير اليومي</td>
            <td>{{ $daily }}</td>
        </tr>
        @php
        $i++;
        @endphp
        <tr>
            <td>{{ $i }}</td>
            <td>التقرير الاسبوعي</td>
            <td>{{ $weekly }}</td>
        </tr>
        @php
        $i++;
        @endphp
        <tr>
            <td>{{ $i }}</td>
            <td>التقرير الشهري</td>
            <td>{{ $monthly }}</td>
        </tr>
        @php
        $i++;
        @endphp

    </tbody>
</table>





@endsection
