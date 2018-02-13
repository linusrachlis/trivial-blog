<?php

namespace app\actions\post;

use app\Html;
use app\Post;
use lib\ActionBase;
use lib\Fieldset;

class CreateForm extends ActionBase
{
    public static function get()
    {
        self::direct(false);
    }

    public static function post()
    {
        self::direct(true);
    }

    public static function direct(bool $submitted = false)
    {
        $fieldset = new Fieldset();

        if ($submitted) {
            $fieldset->subject->validatePresent('Required');
            $fieldset->body->validatePresent('Required');

            if ($fieldset->isValid()) {
                Post::insert(
                    $fieldset->subject->value(),
                    $fieldset->body->value());
                exit;
            }
        }

        ?>
        <form class="ajax-form" id="create-form"
              data-action="<?= htmlspecialchars(__CLASS__) ?>"
              data-refresh="#posts, #create-form">
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
    }
}
