<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 08/11/2017
 * Time: 16:13
 */

namespace App\Twig;


class AccountTypeExtension extends \Twig_Extension
{

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('account',[$this, 'accountTypeFilter'])
        ];
    }

    /**
     * @param $accessLevel
     * @return mixed
     */
    public function AccountTypeFilter($accessLevel)
    {
        $account = [
            '1'=>'Amateur',
            '2'=>'Naturaliste',
            '3'=>'Administrateur'
        ];

        return $account[$accessLevel];
    }
}