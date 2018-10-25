<!DOCTYPE html>
<html>
@include('layout.head')
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        @include('layout.header')
        <!-- Left side column. contains the logo and sidebar -->
        @include('layout.left-sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        @include('layout.footer')
        <!-- Control Sidebar -->
        @include('layout.right-sidebar')
        <!-- /.control-sidebar -->
        <!-- Add the sidebar's background. This div must be placed
             immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
<!-- ./wrapper -->

@include('layout.scripts')

<!-- Morris.js charts -->
<script src="{{url("bower_components/raphael/raphael.min.js")}}"></script>
<script src="{{url("bower_components/morris.js/morris.min.js")}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{--<script src="{{url("dist/js/pages/dashboard.js")}}"></script>--}}
</body>
</html>
