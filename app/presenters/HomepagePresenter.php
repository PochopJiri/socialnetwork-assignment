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

    public function renderDefault()
    {
        $postsArray = [];
        $posts = $this->database->table("posts")->order('created DESC');
        $friends = $this->database->table("friends")->where("user_id", $this->getUser()->id);
        foreach ($friends as $friend)
        {
            foreach ($posts->where("user_id", $friend->friend_id) as $post)
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
        }
        $this->template->posts = $postsArray;
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
        $this->database->table("posts")->insert([
            'user_id' => $this->getUser()->getId(),
            'content' => $values->content,
            'created' => new DateTime
        ]);
        $form->getPresenter()->flashMessage('Příspěvek byl úspěšně přidán.', 'success');
        $form->getPresenter()->redirect('Homepage:');
    }

    public function actionLike($post)
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
        $this->redirect('Homepage:');
    }
}
