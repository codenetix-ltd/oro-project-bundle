<?php

namespace Codenetix\Oro\Bundle\ProjectBundle\Entity;

use Codenetix\Oro\Bundle\ProjectBundle\Model\ExtendProject;
use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareTrait;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\OrganizationBundle\Entity\Ownership\BusinessUnitAwareTrait;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;


/**
 * @author Egor Zyuskin <ezyuskin@codenetix.com>
 * @ORM\Entity(repositoryClass="Codenetix\Oro\Bundle\ProjectBundle\Entity\Repository\ProjectRepository")
 * @ORM\Table(name="codenetix_oro_project")
 * @ORM\HasLifecycleCallbacks()
 * @Config(
 *      routeName="codenetix_oro_project_index",
 *      routeView="codenetix_oro_project_view",
 *      routeCreate="codenetix_oro_project_create",
 *      defaultValues={
 *          "entity"={
 *              "icon"="fa-sticky-note-o"
 *          },
 *          "security"={
 *              "type"="ACL",
 *              "group_name"="",
 *              "category"="catalog"
 *          },
 *          "ownership"={
 *              "owner_type"="BUSINESS_UNIT",
 *              "owner_field_name"="owner",
 *              "owner_column_name"="business_unit_owner_id",
 *              "organization_field_name"="organization",
 *              "organization_column_name"="organization_id"
 *          },
 *          "grid"={
 *              "default"="codenetix-oro-project-grid"
 *          }
 *      }
 * )
 */
class Project extends ExtendProject
{
    use BusinessUnitAwareTrait, DatesAwareTrait;

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="brief", type="string", length=100, nullable=false, unique=true)
     */
    private $brief;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max="255", min="3")
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->getName();
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime('now', new \DateTimeZone('UTC'));
        $this->updatedAt = $this->createdAt;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime('now', new \DateTimeZone('UTC'));
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getBrief()
    {
        return $this->brief;
    }

    /**
     * @param string $brief
     *
     * @return $this
     */
    public function setBrief(string $brief)
    {
        $this->brief = $brief;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }
}
