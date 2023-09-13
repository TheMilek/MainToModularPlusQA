<?php

declare(strict_types=1);

namespace App\Entity\Customer;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Customer as BaseCustomer;
use Sylius\LoyaltyPlugin\Domain\Model\CustomerInterface as LoyaltyCustomerInterface;
use Sylius\LoyaltyPlugin\Domain\Model\LoyaltyAwareTrait;
use Sylius\MultiStorePlugin\CustomerPools\Domain\Model\CustomerInterface as CustomerPoolsCustomerInterface;
use Sylius\MultiStorePlugin\CustomerPools\Domain\Model\CustomerPoolAwareTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_customer")
 */
class Customer extends BaseCustomer implements CustomerPoolsCustomerInterface, LoyaltyCustomerInterface
{
    use CustomerPoolAwareTrait;
    use LoyaltyAwareTrait;
}
