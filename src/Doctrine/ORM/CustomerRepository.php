<?php

declare(strict_types=1);

namespace App\Doctrine\ORM;

use Sylius\Bundle\CoreBundle\Doctrine\ORM\CustomerRepository as BaseCustomerRepository;
use Sylius\MultiStorePlugin\ChannelAdmin\Infrastructure\Doctrine\ORM\FindLatestCustomersQueryTrait;

class CustomerRepository extends BaseCustomerRepository
{
    use FindLatestCustomersQueryTrait;
}
