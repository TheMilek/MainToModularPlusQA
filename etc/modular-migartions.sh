#!/bin/bash

echo "Adding executed migrations from LoyaltyPlugin:"

bin/console doctrine:migrations:version "Sylius\LoyaltyPlugin\Infrastructure\Migrations\Version20220712111239" --add --no-interaction

bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200603132754" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200604060510" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200605081658" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200605143716" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200610131835" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200624071028" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200702111344" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200706081938" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200709113414" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200717100403" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200721091904" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20220629142907" --delete --no-interaction

echo "Adding executed migrations from MultiSourceInventoryPlugin:"

bin/console doctrine:migrations:version "Sylius\MultiSourceInventoryPlugin\Migrations\Version20221028091506" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\MultiSourceInventoryPlugin\Migrations\Version20220620064817" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\MultiSourceInventoryPlugin\Migrations\Version20220623092256" --add --no-interaction

bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190820081741" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190716094122" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190708063521" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190703082943" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190626114113" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190618140526" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190614053321" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190612071911" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190721202831" --delete --no-interaction

echo "Adding executed migrations from MultiStorePlugin:"

bin/console doctrine:migrations:version "Sylius\MultiStorePlugin\Migrations\Version20220421115930" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\MultiStorePlugin\Migrations\Version20220531114545" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\MultiStorePlugin\Migrations\Version20220615111754" --add --no-interaction
bin/console doctrine:migrations:version "Sylius\MultiStorePlugin\Migrations\Version20220822130248" --add --no-interaction

# BusinessUnits
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190527083430" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190528145126" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190611134621" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200110100230" --delete --no-interaction

# ChannelAdmin
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190523123403" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200225100818" --delete --no-interaction

# CustomerPools
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190522121616" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190529114722" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190703102638" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190903140026" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20191008132753" --delete --no-interaction

echo "Adding executed migrations from PlusRbacPlugin:"

bin/console doctrine:migrations:version "Sylius\PlusRbacPlugin\Infrastructure\Migrations\Version20220812064057" --add --no-interaction

bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20191122134157" --delete --no-interaction

echo "Adding executed migrations from LoyaltyPlugin:"

bin/console doctrine:migrations:version "Sylius\LoyaltyPlugin\Infrastructure\Migrations\Version20220712111239" --add --no-interaction

bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200603132754" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200604060510" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200605081658" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200605143716" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200610131835" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200624071028" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200702111344" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200706081938" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200709113414" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200717100403" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20200721091904" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20220629142907" --delete --no-interaction

echo "Adding executed migrations from ReturnPlugin:"

bin/console doctrine:migrations:version "Sylius\ReturnPlugin\Infrastructure\Migrations\Version20220706130632" --add --no-interaction

bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190528133204" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190530125013" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190531075459" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190606081129" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190610065804" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190617085652" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190630194127" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190709053542" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190710085620" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190712044155" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190807074644" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190822133242" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190828100430" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190904131604" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20190918065512" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20191002141932" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20191008115437" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20191216131849" --delete --no-interaction
bin/console doctrine:migrations:version "Sylius\Plus\Migrations\Version20220620110234" --delete --no-interaction
