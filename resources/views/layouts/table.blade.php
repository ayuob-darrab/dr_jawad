<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">





  <link rel="stylesheet" href="{{ asset('datatable\dataTables_bootstrap4_min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatable\bootstrap.css') }}">


    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .footer {
            background-color: #333; /* Set the background color */
            color: silver; /* Set the text color */
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>


</head>

<body>


    <div style="height: 50px; width: 100%; background-color: rgb(195, 191, 191);">
        <ul
            style="list-style-type: none; padding: 0; margin: 0; display: flex; justify-content: space-around; align-items: center; height: 100%;">

            @auth
                <li><a href="{{ route('logout') }}" style="text-decoration: none; color: black;"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">تسجيل الخروج</a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endauth
            {{-- <li><a href="/dr_jawad/admin/upload_page" style="text-decoration: none; color: black;">رفع المعلومات</a></li> --}}
<li><a href="/dr_jawad/admin/report_count" style="text-decoration: none; color: black;"> تقرير بالعدد</a>



<li><a href="backup_database" style="text-decoration: none; color: black;">  نسخ احتياطي</a>







            <li><a href="/dr_jawad/report" style="text-decoration: none; color: black;"> مسح وتعديل البيانات</a></li>






            <li><a href="/dr_jawad/admin/new_patient" style="text-decoration: none; color: black;">اضافة مريض جديد</a>
            </li>


            <li><a href="/dr_jawad" style="text-decoration: none; color: black;">الصفحة الرئيسية</a></li>




        </ul>
    </div>



    <div class="container">

        <br>
        <div>
            @yield('content_table')
        </div>
    </div>


   <script src="{{ asset('datatable\jquery.js') }}"></script>
    <script src="{{ asset('datatable\jquerydataTablesmin.js') }}"></script>
    <script src="{{ asset('datatable\dataTablesbootstrap4min.js') }}"></script>

    <script>
        new DataTable('#example');
    </script>

    <script>
        function printDataTable() {
            // Trigger the print functionality for the DataTable
            $('.data-table').DataTable().button('print').trigger();
        }
    </script>
<br>
<br>
       <div class="footer">
    حقوق النشر © 2023 اسم المالك أو الشركة
</div>


</body>

</html>
