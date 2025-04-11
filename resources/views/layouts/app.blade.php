@include('layouts.partials.head')


<body>
    <!-- header area start -->
    @include('layouts.partials.header')
    <!-- header area end -->

    @include('layouts.partials.navbar')


    <main>

        @yield('content')

    </main>

    <article class="contenedor-redes-sociales">
		<div class="icono">
			<a href="https://www.facebook.com/FormandoLaWeb" class="icono-primary" target="_blank"><i class="fa-brands fa-facebook"></i></a>

			<div class="contenedor-descripcion">
				<a href="#" class="icono-descripcion">Seguir Facebook</a>
			</div>
		</div>
		<div class="icono">
			<a href="https://www.twitter.com/FormandoLaWeb" class="icono-primary color-tiktok" target="_blank"><i class="fa-brands fa-tiktok"></i></a>

			<div class="contenedor-descripcion">
				<a href="#" class="icono-descripcion color-tiktok">Seguir Tik Tok</a>
			</div>
		</div>
        <div class="icono">
			<a href="https://www.twitter.com/FormandoLaWeb" class="icono-primary color-whatsapp" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>

			<div class="contenedor-descripcion">
				<a href="#" class="icono-descripcion color-whatsapp">WhatsApp</a>
			</div>
		</div>
		<div class="icono">
			<a href="https://plus.google.com/114090693030000856714" class="icono-primary color-instagram" target="_blank"><i class="fa-brands fa-instagram"></i></a>

			<div class="contenedor-descripcion">
				<a href="#" class="icono-descripcion color-instagram">Seguir Instagram</a>
			</div>
		</div>
	</article>

    <!-- Start of LiveChat (www.livechat.com) code -->
    <script>
        window.__lc = window.__lc || {};
        window.__lc.license = 19110061;
        window.__lc.integration_name = "manual_channels";
        window.__lc.product_name = "livechat";
        (function(n, t, c) {
            function i(n) {
                return e._h ? e._h.apply(null, n) : e._q.push(n)
            }
            var e = {
                _q: [],
                _h: null,
                _v: "2.0",
                on: function() {
                    i(["on", c.call(arguments)])
                },
                once: function() {
                    i(["once", c.call(arguments)])
                },
                off: function() {
                    i(["off", c.call(arguments)])
                },
                get: function() {
                    if (!e._h) throw new Error("[LiveChatWidget] You can't use getters before load.");
                    return i(["get", c.call(arguments)])
                },
                call: function() {
                    i(["call", c.call(arguments)])
                },
                init: function() {
                    var n = t.createElement("script");
                    n.async = !0, n.type = "text/javascript", n.src = "https://cdn.livechatinc.com/tracking.js", t.head.appendChild(n)
                }
            };
            !n.__lc.asyncInit && e.init(), n.LiveChatWidget = n.LiveChatWidget || e
        }(window, document, [].slice))
    </script>
    <noscript><a href="https://www.livechat.com/chat-with/19110061/" rel="nofollow">Chat with us</a>, powered by <a href="https://www.livechat.com/?welcome" rel="noopener nofollow" target="_blank">LiveChat</a></noscript>
    <!-- End of LiveChat code -->



    <!-- footer area start -->
    @include('layouts.partials.footer')
    <!-- footer area end -->


    <!-- JS here -->
    @include('layouts.partials.script')


    @stack('scripts')
</body>

</html>