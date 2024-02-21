<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SIK | @yield('judul')</title>
    @include('layouts.header')

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        @include('layouts.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('layouts.navbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">@yield('subjudul')</h1>
                    </div>

                    <!-- Content Row -->
                    @yield('content')




                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <footer class="sticky-footer bg-primary">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto" style="color: #fff">
                        <span>Copyright &copy; <strong>Sistem Informasi Kepegawaian PT. JAI
                                <?php echo date('Y'); ?></strong></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    @include('layouts.footer')
