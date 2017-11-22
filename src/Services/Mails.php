<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 26/09/17
 * Time: 13:46
 */
namespace App\Services;


use App\Entity\User;
use Doctrine\ORM\EntityManager;


class Mails
{

    private $twig;
    private $doctrine;

    /**
     * Mails constructor.
     * @param \Twig_Environment $twig
     * @param EntityManager $doctrine
     */
    public function __construct(
        \Twig_Environment $twig,
        EntityManager     $doctrine

    )
    {
        $this->twig     = $twig;
        $this->doctrine = $doctrine;
    }

    /**
     * @param $email
     * @return mixed
     */
    public function checkMailAvailability($email)
    {
        $repository = $this->doctrine->getRepository(User::class);

        return  $repository->findOneByEmail($email);
    }

    /**
     * @param $name
     * @param $surname
     * @param $token
     * @param $email
     * @return \Swift_Message
     */
    public function validationMail($name,$surname,$token,$email)
    {
        $message = (new \Swift_Message('Activation de votre compte Nao'));
        $message
            ->setFrom('validation@nao.fr')
            ->setTo($email)
            ->setBody($this->twig->render('validationMail.html.twig', [
                'name'     => $name,
                'surname'  => $surname,
                'token'    => $token,
                'email'    => $email,
                'expireOn' => date('Y-m-d', strtotime('+2 day'))
            ]),
                'text/html');
        return $message;
    }

    /**
     * @param $name
     * @param $surname
     * @param $token
     * @param $email
     * @return \Swift_Message
     */
    public function resetPswdMail($name,$surname,$token,$email)
    {
        $message = (new \Swift_Message('Modification du mot de passe'));
        $message
            ->setFrom('nao@gmail.com')
            ->setTo($email)
            ->setBody($this->twig->render('resetPswdMail.html.twig', [
                'name'    => $name,
                'surname' => $surname,
                'token'   => $token,
                'email'   => $email,
                'expireOn'=> date('Y-m-d', strtotime('+2 day'))
            ]),
                'text/html'
            )
        ;
        return $message;
    }
}
