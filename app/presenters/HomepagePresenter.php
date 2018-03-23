<?php

namespace App\Presenters;

use Nette;
use Nette\Database\Context;


class HomepagePresenter extends Nette\Application\UI\Presenter
{
    private $database;

    public function __construct(Context $database) {
        $this->database = $database;
    }

    public function renderDefault()
    {
        $likes = $this->database->table("likes");
        $likesArray = [];
        foreach ($likes as $like) {
            if ($like->user_id == 1)
                $likesArray += [$like->post_id, true];
            else
                $likesArray += [$like->post_id, false];
        }
        $this->template->likes = $likesArray;
    }
}
