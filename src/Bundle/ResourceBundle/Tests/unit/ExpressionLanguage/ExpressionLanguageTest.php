<?php
namespace AccardTest\Bundle\ResourceBundle\ExpressionLanguage;

/**
 * Expression Language Test
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\ExpressionLanguage\ExpressionLanguage;
use Mockery;

class ExpressionLanguageTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->exprLanguage = new ExpressionLanguage();
    }

    public function testExpressionLanguageAcceptsContainerInterface()
    {
        $container = Mockery::mock('Symfony\Component\DependencyInjection\ContainerInterface');

        $this->assertEmpty($this->exprLanguage->setContainer($container));
    }

    public function testExpressionLanguageRegisterValuesAcceptsArguments()
    {
        $this->assertEmpty($this->exprLanguage->registerValue('NAME', 'VALUE'));
    }

    public function testExpressionLanguageRegisterExtension()
    {
        $extension = Mockery::mock('Accard\Bundle\ResourceBundle\ExpressionLanguage\ExtensionInterface')
            ->shouldReceive('getFunctions')
            ->andReturn(['FUNCTION_0', 'FUNCTION_1', 'FUNCTION_2'])
            ->shouldReceive('getValues')
            ->andReturn(['VALUE_0', 'VALUE_1', 'VALUE_2'])
            ->getMock()
        ;

        $this->assertEmpty($this->exprLanguage->registerExtension($extension));
    }

    public function testExpressionLanguageEvaluateAcceptsCorrectArguments()
    {
        $this->exprLanguage->evaluate(1, []);
    }
}