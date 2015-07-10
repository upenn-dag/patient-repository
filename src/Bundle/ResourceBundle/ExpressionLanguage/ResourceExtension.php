<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\ExpressionLanguage;

use Closure;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Accard\Bundle\ResourceBundle\Exception\UnexpectedTypeException;
use Accard\Component\Field\Model\FieldSubjectInterface;

/**
 * Resource expression language extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ResourceExtension extends ContainerAwareExtension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            // String functions
            $this->createStringFunctionArray('encrypt', 'crypt'),
            $this->createStringFunctionArray('hash', 'md5'),
            $this->createStringFunctionArray('lower', 'strtolower'),
            $this->createStringFunctionArray('lower_first', 'lcfirst'),
            $this->createStringFunctionArray('trim', 'trim'),
            $this->createStringFunctionArray('upper', 'strtoupper'),
            $this->createStringFunctionArray('upper_first', 'ucfirst'),
            $this->createStringFunctionArray('upper_words', 'ucwords'),

            // Integer functions
            $this->createIntegerFunctionArray('abs', 'abs'),
            $this->createIntegerFunctionArray('acos', 'acos'),
            $this->createIntegerFunctionArray('asin', 'asin'),
            $this->createIntegerFunctionArray('atan', 'atan'),
            $this->createIntegerFunctionArray('ceil', 'ceil'),
            $this->createIntegerFunctionArray('cos', 'cos'),
            $this->createIntegerFunctionArray('exp', 'exp'),
            $this->createIntegerFunctionArray('floor', 'floor'),
            $this->createIntegerFunctionArray('pow', 'pow'),
            $this->createIntegerFunctionArray('round', 'round'),
            $this->createIntegerFunctionArray('sin', 'sin'),
            $this->createIntegerFunctionArray('sqrt', 'sqrt'),
            $this->createIntegerFunctionArray('tan', 'tan'),

            // Integer array functions
            $this->createArrayFunctionArray('average', '\Accard\Bundle\ResourceBundle\ExpressionLanguage\accard_average'),
            $this->createArrayFunctionArray('max', 'max'),
            $this->createArrayFunctionArray('mean', '\Accard\Bundle\ResourceBundle\ExpressionLanguage\accard_average'),
            $this->createArrayFunctionArray('median', '\Accard\Bundle\ResourceBundle\ExpressionLanguage\accard_median'),
            $this->createArrayFunctionArray('min', 'min'),
            $this->createArrayFunctionArray('standard_deviation', '\Accard\Bundle\ResourceBundle\ExpressionLanguage\accard_standard_deviation'),
            $this->createArrayFunctionArray('sum', 'array_sum'),
            $this->createArrayFunctionArray('variance', '\Accard\Bundle\ResourceBundle\ExpressionLanguage\accard_variance'),

            // Array functions
            $this->createArrayFunctionArray('count', 'count'),
            $this->createArrayFunctionArray('keys', 'array_keys'),
            $this->createArrayFunctionArray('pop', 'array_pop'),
            $this->createArrayFunctionArray('reverse', 'array_reverse'),
            $this->createArrayFunctionArray('shift', 'array_shift'),
            $this->createArrayFunctionArray('slice', '\Accard\Bundle\ResourceBundle\ExpressionLanguage\accard_slice'),
            $this->createArrayFunctionArray('values', 'array_values'),
            $this->createArrayFunctionArray('join', 'implode'),
            $this->createArrayFunctionArray('split', 'explode'),

            // Date functions, always work on clone to avoid reference changing date.
            array(
                'date',
                function(DateTime $date = null, $format = 'm/d/Y') {
                    $date = $date ? clone $date : new DateTime();

                    return sprintf('(is_integer(%1$d)) ? date(%1%d) : %1$d', $date->getTimestamp());
                },
                function(array $variables, DateTime $date = null, $format = 'm/d/Y') {
                    $date = $date ? clone $date: new DateTime();

                    return $date->format($format);
                }
            ),

            // Accard functions
            array(
                'field',
                function($object, $field) {
                    return sprintf('($object instanceof \Accard\Component\Field\Model\FieldSubjectInterface && $object->hasFieldByName(%1%s)) ? $object->getField(%1$s) : null', $field);
                },
                function(array $variables, $object, $field) {
                    if (!$object instanceof FieldSubjectInterface) {
                        throw new \InvalidArgumentException('Object passed to field() expression language function must implement FieldSubjectInterface.');
                    }

                    if ($object->hasFieldByName($field)) {
                        $field = $object->getFieldByName($field);

                        return $field->getValue();
                    }

                    return '';
                }
            ),

            array(
                'field_object',
                function($object, $field) {
                    return sprintf('($object instanceof \Accard\Component\Field\Model\FieldSubjectInterface && $object->hasFieldByName(%1%s)) ? $object->getField(%1$s) : null', $field);
                },
                function(array $variables, $object, $field) {
                    if (!$object instanceof FieldSubjectInterface) {
                        throw new \InvalidArgumentException('Object passed to field() expression language function must implement FieldSubjectInterface.');
                    }

                    if ($object->hasFieldByName($field)) {
                        return $object->getFieldByName($field);
                    }
                }
            ),
        );
    }

    /**
     * Creates a string function array.
     *
     * @param string $name
     * @param string $function
     * @return array
     */
    private function createStringFunctionArray($name, $function)
    {
        return array($name, $this->createStringCompiler($function), $this->createStringEvaluator($function));
    }

    /**
     * Creates a closure to execute a PHP function compiler on a string.
     *
     * @param string $function
     * @return Closure
     */
    private function createStringCompiler($function)
    {
        return function($str) use ($function) {
            return sprintf('(is_string(%1$s)) ? '.$function.'(%1$s) : %1$s', $str);
        };
    }

    /**
     * Creates a closure to execute a PHP function evaluator on a string.
     *
     * @param string $function
     * @return Closure
     */
    private function createStringEvaluator($function)
    {
        return function(array $variables, $str) use ($function) {
            if (!is_string($str)) {
                return $str;
            }

            $args = array_slice(func_get_args(), 1);

            if (count($args) > 0) {
                return call_user_func_array($function, $args);
            }

            return $function($str);
        };
    }

    /**
     * Creates an integer function array.
     *
     * @param string $name
     * @param string $function
     * @return array
     */
    private function createIntegerFunctionArray($name, $function)
    {
        return array($name, $this->createIntegerCompiler($function), $this->createIntegerEvaluator($function));
    }

    /**
     * Creates a closure to exectute a PHP function compiler on an integer.
     *
     * @param string $function
     * @return Closure
     */
    private function createIntegerCompiler($function)
    {
        return function($int) use ($function) {
            return sprintf('(is_integer(%1$d) || is_float(%1$d)) ? '.$function.'(%1$d) : %1$d', $str);
        };
    }

    /**
     * Creates a closure to execute a PHP function evaluator on a integer.
     *
     * @param string $function
     * @return Closure
     */
    private function createIntegerEvaluator($function)
    {
        return function(array $variables, $int) use ($function) {
            if (!is_integer($int) && !is_float($int)) {
                return $int;
            }

            $args = array_slice(func_get_args(), 1);

            if (count($args) > 0) {
                return call_user_func_array($function, $args);
            }

            return $function($int);
        };
    }

    /**
     * Creates an array function array.
     *
     * @param string $name
     * @param string $function
     * @return array
     */
    private function createArrayFunctionArray($name, $function)
    {
        return array($name, $this->createArrayCompiler($function), $this->createArrayEvaluator($function));
    }

    /**
     * Creates a closure to exectute a PHP function compiler on an array.
     *
     * @param string $function
     * @return Closure
     */
    private function createArrayCompiler($function)
    {
        return function($array) use ($function) {
            return sprintf('(is_array(%1$d)) ? '.$function.'(%1$d) : %1$d', $function);
        };
    }

    /**
     * Creates a closure to execute a PHP function evaluator on a array.
     *
     * @param string $function
     * @return Closure
     */
    private function createArrayEvaluator($function)
    {
        return function(array $variables, $array) use ($function) {
            if (!is_array($array) && !$array instanceof Collection) {
                return $array;
            }

            $args = array_slice(func_get_args(), 1);

            if (count($args) > 0) {
                return call_user_func_array($function, $args);
            }

            return $function($array);
        };
    }
}

