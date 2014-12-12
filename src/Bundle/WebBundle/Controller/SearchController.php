<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Accard\Bundle\ResourceBundle\Search\SearchCollection;
use Elastica\Query\QueryString;
use Elastica\Exception\Connection\HttpException;

class SearchController extends Controller
{
    public function searchAction(Request $request)
    {
        $queryRaw = $request->query->get('q');

        if (!$queryRaw) {
            throw $this->createNotFoundException('No query provided.');
        }

        $query = new QueryString($queryRaw);
        $query->setDefaultOperator('AND');

        try {
            $finder = $this->get('fos_elastica.finder.accard');
            $result = $finder->findHybrid($query, 25);
            $results = new SearchCollection($query, $result);
            $down = false;
        } catch (HttpException $e) {
            $queryRaw = 'Search is down';
            $results = new SearchCollection($query, array());
            $down = true;
        }

        return $this->render('AccardWebBundle:Frontend:search.html.twig', array(
            'last_search' => $queryRaw,
            'results' => $results,
            'search_down' => $down,
        ));
    }
}
