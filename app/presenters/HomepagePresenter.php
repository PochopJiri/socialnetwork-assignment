<?php

namespace App\Presenters;

use Nette\Database\Context;
use Nette\Application\UI\Form;
use Nette\Utils\DateTime;

class HomepagePresenter extends BasePresenter
{
    private $database;

    public function __construct(Context $database)
    {
        parent::__construct($database);
        $this->database = $database;
    }

    protected function createComponentAddPost()
    {
        $form = new Form;
        $form->addTextArea('content', 'Text:')
            ->setRequired('Zadejte prosím text');
        $form->addSubmit('add','Zveřejnit');
        $form->onSuccess[] = [$this, 'AddPostSuccess'];
        return $form;
    }

    public function AddPostSuccess($form, $values)
    {
        $row = $this->database->table("posts")->insert([
            'user_id' => $this->getUser()->getId(),
            'content' => $values->content,
            'created' => new DateTime
        ]);
        $form->getPresenter()->flashMessage('Příspěvek byl úspěšně přidán.', 'success');
        $form->getPresenter()->redirect('Homepage:');
    }
}
