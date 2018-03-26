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
            '1'=>'Votre niveau de privilège a changé, vous disposez maintenant d\'un compte amateur',
            '2'=>'Félicitations votre compte à été promu, vous disposez à présent d\'un compte naturalitse!',
            '3'=>'Votre demande de compte naturaliste à été accepté',
            '4'=>'Votre demande de compte naturaliste à été refusé']
            ;

            return $list[$type];

    }
}
