@include('layouts.partials.head')


<body>
    <!-- header area start -->
    @include('layouts.partials.header')
    <!-- header area end -->

    @include('layouts.partials.navbar')


    <main>

        @yield('content')

    </main>

    <!-- Messenger Plugin de chat -->
    <div id="fb-root"></div>

    <!-- Script del chat -->
    <script>
        window.fbAsyncInit = function() {
            console.log('Hola FB');
            FB.init({
                xfbml: true,
                version: 'v17.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/es_LA/sdk/xfbml.customerchat.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <!-- Contenedor del chat -->
    <div class="fb-customerchat" attribution="install_email" page_id="100063839452157">
    </div>



    <!-- footer area start -->
    @include('layouts.partials.footer')
    <!-- footer area end -->


    <!-- JS here -->
    @include('layouts.partials.script')

    @stack('scripts')
</body>

</html>
