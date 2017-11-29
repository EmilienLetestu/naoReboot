<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 29/11/2017
 * Time: 08:43
 */

namespace App\Twig;


class TitleTypeExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('title',[$this, 'titleFilter'])
        ];
    }

    public function titleFilter($route)
    {
        $title=['login'      => 'CONNEXION',
                'askNewPswd' => 'MOT DE PASSE PERDU',
                'register'   => 'CREER UN COMPTE'
        ];

        return $title[$route];
    }
}