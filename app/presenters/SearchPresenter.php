<?php

namespace App\Presenters;

use Nette\Database\Context;
use Nette\Application\UI\Form;
use Nette\Utils\DateTime;

class SearchPresenter extends BasePresenter
{
    private $database;

    public function __construct(Context $database)
    {
        parent::__construct($database);
        $this->database = $database;
    }

    public function renderDefault($search)
    {
        $this->template->forenames = $this->database->table("users")->where("forename", $search);
        $this->template->surnames = $this->database->table("users")->where("surname", $search);
        $this->template->emails = $this->database->table("users")->where("email", $search);
    }
}
