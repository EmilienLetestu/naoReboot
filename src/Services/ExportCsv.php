<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 27/11/2017
 * Time: 14:15
 */

namespace App\Services;



use Symfony\Component\Serializer\Serializer;

class ExportCsv
{
    private $serializer;

    public function __construct(Serializer $serializer)
    {
    }
}