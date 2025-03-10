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
<script src="{{ asset('assets/principal/js/ajax-form.js') }}"></script>
<script src="{{ asset('assets/principal/js/main.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('livewire:init', function() {
        Livewire.on('showAlert', (res) => {
            console.log(res);
            Swal.fire({
                title: res[0],
                icon: res[1],
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });
        });
    });
</script>
