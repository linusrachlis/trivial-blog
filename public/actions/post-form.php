<?php

use app\Html;
use app\Post;
use lib\Fieldset;

require_once __DIR__ . '/../../bootstrap.php';

$fieldset = new Fieldset();

if ('POST' == $_SERVER['REQUEST_METHOD']) {
    $fieldset->subject->validatePresent('Required');
    $fieldset->body->validatePresent('Required');

    if ($fieldset->isValid()) {
        Post::insert(
            $fieldset->subject->value(),
            $fieldset->body->value());
        header("Location: /");
        ob_end_clean();
        exit;
    } else {
        header('HTTP/1.1 400 Bad Request');
    }
}

?>
    <form method="post" id="post-form">
        <label>
            Subject<br>
            <?= Html::textInput($fieldset->subject) ?>
        </label>
        <label>
            Body<br>
            <?= Html::textarea($fieldset->body) ?>
        </label>
        <button type="submit">Create</button>
    </form>
<?php
if ('POST' != $_SERVER['REQUEST_METHOD']) {
    ?>
    <script>
        $(($) => {
            $(document).on('submit', '#post-form', function (e) {
                const $form = $(this);
                $.post('/actions/post-form.php', $form.serialize())
                    .done(() => {
                        window.location.reload();
                    })
                    .fail((xhr, textStatus, errorThrown) => {
                        switch (xhr.status) {
                            case 400:
                                $form.replaceWith(xhr.responseText);
                                break;
                            default:
                                alert("Sorry, the request broke");
                        }
                    });
                e.preventDefault();
                return false;
            });
        });
    </script>
    <?php
}
