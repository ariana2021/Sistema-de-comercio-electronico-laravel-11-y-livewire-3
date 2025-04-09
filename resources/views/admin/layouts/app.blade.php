@include('admin.layouts.partials.head')

<body>
    @include('admin.layouts.partials.header')

    @include('admin.layouts.partials.sidebar')

    <main class="main-wrapper">
        <div class="main-content">
            @yield('content')
        </div>
    </main>

    @include('admin.layouts.partials.footer')

    <!--bootstrap js-->
    <script src="{{ asset('assets/admin/js/bootstrap.bundle.min.js') }}"></script>

    <!--plugins-->
    <script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('assets/admin/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/peity/jquery.peity.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{asset('assets/admin/plugins/IconPicker/dist/iconpicker-1.5.0.js')}}"></script>
    <script>
        $(".data-attributes span").peity("donut")
    </script>
    <script src="{{ asset('assets/admin/js/main.js') }}"></script>
    {{-- <script src="{{ asset('assets/admin/js/dashboard1.') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function abrirVentanaEmergente(url) {
            const width = 800;
            const height = 600;

            const left = (window.screen.width / 2) - (width / 2);
            const top = (window.screen.height / 2) - (height / 2);

            const pdfWindow = window.open(
                url,
                '_blank',
                `width=${width},height=${height},top=${top},scrollbars=yes,resizable=yes`
            );

            pdfWindow.onload = function() {
                pdfWindow.print();
            };
        }
    </script>

    @livewireScripts
    @stack('scripts')
</body>

</html>
