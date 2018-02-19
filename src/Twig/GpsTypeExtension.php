<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 19/02/2018
 * Time: 12:54
 */

namespace App\Twig;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class GpsTypeExtension extends \Twig_Extension
{
    private $authCheck;


    /**
     * GpsTypeExtension constructor.
     * @param AuthorizationCheckerInterface $authCheck
     */
    public function __construct(AuthorizationCheckerInterface $authCheck)
    {
        $this->authCheck = $authCheck;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('gps',[$this,'gpsFilter'])
        ];
    }

    /**
     * @param $latLng
     * @return string
     */
    public function gpsFilter($latLng)
    {
       return $this->authCheck->isGranted('ROLE_USER') === true ?
            $latLng : '*******************'
        ;
    }
}
