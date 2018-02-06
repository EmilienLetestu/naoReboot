<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 10:41
 */

namespace App\Responder;




use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class AdminHomeResponder
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * AdminHomeResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param int $min
     * @param int $max
     * @param array $homeImg
     * @param FormView $form
     * @param string $title
     * @return Response
     */
    public function __invoke(int $min, int $max, array $homeImg, FormView $form, string $title)
    {
        return new Response(
            $this->twig->render('admin\admin.html.twig',[
                'minLevel' => $min,
                'maxLevel' => $max,
                'homeImg'  => $homeImg,
                'form'     => $form,
                'title'    => $title
            ])
        );
    }
}