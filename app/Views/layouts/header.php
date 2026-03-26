<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo $pageTitle ?? 'Clean Task Manager'; ?></title>
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Tasks">
    <link rel="apple-touch-icon" href="/icons/icon-152x152.png">
    
    <!-- Theme Color -->
    <meta name="theme-color" content="#ffffff">
    
    <!-- ICONS -->
    <!-- 1. Standard Favicon (Legacy & Desktop Tabs) -->
    <link rel="shortcut icon" href="/favicon.ico?v=<?php echo time(); ?>">
    
    <!-- 2. Apple Touch Icon (CRITIC pentru iPhone/iPad - Home Screen) -->
    <link rel="apple-touch-icon" href="https://cleantask.silviufirulete.de/assets/img/icon-192.png?v=<?php echo time(); ?>">
    
    <!-- 3. Android/Chrome High-Res Icons -->
    <link rel="icon" type="image/png" sizes="192x192" href="https://cleantask.silviufirulete.de/assets/img/icon-192.png?v=<?php echo time(); ?>">
    <link rel="icon" type="image/png" sizes="512x512" href="https://cleantask.silviufirulete.de/assets/img/icon-512.png?v=<?php echo time(); ?>">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/style.css?v=<?php echo time(); ?>">

    <!-- Inject Firebase Config -->
    <script>
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
    navigator.serviceWorker.register('/firebase-messaging-sw.js')
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