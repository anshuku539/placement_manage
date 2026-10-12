<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Close mobile offcanvas on link click
    document.addEventListener("DOMContentLoaded", function() {
        var offcanvasElement = document.getElementById('adminSidebar');
        if (offcanvasElement && typeof bootstrap !== 'undefined') {
            var offcanvasLinks = offcanvasElement.querySelectorAll('.sidebar-menu a');
            offcanvasLinks.forEach(function(link) {
                link.addEventListener('click', function() {
                    var bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
                    if (bsOffcanvas) {
                        bsOffcanvas.hide();
                    }
                });
            });
        }
    });
</script>
</body>
</html>
