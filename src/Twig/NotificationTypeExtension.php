<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 13/11/2017
 * Time: 12:04
 */

namespace App\Twig;


class NotificationTypeExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('typeToText',[$this,'notificationFilter'])
        ];
}

    public function notificationFilter($type)
    {
        $list = [
            '1'=>'Vos droits d\'accès ont été modifiés, vous disposez maintenant d\'un compte amateur',
            '2'=>'Félicitations votre compte à été promu, vous disposez à présent d\'un compte naturaliste!',
            '3'=>'Votre demande de compte naturaliste a été acceptée',
            '4'=>'Votre demande de compte naturaliste a été refusée',
            '5'=>'Une de vos observations à été validée et publiée'
        ];

        return $list[$type];

    }
}
