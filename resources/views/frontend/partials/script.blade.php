<script src="{{ asset('frontend/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('frontend/js/plugins.js') }}"></script>
<script src="{{ asset('frontend/js/main.js') }}"></script>
<script src="{{ asset('frontend/js/toastr.min.js') }}"></script>

{{-- Google Translator JS --}}
<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>
<!-- Toastr JS -->
<script>
    $(document).ready(function() {
        toastr.options = {
            'closeButton': true,
            'debug': true,
            'newestOnTop': true,
            'progressBar': false,
            'positionClass': 'toast-top-center',
            'preventDuplicates': true,
            'showDuration': '1000',
            'hideDuration': '1000',
            'timeOut': '5000',
            'extendedTimeOut': '1000',
            'showEasing': 'linear',
            'hideEasing': 'linear',
            'showMethod': 'slideDown',
            'hideMethod': 'slideUp',
            'hover': false,
        };

        @if (Session::has('t-success'))
            toastr.success("{{ session('t-success') }}");
        @endif

        @if (Session::has('status'))
            toastr.success("{{ session('status') }}");
        @endif

        @if (Session::has('t-error'))
            toastr.error("{{ session('t-error') }}");
        @endif

        @if (Session::has('t-info'))
            toastr.info("{{ session('t-info') }}");
        @endif

        @if (Session::has('t-warning'))
            toastr.warning("{{ session('t-warning') }}");
        @endif
    });
</script>

{{-- Google Translators --}}
{{-- Google Translators --}}
<script>
    function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'en,es',
            }, 'google_translate_element');
        }
    </script>

@stack('script')
