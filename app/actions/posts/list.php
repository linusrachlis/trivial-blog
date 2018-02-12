<?php

use app\Post;
use lib\Util;

return function () {
    ?>
    <section id="posts" data-refresh-url="/action.php?action=posts/list">
        <?php
        $posts = Post::list();
        foreach ($posts as $post) {
            ?>
            <article>
                <h3><?= htmlspecialchars($post->subject) ?></h3>
                <p class="timestamp"><?= htmlspecialchars($post->posted_at) ?></p>
                <p><?= htmlspecialchars($post->body) ?></p>
                <?php Util::encloseScript(__DIR__ . '/delete-button.php', ['id' => $post->id]) ?>
            </article>
            <?php
        }
        ?>
    </section>
    <?php
};
