@include('layouts.partials.head')


<body>
    <!-- header area start -->
    @include('layouts.partials.header')
    <!-- header area end -->

    @include('layouts.partials.navbar')


    <main>

        @yield('content')

    </main>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/680c3c6129a5a6191417aaea/1ipnt1rm0';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->

    <!-- footer area start -->
    @include('layouts.partials.footer')
    <!-- footer area end -->


    <!-- JS here -->
    @include('layouts.partials.script')


    @stack('scripts')
</body>

</html>
