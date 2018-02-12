<?php

use app\Html;
use app\Post;
use lib\Fieldset;

require_once __DIR__ . '/../../../bootstrap.php';

$fieldset = new Fieldset();

if ('POST' == $_SERVER['REQUEST_METHOD']) {
    $fieldset->subject->validatePresent('Required');
    $fieldset->body->validatePresent('Required');

    if ($fieldset->isValid()) {
        Post::insert(
            $fieldset->subject->value(),
            $fieldset->body->value());
        exit;
    } else {
        header('HTTP/1.1 400 Bad Request');
    }
}

?>
<form class="ajax-form"
      data-action-url="/actions/post-form.php"
      data-refresh="#posts">
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
