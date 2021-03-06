<?php
namespace Accard\Bundle\RIDICBundle\Import;

/**
 * Local Source Adapter
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use DAG\Bundle\ResourceBundle\Import\SourceAdapterInterface;
use Accard\Component\Activity\Repository\ActivityRepositoryInterface;
use DAG\Component\Prototype\Provider\PrototypeProviderInterface;
use Doctrine\DBAL\Connection;

class LocalSource implements SourceAdapterInterface
{
    /**
     * Prototype Provider
     */
    protected $provider;

    /**
     * Activity repository.
     */
    protected $repository;

    /**
     * Constructor
     */
    public function __construct(
        PrototypeProviderInterface $prototypeProvider,
        ActivityRepositoryInterface $activityRepository
    ) {
        $this->provider = $prototypeProvider;
        $this->repository = $activityRepository;
    }

    /**
     * Execute Command
     */
    public function execute(array $criteria = null)
    {
        $prototype = $this->provider->getPrototypeByName('ridic-dose');
        $activities = $this->repository->findBy(array('prototype' => $prototype));

        $course_servs = [];

        foreach ($activities as $activity) {
            $course_serv = $activity->getFieldByName('ridic-dose-course-serve');

            $course_servs[] = $course_serv;
        }

        return $course_servs;

    }
}
