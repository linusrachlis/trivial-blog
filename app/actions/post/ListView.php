<?php

namespace app\actions\post;

use app\Post;
use lib\ActionBase;

class ListView extends ActionBase
{
    public static function get()
    {
        ?>
        <section id="posts" data-action="<?= htmlspecialchars(__CLASS__) ?>">
            <?php
            $posts = Post::list();
            foreach ($posts as $post) {
                ?>
                <article>
                    <h3><?= htmlspecialchars($post->subject) ?></h3>
                    <p class="timestamp"><?= htmlspecialchars($post->posted_at) ?></p>
                    <p><?= htmlspecialchars($post->body) ?></p>
                    <?php DeleteButton::direct($post->id) ?>
                </article>
                <?php
            }
            ?>
        </section>
        <?php
    }
}
