<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpenVote</title>
    <link rel="stylesheet" href="./styles/normalize.css">
    <link rel="stylesheet" href="./styles/custom.css">
    <link rel="icon" type="image/svg+xml" href="imgs/logo.svg">
</head>
<body>
    <nav class="nav">
        <div class="nav-brand">
            <svg class="nav-brand__img" viewBox="0 0 200 200">
            <defs>
                <linearGradient id="grad" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0%" stop-color="#2DB688"></stop>
                <stop offset="100%" stop-color="#14532D"></stop>
                </linearGradient>
            </defs>
            <rect width="200" height="200" rx="30" fill="url(#grad)"></rect>
            <path d="M50 60 
                    Q50 40 70 40 
                    L130 40 
                    Q150 40 150 60 
                    L150 100 
                    Q150 120 130 120 
                    L90 120 
                    L70 140 
                    L75 120 
                    Q50 120 50 100 Z" fill="white"></path>
            <path d="M80 80 L95 95 L120 70" stroke="#2DB688" stroke-width="8" fill="none" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>

            <a href="index.php?<?php echo http_build_query(['route' => 'dashboard']);?>" 
            class="nav-brand__text">OpenVote</a>
            <?php if($isAdmin):?>
                <p class="nav-brand__text">•</p>
                <a href="index.php?<?php echo http_build_query(['route' => 'adminPanel']);?>" 
                    class="nav-brand__text"> Admin panel
                </a>
            <?php endif; ?>
        </div>
        <div class="nav-links">
            <a href="index.php?<?php echo http_build_query(['route' => 'forum']) ?>" class="nav-links__text" >Forum</a>
            <?php if($isLoggedIn): ?>
                <a href="index.php?<?php echo http_build_query(['route' => 'create']) ?>" class="nav-links__text" >Suggest</a>
                <a href="index.php?<?php echo http_build_query(['route' => 'profile']) ?>" class="nav-links__text" >My profile</a>
            <?php else: ?>
                <div class="nav-links__login">
                    <a href="index.php?<?php echo http_build_query(['route' => 'login']) ?>" class="nav-links__text" >Log In</a>
                    <a href="index.php?<?php echo http_build_query(['route' => 'register']) ?>" class="nav-links__text nav-links__register" >Register</a>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <main>
        <?php echo $content;?>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-brand">
            <strong>OpenVote</strong>
            </div>

            <nav class="footer-links">
            <a href="#">About</a>
            <a href="#">Security</a>
            <a href="#">Support</a>
            <a href="#">Contact</a>
            </nav>
        </div>

        <div class="footer-bottom">
            © 2026 OpenVote. All rights reserved.
        </div>
    </footer>
</body>
</html>