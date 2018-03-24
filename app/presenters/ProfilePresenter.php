<?php

namespace App\Presenters;

use Nette\Database\Context;
use Nette\Application\UI\Form;

class ProfilePresenter extends BasePresenter
{
    private $database;

    public function __construct(Context $database)
    {
        parent::__construct($database);
        $this->database = $database;
    }

	public function renderDefault($id)
	{
        $shownUser = $this->database->table("users")->get($id);
        if ($shownUser)
        {
            $this->template->shownUser = $shownUser;
            if ($shownUser->id == $this->getUser()->id) $me = true;
            else
            {
                $me = false;
                $isFriend = false;
                foreach ($this->database->table("friends")->where("user_id", $this->getUser()->id) as $friend)
                {
                    if ($friend->friend_id == $id) $isFriend = true;
                }
                $this->template->friend = $isFriend;
            }
            $this->template->me = $me;
            $this->template->posts = $this->database->table("posts")->where("user_id", $id)->order('created DESC');
        }
        else
        {
            $this->flashMessage('Tento uživatel neexistuje.', 'warning');
            $this->redirect('Homepage:');
        }
	}

    protected function createComponentChangeFriendship()
    {
        $form = new Form;
        $form->addSubmit('change','Změnit');
        $form->onSuccess[] = [$this, 'ChangeFriendshipSuccess'];
        return $form;
    }

    public function ChangeFriendshipSuccess($form, $values)
    {
        $row = $this->database->table("friends")->where("user_id", $this->getUser()->id)->where("friend_id", $this->getParameter('id'));
        if ($row->fetch())
        {
            $row->delete();
        }
        else
        {
            $this->database->table("friends")->insert([
                "user_id" => $this->getUser()->id,
                "friend_id" => $this->getParameter("id")
            ]);
        }
        $form->getPresenter()->redirect('this');
    }
}
