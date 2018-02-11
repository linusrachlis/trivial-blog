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
    }
}

$uuid = uniqid('post-form-');
?>
    <form method="post" id="<?= $uuid ?>">
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

/*
<script>
document.addEventListener('DOMContentLoaded', e => {
    // noinspection JSAnnotator
    const uuid = <?= json_encode($uuid) ?>;
    const form = document.querySelector('#' + uuid);
    form.addEventListener('submit', e => {

    });
});
</script>
*/
