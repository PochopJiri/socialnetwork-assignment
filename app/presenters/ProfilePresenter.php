<?php

namespace App\Presenters;

use Nette\Database\Context;
use Nette\Application\UI\Form;
use Nette\Security\Passwords;

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
            $postsArray = [];
            $posts = $this->database->table("posts")->where("user_id", $id)->order('created DESC');
            foreach ($posts as $post)
            {
                $liked = false;
                $likes = $this->database->table("likes")->where("post_id", $post->id);
                $count = 0;
                foreach ($likes as $like)
                {
                    if ($like->user_id == $this->getUser()->id) $liked = true;
                    $count++;
                }
                $postsArray[$post->id] = [
                    'db' => $post,
                    'user' => $this->database->table("users")->get($post->user_id),
                    'likes' => $count,
                    'like' => $liked
                ];
            }
            $this->template->posts = $postsArray;
            $this->template->friends = $this->database->table("friends")->where("user_id", $id)->count();
        }
        else
        {
            $this->flashMessage('Tento uživatel neexistuje.', 'warning');
            $this->redirect('Homepage:');
        }
	}

    public function renderFriends($id)
    {
        if ($this->database->table("users")->get($id))
        {
            $friends = $this->database->table("friends")->where("user_id", $id);
            $friendsArray = [];
            foreach ($friends as $friend)
            {
                $friendsArray[$friend->friend_id] = ['db' => $this->database->table("users")->where("id", $friend->friend_id)->fetch()];
            }
            $this->template->friends = $friendsArray;
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

    public function actionLike($post, $profile)
    {
        $row = $this->database->table("likes")->where("user_id", $this->getUser()->id)->where("post_id", $post);
        if ($row->fetch())
        {
            $row->delete();
        }
        else
        {
            $this->database->table("likes")->insert([
                "user_id" => $this->getUser()->id,
                "post_id" => $post
            ]);
        }
        $this->redirect('Profile:', array('id' => $profile));
    }

    public function renderEdit($id) {
        $currentUser = $this->getUser();
        $shownUser = $this->database->table("users")->get($id);
        if ($shownUser)
        {
            if ($shownUser->id == $currentUser->getId())
            {
                $this->template->shownUser = $shownUser;
            }
            else
            {
                $this->flashMessage('Na tuto akci nemáte dostatečná oprávnění.', 'warning');
                $this->redirect('Homepage:error');
            }
        }
        else
        {
            $this->flashMessage('Tento uživatel neexistuje.', 'warning');
            $this->redirect('Homepage:error');
        }
    }

    protected function createComponentEditUserForm() {
        $form = new Form;
        $form->addUpload('header', 'Header:');
        $form->addUpload('profile', 'Profilový obrázek:');
        $form->addEmail('email', 'E-mail:')
            ->setRequired('Zadejte prosím e-mail');
        $form->addPassword('password', "Nové heslo:");
        $form->addSubmit('add','Uložit');
        $form->onSuccess[] = [$this, 'EditUserFormSuccess'];
        return $form;
    }

    public function EditUserFormSuccess($form, $values) {
        $shownUser = $this->database->table('users')->get($this->getParameter('id'));
        if ($shownUser->email == $values->email || $this->database->table('users')->where("email", $values->email)->count() == 0)
        {
            $shownUser->update([
                'email' => $values->email
            ]);
            if ($values->header->name != null)
            {
                if ($values->header->isImage()) {
                    $file = $values->header;
                    $file_ext = strtolower(mb_substr($file->getSanitizedName(), strrpos($file->getSanitizedName(), ".")));
                    $filename = $values->email."h".$file_ext;
                    $file->move("img/".$filename);
                    $shownUser->update([
                        'header_pic' => $filename
                    ]);
                }
                else $this->flashMessage('Nepodporovaný formát obrázku!', 'danger');
            }
            if ($values->profile->name != null)
            {
                if ($values->profile->isImage()) {
                    $file = $values->profile;
                    $file_ext = strtolower(mb_substr($file->getSanitizedName(), strrpos($file->getSanitizedName(), ".")));
                    $filename = $values->email."p".$file_ext;
                    $file->move("img/".$filename);
                    $shownUser->update([
                        'profile_pic' => $filename
                    ]);
                }
                else $this->flashMessage('Nepodporovaný formát obrázku!', 'danger');
            }
            if ($values->password != null) $shownUser->update(['password' => Passwords::hash($values->password)]);
            $this->getUser()->logout();
            $form->getPresenter()->flashMessage('Profil byl úspěšně aktualizován. Přihlaste se prosím znovu.', 'success');
            $form->getPresenter()->redirect('Sign:in');
        }
        else {
            $form->getPresenter()->flashMessage('Tento e-mail již někdo používá.', 'danger');
        }
    }

    public function actionDeletePost($id, $profile)
    {
        $this->database->table("posts")->where("id", $id)->delete();
        $this->database->table("likes")->where("post_id", $id)->delete();
        $this->getPresenter()->flashMessage('Příspěvek byl smazán.', 'success');
        $this->redirect('Profile:', array('id' => $profile));
    }

    public function SignUpFormSuccess($form, $values) {
        if (($this->database->table('users')->where("username", $values->username)->count() <= 0)) {
            if ($values->picture->name != null && $values->picture->isImage()) {
                $file = $values->picture;
                $file_ext = strtolower(mb_substr($file->getSanitizedName(), strrpos($file->getSanitizedName(), ".")));
                $filename = $values->username.$file_ext;
                $file->move("pictures/".$filename);
                $this->database->table("users")->insert([
                    'picture' => "pictures/".$filename
                ]);
            }
            elseif ($values->picture->name != null) $this->flashMessage('Nepodporovaný formát obrázku!', 'danger');
            else {
                $this->database->table("users")->insert([
                    'picture' => "pictures/default.jpg"
                ]);
            }
        }
        else $this->flashMessage('Toto uživatelské jméno již někdo používá', 'danger');
    }
}
