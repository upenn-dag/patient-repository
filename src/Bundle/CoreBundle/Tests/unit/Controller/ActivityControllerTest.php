<?php
namespace AccardTest\Bundle\CoreBundle\Controller;

/**
 * Activity Controller
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use DAG\Bundle\ResourceBundle\Controller\ActivityController;

class ActivityControllerTest extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        $this->controller = new ActivityController();
    }

    protected function _after()
    {
    }

    // tests
    public function testMe()
    {

    }
}
