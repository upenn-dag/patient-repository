<?php
namespace AccardTest\Bundle\ResourceBundle\Controller;

/**
 * Parameters Parser Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Controller\ParametersParser;
use Symfony\Component\HttpFoundation\Request;
use Mockery;
use Accard\Bundle\ResourceBundle\Test\Stub\Stub;

class ParametersParserTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->expression = Mockery::mock('Accard\Bundle\ResourceBundle\ExpressionLanguage\ExpressionLanguage');

        $this->parametersParser = new ParametersParser($this->expression);

        $this->resource = new Stub();
    }

    protected function _after()
    {
    }

    public function testParametersParserParseRecursivelyParsesArrays()
    {
        $request = Mockery::mock('Symfony\Component\HttpFoundation\Request')
            ->shouldReceive('get')
            ->with('TEST_VALUE')
            ->andReturn('REQUEST_PARAM')
            ->getMock()
        ;

        $parameters = ['TEST' => ['TEST_KEY' => '$TEST_VALUE']];

        $parsed = $this->parametersParser->parse($parameters, $request);

        $this->assertSame(['TEST' => ['TEST_KEY' => 'REQUEST_PARAM']], $parsed);
    }

    public function testParametersParserRemovesDollarSignsInStringsAndRetrievesValueFromRequest()
    {
        $request = Mockery::mock('Symfony\Component\HttpFoundation\Request')
            ->shouldReceive('get')
            ->with('TEST_KEY')
            ->andReturn('REQUEST_PARAM')
            ->getMock()
        ;

        $parameters = ['TEST' => '$TEST_KEY'];

        $parsed = $this->parametersParser->parse($parameters, $request);

        $this->assertSame(['TEST' => 'REQUEST_PARAM'], $parsed);
    }

    public function testParametersParserAndFindsExpressionTagAtBeginningOfStringAndAssignsExpressionEvaluationToParameters()
    {
        $request = Mockery::mock('Symfony\Component\HttpFoundation\Request');

        $this->expression
            ->shouldReceive('evaluate')
            ->with('TEST_KEY')
            ->andReturn('EXPRESSION_EVAL')
        ;

        $parameters = ['TEST' => 'expr:TEST_KEY'];

        $parsed = $this->parametersParser->parse($parameters, $request);

        $this->assertSame(['TEST' => 'EXPRESSION_EVAL'], $parsed);
    
    }

    public function testParametersParserProcessesResourceIdWhenNoParametersSet()
    {
        $parameters = array();

        $this->assertSame(
            ['id' => 1],
            $this->parametersParser->process($parameters, $this->resource)
        );
    }

    public function testParametersParserProcessesFlatParametersWithResourceStringsCorrectly()
    {
        $parameters = [
            'KEY' => 'resource.id'
        ];

        $processed = $this->parametersParser->process($parameters, $this->resource);

        $this->assertSame(['KEY' => 1], $processed);
    }

    public function testParametersPraserProcessesMultiDimensionalParametersRecursively()
    {
        $parameters = [
            'TEST' => ['TEST_KEY' => 'resource.id'],
        ];

        $processed = $this->parametersParser->process($parameters, $this->resource);

        $this->assertSame(['TEST' => ['TEST_KEY' => 1]], $processed);
    }

}