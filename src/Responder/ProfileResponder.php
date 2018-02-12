<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 17:08
 */

namespace App\Responder;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ProfileResponder
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * ProfileResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }


    public function __invoke($accountInfo, $lastInfo, $reportList, $reportInfo)
    {
       return new Response(
           $this->twig->render('nao\profile.html.twig',[
               'accountInfo' => $accountInfo,
               'lastInfo'    => $lastInfo,
               'reportList'  => $reportList,
               'reportInfo'  => $reportInfo
           ])
       );
    }
}
