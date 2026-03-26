<!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- PWA Service Worker Registration (Global) -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('[PWA] Service Worker înregistrat.'))
                    .catch(err => console.log('[PWA] Eroare SW:', err));
            });
        }
    </script>

    <!-- Scripturi specifice paginii -->
    <?php if (isset($extraScripts)) echo $extraScripts; ?>
    
    <script>
    if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
    navigator.serviceWorker.register('/firebase-messaging-sw.js')
      .then(function(registration) {
        console.log('ServiceWorker PWA activat cu scope: ', registration.scope);
      }).catch(function(err) {
        console.error('ServiceWorker a eșuat: ', err);
         });
     });
    }
</script>
</body>
</html>