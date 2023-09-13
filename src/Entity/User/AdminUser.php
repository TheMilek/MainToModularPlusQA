<?php

declare(strict_types=1);

namespace App\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Channel\Model\ChannelAwareInterface;
use Sylius\Component\Core\Model\AdminUser as BaseAdminUser;
use Sylius\MultiStorePlugin\ChannelAdmin\Domain\Model\AdminChannelAwareTrait;
use Sylius\MultiStorePlugin\ChannelAdmin\Domain\Model\LastLoginIpAwareInterface;
use Sylius\MultiStorePlugin\ChannelAdmin\Domain\Model\LastLoginIpAwareTrait;
use Sylius\PlusRbacPlugin\Domain\Model\AdminUserInterface as PlusRbacAdminUserInterface;
use Sylius\PlusRbacPlugin\Domain\Model\RoleableTrait;
use Sylius\PlusRbacPlugin\Domain\Model\ToggleablePermissionCheckerTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_admin_user")
 */
class AdminUser extends BaseAdminUser implements ChannelAwareInterface, LastLoginIpAwareInterface, PlusRbacAdminUserInterface
{
    use AdminChannelAwareTrait;
    use LastLoginIpAwareTrait;
    use ToggleablePermissionCheckerTrait;
    use RoleableTrait;

    public function __construct()
    {
        parent::__construct();

        $this->rolesResources = new ArrayCollection();
    }
}
