<?php

declare(strict_types=1);

namespace App\Entity\Shipping;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\AdjustmentInterface;
use Sylius\Component\Core\Model\Shipment as BaseShipment;
use Sylius\Component\Core\Model\ShipmentInterface as BaseShipmentInterface;
use Sylius\MultiSourceInventoryPlugin\Domain\Model\InventorySourceAwareTrait;
use Sylius\MultiSourceInventoryPlugin\Domain\Model\ShipmentInterface as InventoryShipmentInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(name="sylius_shipment")
 */
class Shipment extends BaseShipment implements BaseShipmentInterface, InventoryShipmentInterface
{
    use InventorySourceAwareTrait;

    public function __construct()
    {
        parent::__construct();

        /** @var ArrayCollection<array-key, AdjustmentInterface> $this->adjustments */
        $this->adjustments = new ArrayCollection();
    }
}
