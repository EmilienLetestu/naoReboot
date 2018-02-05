<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 10:53
 */

namespace App\Action;


use App\Responder\BrowseReportResponder;
use App\Services\BrowserFilter;
use Symfony\Component\HttpFoundation\Request;

class BrowseReportAction
{
    /**
     * @var BrowserFilter
     */
    private $browserFilter;

    /**
     * BrowseReportAction constructor.
     * @param BrowserFilter $browserFilter
     */
    public function __construct(BrowserFilter $browserFilter)
    {
        $this->browserFilter = $browserFilter;
    }

    /**
     * @param Request $request
     * @param BrowseReportResponder $responder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, BrowseReportResponder $responder)
    {
      $filters = $this->browserFilter->processFilter($request);

      return $responder(
          $filters[0],
          $filters[1],
          $filters[2],
          $filters[3]
      );
    }
}