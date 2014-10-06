<?php
    /**
    * This file is part of the Accard package.
    *
    * (c) University of Pennsylvania
    *
    * For the full copyright and license information, please view the
    * LICENSE file that was distributed with this source code.
    */
     
    namespace Accard\Bundle\CoreBundle\DataFixtures\ORM;
     
    use Accard\Bundle\CoreBundle\DataFixtures\AccardFixture;
    use Doctrine\Common\Persistence\ObjectManager;
     
    /**
    * Load cytogenetics activity prototype data.
    *
    * @author Vasu Renganathan <vasur@mail.med.upenn.edu>
    */
     
    class CytogeneticsFixture extends AccardFixture
    {
    /**
    * {@inheritDoc}
    */
    public function doLoad()
    {
    $fm = $this->fixtureManager;
    $surgery = $fm->createPrototype('activity', 'cytogenetics');
     
    $cytogenetics
    ->createField('activity-date', 'Activity date', 'date')
    ->end()
    
    ->createField('evaluated', 'Evaluated', 'checkbox')
    ->end()

    ->createField('result', 'Result', 'choice')
    ->createOption('result', 'result')
    ->addOptionValue('No abnormality noted')
    ->addOptionValue('Abnormality noted')
    ->addOptionValue('Unevaluable')
    ->end()
    ->end()
     
    ->createField('risk-assessment', 'Risk assessment', 'choice')
    ->createOption('risk-assessment', 'Risk assessment')
    ->addOptionValue('Low')
    ->addOptionValue('Intermediate')
    ->addOptionValue('High')
    ->addOptionValue('Unevaluable')
    ->addOptionValue('Indeterminate')
    ->end()
    ->end()
     
    ->createField('high-risk-abnormalities', 'High risk abnormalities', 'choice')
    ->createOption('high-risk-abnormalities', 'High risk abnormalities')
    ->addOptionValue('del(5q)/-5')
    ->addOptionValue('del(7q)/-7')
    ->addOptionValue('abn3q26[inv(3)/t(3;3)]')
    ->addOptionValue('11q23 [MLL rearrangement, except t(9;11)]')
    ->addOptionValue('17p deletion or i(17q)')
    ->addOptionValue('other abn17p')
    ->addOptionValue('t(6;9)')
    ->addOptionValue('t(9;22)')
    ->addOptionValue('complex (>=3 unrelated abn)')
    ->addOptionValue('monosomal karyotype')
    ->addOptionValue('loss of two independent chromosomes')
    ->addOptionValue('loss of one chromosome with a structured abnormality other than add, mar and ring')
    ->addOptionValue('Other')
    ->end()
    ->end()
   ->persist();
     
    $fm->objectManager->flush();
     
    }
    }

