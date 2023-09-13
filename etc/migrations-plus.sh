#!/bin/bash

echo "Adding executed migrations from RefundPlugin:"

bin/console doctrine:migrations:version "Sylius\PlusRbacPlugin\Infrastructure\Migrations\Version20220812064057" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\LoyaltyPlugin\Infrastructure\Migrations\Version20220712111239" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\ReturnPlugin\Infrastructure\Migrations\Version20220706130632" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\MultiStorePlugin\Migrations\Version20220421115930" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\MultiStorePlugin\Migrations\Version20220531114545" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\MultiStorePlugin\Migrations\Version20220615111754" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\MultiStorePlugin\Migrations\Version20220822130248" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\MultiSourceInventoryPlugin\Migrations\Version20220620064817" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\MultiSourceInventoryPlugin\Migrations\Version20221028091506" --add --no-interaction
