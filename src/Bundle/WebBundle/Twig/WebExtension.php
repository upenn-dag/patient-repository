<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\WebBundle\Twig;

use Twig_Extension;
use Twig_SimpleFunction;
use Twig_Environment;
use Accard\Bundle\WebBundle\Templating\Helper\WebHelper;
use Accard\Bundle\ResourceBundle\Search\SearchCollection;
use Accard\Bundle\ResourceBundle\Search\SearchResult;

/**
 * Accard settings Twig extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class WebExtension extends Twig_Extension
{
    private $environment;

    /**
     * {@inheritdoc}
     */
    public function initRuntime(Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('accard_search_results', array($this, 'renderResults'), array('is_safe' => array('html'))),
            new Twig_SimpleFunction('accard_search_result', array($this, 'renderResult'), array('is_safe' => array('html'))),
        );
    }

    public function renderResults(SearchCollection $results, array $options = array())
    {
        $template = isset($options['template']) ? $options['template'] : 'AccardWebBundle:Frontend/Search:results.html.twig';

        return $this->environment->render($template, array(
            'results' => $results,
            'num_results' => count($results),
        ));
    }

    public function renderResult(SearchResult $result, array $options = array())
    {
        $type = $result->getType();
        $template = isset($options['template']) ? $options['template'] : sprintf('AccardWebBundle:Frontend/Search:%s.html.twig', $type);

        return $this->environment->render($template, array(
            'result' => $result,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_web';
    }
}
