<?php

declare(strict_types=1);

namespace App\Doctrine\ORM;

use Sylius\Bundle\CoreBundle\Doctrine\ORM\PaymentRepository as BasePaymentRepository;
use Sylius\MultiStorePlugin\ChannelAdmin\Infrastructure\Doctrine\ORM\CreatePaymentListQueryBuilderTrait;

class PaymentRepository extends BasePaymentRepository
{
    use CreatePaymentListQueryBuilderTrait;
}
