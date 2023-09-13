<?php

declare(strict_types=1);

namespace App\Entity\Channel;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Channel as BaseChannel;
use Sylius\MultiStorePlugin\BusinessUnits\Domain\Model\BusinessUnitAwareTrait;
use Sylius\MultiStorePlugin\BusinessUnits\Domain\Model\ChannelInterface as BusinessUnitsChannelInterface;
use Sylius\MultiStorePlugin\CustomerPools\Domain\Model\ChannelInterface as CustomerPoolsChannelInterface;
use Sylius\MultiStorePlugin\CustomerPools\Domain\Model\CustomerPoolAwareTrait;
use Sylius\ReturnPlugin\Domain\Model\ChannelInterface as ReturnsChannelInterface;
use Sylius\ReturnPlugin\Domain\Model\ReturnRequestsAllowedAwareTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_channel")
 */
class Channel extends BaseChannel implements BusinessUnitsChannelInterface, CustomerPoolsChannelInterface, ReturnsChannelInterface
{
    use BusinessUnitAwareTrait;
    use CustomerPoolAwareTrait;
    use ReturnRequestsAllowedAwareTrait;
}
