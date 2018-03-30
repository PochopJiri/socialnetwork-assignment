<?php

namespace App\Presenters;

use Nette\Application\UI\Form;
use Nette\Database\Context;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;
use Nette\Security\AuthenticationException;
use Nette\Security\Passwords;


class SignPresenter extends BasePresenter
{
    private $database;

    public function __construct(Context $database)
    {
        parent::__construct($database);
        $this->database = $database;
    }

    protected function createComponentSignInForm()
    {
        $form = new Form;
        $form->addEmail('email', 'E-mail: ')
            ->setRequired('Zadejte prosím e-mail');
        $form->addPassword('password','Heslo:')
            ->setRequired('Zadejte prosím heslo');
        $form->addSubmit('add','Přihlásit se');
        $form->onSuccess[] = [$this, 'SignInFormSuccess'];
        return $form;
    }

    public function SignInFormSuccess($form, $values)
    {
        try {
            $this->getUser()->login($values->email, $values->password);
            $this->flashMessage('Vítejte ' . $this->database->table("users")->where("id", $this->getUser()->id)->fetch()->forename . '!', 'success');
            $this->redirect('Homepage:');
        } catch (AuthenticationException $e) {
            $this->flashMessage($e->getMessage(), 'warning');
            $this->redirect('this');
        }

    }

    protected function createComponentSignUpForm()
    {
        $form = new Form;
        $form->addText('forename', 'Jméno:')
            ->setRequired('Zadejte prosím jméno');
        $form->addText('surname', 'Příjmení:')
            ->setRequired('Zadejte prosím příjmení');
        $form->addEmail('email', 'E-mail:')
            ->setRequired('Zadejte prosím e-mail');
        $form->addPassword('password','Heslo:')
            ->setRequired('Zadejte prosím heslo');
        $form->addSubmit('add','Registrovat');
        $form->onSuccess[] = [$this, 'SignUpFormSuccess'];
        return $form;
    }

    public function SignUpFormSuccess($form, $values)
    {
        if (($this->database->table('users')->where("email", $values->email)->count() <= 0))
        {
            $this->database->table("users")->insert([
                'forename' => $values->forename,
                'surname' => $values->surname,
                'email' => $values->email,
                'password' => Passwords::hash($values->password),
                'header_pic' => "default-header.jpg",
                'profile_pic' => "default-picture.jpg"
            ]);
            $this->getUser()->login($values->email, $values->password);
            $this->flashMessage('Vítejte ' . $values->forename . '!', 'success');
            $this->redirect('Homepage:default');
        }
        else $this->flashMessage('Tento e-mail jméno již někdo používá', 'danger');
    }

    public function actionOut()
    {
        $this->getUser()->logout();
        $this->redirect('Homepage:');
    }
}