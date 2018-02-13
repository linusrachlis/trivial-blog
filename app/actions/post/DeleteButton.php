<?php

namespace app\actions\post;

use app\Post;
use lib\ActionBase;
use lib\html\Element;
use lib\Util;

class DeleteButton extends ActionBase
{
    public static function post()
    {
        [$id, $confirm] = Util::allFromPost('id', 'confirm');

        if (
            !isset($id) ||
            !is_numeric($id)
        ) {
            header('HTTP/1.1 400 Bad Request');
            exit("Bad ID: " . var_export($id, true));
        }

        if (!isset($confirm)) $confirm = false;

        self::direct($id, true, $confirm);
    }

    public static function direct(int $id, bool $pressed = false, bool $confirm = false)
    {
        $button = (new Element('button'))->set('class', 'ajax-button');
        $button->contents = 'Delete';
        $button->data = [
            'action' => __CLASS__,
            'action-params' => compact('id'),
            'refresh' => '#posts',
        ];

        if ($pressed) {
            if ($confirm) {
                if (0 == Post::delete($id)) {
                    header('HTTP/1.1 400 Bad Request');
                    echo "ID " . var_export($id, true) . " not found";
                }
                exit;
            } else {
                // Send confirm on next press
                $button->data['action-params']['confirm'] = true;
                $button->contents = 'Confirm';
            }
        }

        echo $button->render();
    }
}
