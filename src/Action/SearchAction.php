<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 11:44
 */

namespace App\Action;


use App\Responder\SearchResponder;
use App\Services\Search;
use Symfony\Component\HttpFoundation\Request;

class SearchAction
{
    /**
     * @var Search
     */
    private $search;

    /**
     * SearchAction constructor.
     * @param Search $search
     */
    public function __construct(Search $search)
    {
        $this->search = $search;
    }

    /**
     * @param Request $request
     * @param SearchResponder $responder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, SearchResponder $responder)
    {
       $searching = $this->search->processSearch($request);

       return $responder(
           $searching[0],
           $searching[1]
       );
    }
}

