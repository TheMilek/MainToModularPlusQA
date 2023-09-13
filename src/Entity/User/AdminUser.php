<?php

declare(strict_types=1);

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Channel\Model\ChannelAwareInterface;
use Sylius\Component\Core\Model\AdminUser as BaseAdminUser;
use Sylius\MultiStorePlugin\ChannelAdmin\Domain\Model\AdminChannelAwareTrait;
use Sylius\MultiStorePlugin\ChannelAdmin\Domain\Model\LastLoginIpAwareInterface;
use Sylius\MultiStorePlugin\ChannelAdmin\Domain\Model\LastLoginIpAwareTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_admin_user")
 */
class AdminUser extends BaseAdminUser implements ChannelAwareInterface, LastLoginIpAwareInterface
{
    use AdminChannelAwareTrait;
    use LastLoginIpAwareTrait;

    public function __construct()
    {
        parent::__construct();

    }
}
