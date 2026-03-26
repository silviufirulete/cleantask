<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo $pageTitle ?? 'Clean Task Manager'; ?></title>
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="<?= BASE_PATH ?>/manifest.json">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Tasks">

    <!-- Theme Color -->
    <meta name="theme-color" content="#ffffff">

    <!-- ICONS -->
    <link rel="shortcut icon" href="<?= BASE_PATH ?>/favicon.ico?v=<?php echo time(); ?>">
    <link rel="apple-touch-icon" href="<?= BASE_PATH ?>/apple-touch-icon.png?v=<?php echo time(); ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= BASE_PATH ?>/web-app-manifest-192x192.png?v=<?php echo time(); ?>">
    <link rel="icon" type="image/png" sizes="512x512" href="<?= BASE_PATH ?>/web-app-manifest-512x512.png?v=<?php echo time(); ?>">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/style.css?v=<?php echo time(); ?>">

    <!-- Inject Firebase Config -->
    <script>
        window.superAdminEmail = "<?php echo getenv('SUPER_ADMIN_EMAIL'); ?>";
        window.firebaseConfig = {
            apiKey: "<?php echo getenv('FIREBASE_API_KEY'); ?>",
            authDomain: "<?php echo getenv('FIREBASE_AUTH_DOMAIN'); ?>",
            projectId: "<?php echo getenv('FIREBASE_PROJECT_ID'); ?>",
            storageBucket: "<?php echo getenv('FIREBASE_STORAGE_BUCKET'); ?>",
            messagingSenderId: "<?php echo getenv('FIREBASE_MESSAGING_SENDER_ID'); ?>",
            appId: "<?php echo getenv('FIREBASE_APP_ID'); ?>"
        };
    </script>
    
    <script>
    if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
    navigator.serviceWorker.register('<?= BASE_PATH ?>/firebase-messaging-sw.js')
      .then(function(registration) {
        console.log('ServiceWorker PWA activat cu scope: ', registration.scope);
      }).catch(function(err) {
        console.error('ServiceWorker a eșuat: ', err);
          });
      });
    }
</script>
</head>
<body class="bg-light">