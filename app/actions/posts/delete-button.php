<?php

use app\Post;

require_once __DIR__ . '/../../../bootstrap.php';

if (empty($_GET['confirm'])) {
    ?>
    <button class="ajax-button"
            data-action-url="/actions/post-delete.php?id=<?= htmlspecialchars($id) ?>"
            data-refresh="#posts">
        Delete
    </button>
    <?php
}

if (
    !isset($_GET['id']) ||
    !is_numeric($_GET['id']) ||
    !Post::delete($_GET['id'])
) {
    header('HTTP/1.1 400 Bad Request');
}
