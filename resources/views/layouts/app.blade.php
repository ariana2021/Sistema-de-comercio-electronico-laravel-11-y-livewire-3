@include('layouts.partials.head')


<body>   
    <!-- header area start -->
    @include('layouts.partials.header')
    <!-- header area end -->

    @include('layouts.partials.navbar')


    <main>

        @yield('content')

    </main>


    <!-- footer area start -->
    @include('layouts.partials.footer')
    <!-- footer area end -->


    <!-- JS here -->
    @include('layouts.partials.script')

    @stack('scripts')
</body>

</html>
