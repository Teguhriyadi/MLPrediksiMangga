<script src="{{ asset('templating/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('templating/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('templating/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('templating/js/sb-admin-2.min.js') }}"></script>
<script>
    (function() {
        var body = document.body;
        var wrapper = document.getElementById('wrapper');
        var sidebar = document.getElementById('accordionSidebar');
        var sidebarToggleTop = document.getElementById('sidebarToggleTop');

        function setMobileSidebarVisible(isVisible) {
            if (!body || !wrapper || !sidebar) {
                return;
            }

            body.classList.toggle('mobile-sidebar-hidden', !isVisible);
            wrapper.classList.toggle('mobile-sidebar-hidden', !isVisible);
            sidebar.classList.toggle('mobile-sidebar-hidden', !isVisible);
        }

        function syncMobileShell() {
            var isMobile = window.innerWidth < 768;

            if (!body || !wrapper || !sidebar) {
                return;
            }

            if (isMobile) {
                body.classList.add('mobile-sidebar-icon');
                wrapper.classList.add('toggled');
                sidebar.classList.add('toggled');
                if (!body.classList.contains('mobile-sidebar-hidden')) {
                    setMobileSidebarVisible(true);
                }
            } else {
                body.classList.remove('mobile-sidebar-icon');
                body.classList.remove('mobile-sidebar-hidden');
                wrapper.classList.remove('toggled');
                wrapper.classList.remove('mobile-sidebar-hidden');
                sidebar.classList.remove('toggled');
                sidebar.classList.remove('mobile-sidebar-hidden');
            }
        }

        if (sidebarToggleTop) {
            sidebarToggleTop.addEventListener('click', function(event) {
                if (window.innerWidth >= 768) {
                    return;
                }

                event.preventDefault();
                event.stopPropagation();

                var shouldShow = body.classList.contains('mobile-sidebar-hidden');
                setMobileSidebarVisible(shouldShow);
            });
        }

        window.addEventListener('load', syncMobileShell);
        window.addEventListener('resize', syncMobileShell);
    })();
</script>

@stack("js")
