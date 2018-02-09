<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/02/2018
 * Time: 08:14
 */

namespace App\Handler\Interfaces;


use App\Entity\Report;
use Symfony\Component\Form\FormInterface;

Interface ReportHandlerInterface
{
    /**
     * @param FormInterface $form
     * @param Report $report
     * @return bool
     */
    public function handle(FormInterface $form, Report $report) :bool ;
}