/*
 * Define some functions that don't exist in php.
 */
if (!defined('ACCARD_RESOURCE_EXTENSION_LOADED')) {

    define('ACCARD_RESOURCE_EXTENSION_LOADED', true);

    function accard_average(array $array) {
        return array_sum($array)/count($array);
    }

    function accard_median(array $array) {
        if (!$count = count($array)) {
            return 0;
        }

        sort($array);
        $middleVal = floor(($count-1)/2);
        if ($count % 2) {
            $median = $array[$middleVal];
        } else {
            $low = $array[$middleVal];
            $high = $array[$middleVal+1];
            $median = (($low+$high)/2);
        }

        return $median;
    }

    function accard_variance(array $array) {
        if (!$count = count($array)) {
            return 0;
        }

        $mean = accard_average($array);
        $sumOfSquares = 0;
        for ($i = 0; $i < $count; $i++) {
            $sumOfSquares += ($array[$i] - $mean) * ($array[$i] - $mean);
        }

        return $sumOfSquares/($count-1);
    }

    function accard_standard_deviation(array $array){
        if (!$count = count($array)) {
            return 0;
        }

        $deviations = array();
        $mean = accard_average($array);
        foreach ($array as $key => $value) {
            $deviations[$key] = pow($value - $mean, 2);
        }

        return sqrt(array_sum($deviations)/(count($deviations)-1));
    }

    function accard_slice($array, $offset, $length = null, $preserveKeys = false) {
        if (is_array($array)) {
            return array_slice($array, $offset, $length, $preserveKeys);
        } elseif ($array instanceof Collection) {
            return $array->slice($offset, $length);
        }

        throw new UnexpectedTypeException($array, 'array or Collection');
    }
}
