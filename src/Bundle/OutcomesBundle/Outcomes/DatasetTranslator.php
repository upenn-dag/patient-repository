<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\OutcomesBundle\Outcomes;

use Accard\Bundle\ResourceBundle\ExpressionLanguage\AccardLanguage;

/**
 * Outcomes dataset translator.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DatasetTranslator
{
    /**
     * Accard expression language.
     *
     * @var ExpressionLanguage
     */
    private $exprLanguage;


    /**
     * Construct.
     *
     * @param AccardLanguage $accardLanguage
     */
    public function __construct(AccardLanguage $accardLanguage)
    {
        $this->exprLanguage = $accardLanguage->getExpressionLanguage();
    }

    /**
     * Translate the base dataset.
     *
     * @param BaseDataset $baseDataset
     * @return TransDataset
     */
    public function translate(BaseDataset $baseDataset)
    {
        $config = $baseDataset->getConfiguration();
        $target = $config->getTarget();
        $translations = $config->getTranslations();
        $data = array();

        foreach ($baseDataset->getData() as $datum) {
            $row = array();
            $values = array($target => $datum);
            foreach ($translations as $key => $trans) {
                $row[$key] = $this->exprLanguage->evaluate($trans, $values);
            }

            $data[] = $row;
        }

        return new TransDataset($config, $data);
    }
}
