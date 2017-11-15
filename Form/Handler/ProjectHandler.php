<?php

namespace Codenetix\Oro\Bundle\ProjectBundle\Form\Handler;

use Codenetix\Oro\Bundle\ProjectBundle\Entity\Project;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Egor Zyuskin <ezyuskin@codenetix.com>
 */
class ProjectHandler
{
    /**
     * @param FormInterface $form
     * @param Request       $request
     * @param ObjectManager $manager
     */
    public function __construct(FormInterface $form, Request $request, ObjectManager $manager)
    {
        $this->form    = $form;
        $this->request = $request;
        $this->manager = $manager;
    }

    /**
     * Process form
     *
     * @param  Project $entity
     * @return bool
     */
    public function process(Project $entity)
    {
        $this->form->setData($entity);

        if (in_array($this->request->getMethod(), [Request::METHOD_POST, Request::METHOD_PUT])) {
            $this->form->submit($this->request);

            if ($this->form->isValid()) {
                $this->manager->persist($entity);
                $this->manager->flush();

                return true;
            }
        }

        return false;
    }
}
