<!DOCTYPE html>
<html>

<!-- meta contains meta taga, css and fontawesome icons etc -->
@include('admin.common.meta')
<!-- ./end of meta -->

<body class="hold-transition login-page">
<!-- wrapper -->
<div class="wrapper">

    <!-- dynamic content -->
    @yield('content');
    <!-- ./end of dynamic content -->

</div>
<!-- ./wrapper -->

<!-- all js scripts including custom js -->
@include('admin.common.scripts')
<!-- ./end of js scripts -->

</body>
</html>
