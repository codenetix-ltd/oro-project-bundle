<?php

namespace Codenetix\Oro\Bundle\ProjectBundle\Controller;

use Codenetix\Oro\Bundle\ProjectBundle\Entity\Project;
use Codenetix\Oro\Bundle\ProjectBundle\Form\Handler\ProjectHandler;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author Egor Zyuskin <ezyuskin@codenetix.com>
 *
 * @Route("project")
 */
class ProjectController extends Controller
{
    /**
     * @Route(
     *      "/{_format}",
     *      name="codenetix_oro_project_index",
     *      requirements={"_format"="html|json"},
     *      defaults={"_format" = "html"}
     * )
     * @AclAncestor("codenetix_oro_project_view")
     * @Template
     * @return array
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/view/{id}", name="codenetix_oro_project_view", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     *      id="codenetix_oro_project_view",
     *      type="entity",
     *      class="CodenetixOroProjectBundle:Project",
     *      permission="VIEW"
     * )
     * @param Project $entity
     * @return array
     */
    public function viewAction(Project $entity)
    {
        return [
            'entity' => $entity,
            'entityClass' => Project::class,
        ];
    }

    /**
     * @Route("/widget/info/{id}", name="codenetix_oro_project_widget_info", requirements={"id"="\d+"})
     * @Template("CodenetixOroProjectBundle:Project/widget:info.html.twig")
     * @AclAncestor("codenetix_oro_project_view")
     * @param Project $entity
     * @return array
     */
    public function infoAction(Project $entity)
    {
        return [
            'entity' => $entity,
        ];
    }

    /**
     * @Route("/create", name="codenetix_oro_project_create")
     * @Template("CodenetixOroProjectBundle:Project:update.html.twig")
     * @Acl(
     *      id="codenetix_oro_project_create",
     *      type="entity",
     *      class="CodenetixOroProjectBundle:Project",
     *      permission="CREATE"
     * )
     * @return array
     */
    public function createAction()
    {
        return $this->update(new Project());
    }

    /**
     * @Route("/update/{id}", name="codenetix_oro_project_update", requirements={"id"="\d+"}, defaults={"id"=0})
     * @Template
     * @Acl(
     *      id="codenetix_oro_project_update",
     *      type="entity",
     *      class="CodenetixOroProjectBundle:Project",
     *      permission="EDIT"
     * )
     * @param Project $entity
     * @return array
     */
    public function updateAction(Project $entity)
    {
        return $this->update($entity);
    }

    /**
     * @param Project $entity
     * @return array
     */
    protected function update(Project $entity)
    {
        if ($this->get(ProjectHandler::class)->process($entity)) {
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('oro.business_unit.controller.message.saved') //TODO:change this
            );

            return $this->get('oro_ui.router')->redirect($entity);
        }

        return [
            'entity' => $entity,
            'entityClass' => Project::class,
            'form' => $this->get('codenetix_oro_project.form.project')->createView(),
        ];
    }
}
