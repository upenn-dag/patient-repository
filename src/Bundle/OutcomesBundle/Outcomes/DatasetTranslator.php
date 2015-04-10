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
     * @param integer|null $limit
     * @return TransDataset
     */
    public function translate(BaseDataset $baseDataset, $limit = null)
    {
        $config = $baseDataset->getConfiguration();
        $target = $config->getTarget();
        $translations = $config->getTranslations();
        $data = array();
        $i = 0;

        foreach ($baseDataset->getData() as $datum) {
            $i++;
            $row = array();
            $values = array("this" => $datum);
            foreach ($translations as $key => $trans) {
                $row[$key] = $this->exprLanguage->evaluate($trans, $values);
            }

            $data[] = $row;

            if ($limit && $i == $limit) {
                break;
            }
        }

        return new TransDataset($config, $data);
    }
}
