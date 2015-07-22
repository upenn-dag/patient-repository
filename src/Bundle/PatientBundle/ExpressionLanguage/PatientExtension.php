<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\PatientBundle\ExpressionLanguage;

use Accard\Component\Patient\Model\PatientInterface;
use DAG\Bundle\ResourceBundle\ExpressionLanguage\ContainerAwareExtension;

/**
 * Patient expression language extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientExtension extends ContainerAwareExtension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            array('patient', array($this, 'compile'), array($this, 'find')),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getValues()
    {
        return array(
            'patient_provider' => $this->container->get('accard.provider.patient'),
        );
    }

    /**
     * Compiles this function to its PHP representation.
     *
     * @param integer|string $patientId
     * @return string
     */
    public function compile($patientId)
    {
        $return = 'try { ';
        if (is_string($patientId)) {
            if (is_numeric($patientId)) {
                $return .= sprintf('$patientProvider->getPatientByMRN(%1$s)', $patientId);
            } else {
                $return .= sprintf('$patientProvider->getPatientByName(%1$s)', $patientId);
            }
        } else {
            $return .= sprintf('$patientProvider->getPatient(%1%d)', $patientId);
        }

        return $return.'; }(\Exception $exception) { null }';
    }

    /**
     * Find patient.
     *
     * @param array $variables
     * @param integer|string $patientId
     * @return PatientInterface
     */
    public function find(array $variables, $patientId)
    {
        $patientProvider = $this->container->get('accard.provider.patient');

        if (is_string($patientId)) {
            if (is_numeric($patientId)) {
                return $patientProvider->getPatientByMRN($patientId);
            } else {
                return $patientProvider->getPatientByName($patientId);
            }
        }

        return $patientProvider->getPatient($patientId);
    }
}
