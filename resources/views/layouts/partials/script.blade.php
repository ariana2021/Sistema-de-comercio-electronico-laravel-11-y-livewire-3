<script src="{{ asset('assets/principal/js/vendor/jquery.js') }}"></script>
<script src="{{ asset('assets/principal/js/vendor/waypoints.js') }}"></script>
<script src="{{ asset('assets/principal/js/bootstrap-bundle.js') }}"></script>
<script src="{{ asset('assets/principal/js/meanmenu.js') }}"></script>
<script src="{{ asset('assets/principal/js/swiper-bundle.js') }}"></script>
<script src="{{ asset('assets/principal/js/slick.js') }}"></script>
<script src="{{ asset('assets/principal/js/range-slider.js') }}"></script>
<script src="{{ asset('assets/principal/js/magnific-popup.js') }}"></script>
<script src="{{ asset('assets/principal/js/nice-select.js') }}"></script>
<script src="{{ asset('assets/principal/js/purecounter.js') }}"></script>
<script src="{{ asset('assets/principal/js/countdown.js') }}"></script>
<script src="{{ asset('assets/principal/js/wow.js') }}"></script>
<script src="{{ asset('assets/principal/js/isotope-pkgd.js') }}"></script>
<script src="{{ asset('assets/principal/js/imagesloaded-pkgd.js') }}"></script>
<script src="{{ asset('assets/principal/js/main.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
    $('.search-products').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '{{ route("products.search") }}',
                data: {
                    term: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            window.location.href = ui.item.url;
        }
    });
});

    document.addEventListener('livewire:init', function() {
        Livewire.on('showAlert', (res) => {
            alertSweet(res[0], res[1]);
        });
    });

    function alertSweet(titulo, icono) {
        Swal.fire({
            title: titulo,
            icon: icono,
            toast: true,
            position: 'bottom-start',
            showConfirmButton: false,
            timer: 2000
        });
    }
</script>
