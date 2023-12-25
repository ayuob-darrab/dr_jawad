@extends('layouts.table')

@section('content_table')
@if (Auth::check() && Auth::user()->type === '1' )
        <p class="text-muted font-13 mb-4">
            @if (Session::has('success'))
                <div class="alert alert-success" style="text-align: center;">
                    {{ Session::get('success') }}</div>
            @endif
        </p>
       <br>
        <table  dir="rtl" id="example" class="table table-striped table-bordered" style="width:100% ; text-align: center ">
            <thead>
                <tr >
                    <th class="text-center">الاسم</th>
                    <th class="text-center">اسم المستخدم</th>
                    <th class="text-center">نوعة</th>

                    <th class="text-center">تعديل </th>
                    {{-- <th>Salary</th> --}}
                </tr>
            </thead>
            <tbody>

                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }} </td>
                    <td>
                        @if ($user->type == 1)
                        {{ "ادمن" }}
                        @elseif($user->type == 2)
                        {{ "مستخدم" }}
                        @endif
                    </td>

                    <td> <a
                            href="{{ $user->id }}&edit_user/edit">
                             <button class="btn btn-info btn-rounded waves-effect waves-light"
                                style="width: 75px;">تعديل</button></a> </td>

                </tr>

                @endforeach



            </tfoot>
        </table>
@endif
        @endsection

