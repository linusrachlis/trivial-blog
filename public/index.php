<?php

use app\Post;

require_once __DIR__ . '/../bootstrap.php';

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/styles/main.css">
    <title>Excuse me while I blog</title>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
</head>
<body>
<header>
    <h1>Excuse me while I blog</h1>
</header>
<main>
    <h2>New post</h2>

    <?php
    require __DIR__ . '/actions/post-form.php';
    ?>

    <h2>Past posts</h2>

    <?php
    $posts = Post::list();
    foreach ($posts as $post) {
        ?>
        <article>
            <h3><?= htmlspecialchars($post->subject) ?></h3>
            <p><?= $post->posted_at ?></p>
            <p><?= htmlspecialchars($post->body) ?></p>
        </article>
        <?php
    }
    ?>
</main>
</body>
</html>
