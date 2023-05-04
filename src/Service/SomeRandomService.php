<?php

namespace App\Service;

use Sylius\Bundle\ApiBundle\Command\CustomerEmailAwareInterface;
use Sylius\Bundle\ApiBundle\CommandHandler\Account\SendAccountRegistrationEmailHandler;
use Sylius\Bundle\ApiBundle\CommandHandler\Account\SendAccountVerificationEmailHandler;
use Sylius\Bundle\CoreBundle\Resolver\CustomerResolverInterface;
use Sylius\Bundle\CoreBundle\Validator\Constraints\CartItemAvailabilityValidator;
use Sylius\Bundle\CoreBundle\Validator\Constraints\RegisteredUserValidator;
use Sylius\Component\Inventory\Checker\AvailabilityCheckerInterface;
use Sylius\Plus\BusinessUnits\Domain\Model\BusinessUnit;
use Sylius\Plus\BusinessUnits\Infrastructure\Fixture\Factory\BusinessUnitAddressExampleFactory;
use Sylius\Plus\BusinessUnits\Infrastructure\Fixture\Factory\BusinessUnitExampleFactory;
use Sylius\Plus\ChannelAdmin\Application\Checker\ChannelAwareResourceChannelChecker;
use Sylius\Plus\ChannelAdmin\Application\Checker\ResourceChannelChecker;
use Sylius\Plus\ChannelAdmin\Application\Factory\ChannelRestrictingNewResourceFactory;
use Sylius\Plus\ChannelAdmin\Application\Provider\AvailableChannelsForAdminProvider;
use Sylius\Plus\ChannelAdmin\Infrastructure\Doctrine\ORM\ChannelRestrictingProductListQueryBuilderInterface;
use Sylius\Plus\ChannelAdmin\Infrastructure\Doctrine\ORM\FindProductsByChannelAndPhraseQueryInterface;
use Sylius\Plus\Checker\CreditMemoResourceChannelChecker;
use Sylius\Plus\Controller\DashboardController;
use Sylius\Plus\Converter\IriToIdentifierConverter;
use Sylius\Plus\CustomerPools\Application\Checker\CustomerResourceChannelChecker;
use Sylius\Plus\CustomerPools\Application\Context\CustomerPoolContextInterface;
use Sylius\Plus\CustomerPools\Infrastructure\Provider\CustomerByEmailAndCustomerPoolProvider;
use Sylius\Plus\CustomerPools\Infrastructure\Provider\UsernameAndCustomerPoolProvider;
use Sylius\Plus\CustomerPools\Infrastructure\Resolver\CustomerByEmailAndCustomerPoolResolver;
use Sylius\Plus\CustomerPools\Infrastructure\Validator\CustomerClassMetadataLoader;
use Sylius\Plus\Doctrine\ORM\CountCustomersQueryInterface;
use Sylius\Plus\Doctrine\ORM\ShipmentRepository;
use Sylius\Plus\Factory\InvoiceShopBillingDataFactoryInterface;
use Sylius\Plus\Factory\VariantsQuantityMapFactory;
use Sylius\Plus\Factory\VariantsQuantityMapFactoryInterface;
use Sylius\Plus\Installer\Provider\ChannelProviderInterface;
use Sylius\Plus\Installer\Provider\CustomerPoolProviderInterface;
use Sylius\Plus\Inventory\Application\Applier\InventorySourceStockApplierInterface;
use Sylius\Plus\Inventory\Application\Assigner\ShipmentInventorySourceAssignerInterface;
use Sylius\Plus\Inventory\Application\Checker\IsStockSufficientCheckerInterface;
use Sylius\Plus\Inventory\Application\Checker\VariantAvailabilityCheckerInterface;
use Sylius\Plus\Inventory\Application\Checker\VariantQuantityMapAvailabilityCheckerInterface;
use Sylius\Plus\Inventory\Application\Command\ModifyInventorySourceStock;
use Sylius\Plus\Inventory\Application\CommandHandler\ModifyInventorySourceStockHandler;
use Sylius\Plus\Inventory\Application\DataPersister\InventorySourceDataPersister;
use Sylius\Plus\Inventory\Application\Factory\InventorySourceFactoryInterface;
use Sylius\Plus\Inventory\Application\Filter\InventorySourcesFilterInterface;
use Sylius\Plus\Inventory\Application\Operator\CancelOrderInventoryOperatorInterface;
use Sylius\Plus\Inventory\Application\Operator\ChangeInventorySourceOperatorInterface;
use Sylius\Plus\Inventory\Application\Operator\HoldOrderInventoryOperatorInterface;
use Sylius\Plus\Inventory\Application\Operator\InventoryOperatorInterface;
use Sylius\Plus\Inventory\Application\Operator\ShipmentInventoryOperatorInterface;
use Sylius\Plus\Inventory\Application\Operator\ShipShipmentInventoryOperatorInterface;
use Sylius\Plus\Inventory\Application\Provider\AvailableInventorySourcesProviderInterface;
use Sylius\Plus\Inventory\Application\Provider\InsufficientItemFromOrderItemsProviderInterface;
use Sylius\Plus\Inventory\Application\Resolver\InventorySourceResolverInterface;
use Sylius\Plus\Inventory\Application\Updater\InventorySourceStockUpdaterInterface;
use Sylius\Plus\Inventory\Domain\Exception\InventorySourceStockInUseException;
use Sylius\Plus\Inventory\Domain\Model\InventorySource;
use Sylius\Plus\Inventory\Domain\Model\InventorySourceStock;
use Sylius\Plus\Inventory\Infrastructure\Doctrine\ORM\InventorySourceStockRepositoryInterface;
use Sylius\Plus\Inventory\Infrastructure\Fixture\Factory\InventorySourceExampleFactory;
use Sylius\Plus\Loyalty\Application\Assigner\LoyaltyPointsAssignerInterface;
use Sylius\Plus\Loyalty\Application\Calculator\ActionBasedLoyaltyPointsCalculatorInterface;
use Sylius\Plus\Loyalty\Application\Command\BuyLoyaltyPurchase;
use Sylius\Plus\Loyalty\Application\CommandHandler\BuyLoyaltyPurchaseHandler;
use Sylius\Plus\Loyalty\Application\Factory\LoyaltyRuleActionFactoryInterface;
use Sylius\Plus\Loyalty\Application\Generator\LoyaltyPurchasePromotionCouponInstructionGeneratorInterface;
use Sylius\Plus\Loyalty\Application\Logger\LoyaltyPointsTransactionLoggerInterface;
use Sylius\Plus\Loyalty\Application\Modifier\LoyaltyPointsAccountModifierInterface;
use Sylius\Plus\Loyalty\Application\Provider\OrdersLoyaltyPointsProviderInterface;
use Sylius\Plus\Loyalty\Domain\Model\LoyaltyRuleActionInterface;
use Sylius\Plus\Loyalty\Domain\Model\LoyaltyRuleConfiguration\LoyaltyRuleConfigurationInterface;
use Sylius\Plus\Loyalty\Infrastructure\DataTransformer\LoyaltyRuleActionDataTransformerInterface;
use Sylius\Plus\Loyalty\Infrastructure\Doctrine\ORM\ChannelRestrictingEnabledLoyaltyPurchaseListQueryBuilderInterface;
use Sylius\Plus\PartialShipping\Application\Command\SplitAndSendShipment;
use Sylius\Plus\PartialShipping\Application\Duplicator\AdjustmentDuplicatorInterface;
use Sylius\Plus\PartialShipping\Application\Factory\ShipmentFactoryInterface;
use Sylius\Plus\PartialShipping\Application\Purifier\OrderShipmentPurifierInterface;
use Sylius\Plus\PartialShipping\Infrastructure\Modifier\ShipmentUnitModifierInterface;
use Sylius\Plus\Rbac\Application\Checker\AuthorizationCheckerInterface;
use Sylius\Plus\Rbac\Application\Context\AdminUserContextInterface;
use Sylius\Plus\Rbac\Application\Exception\AccessDeniedHttpException;
use Sylius\Plus\Rbac\Application\Privilege\PrivilegeInterface;
use Sylius\Plus\Rbac\Application\Resolver\AdminPermissionResolverInterface;
use Sylius\Plus\Rbac\Infrastructure\Doctrine\ORM\RoleRepositoryInterface;
use Sylius\Plus\Rbac\Infrastructure\Fixture\Factory\RoleExampleFactory;
use Sylius\Plus\Rbac\Infrastructure\Templating\Helper\AclHelper;
use Sylius\Plus\Returns\Application\Calculator\ReturnRateMetricCalculatorInterface;
use Sylius\Plus\Returns\Application\Checker\OrderItemsAvailabilityCheckerInterface;
use Sylius\Plus\Returns\Application\Checker\ReturnRequestAllUnitsReceivedCheckerInterface;
use Sylius\Plus\Returns\Application\Checker\ReturnRequestAllUnitsReturnedToInventoryCheckerInterface;
use Sylius\Plus\Returns\Application\Checker\ReturnRequestCustomerRelationCheckerInterface;
use Sylius\Plus\Returns\Application\Creator\ReplacementOrderCreatorInterface;
use Sylius\Plus\Returns\Application\Factory\ReturnRequestFactoryInterface;
use Sylius\Plus\Returns\Application\Factory\ReturnRequestUnitFactoryInterface;
use Sylius\Plus\Returns\Application\Generator\ReturnRequestNumberGenerator;
use Sylius\Plus\Returns\Application\Generator\ReturnRequestPdfFileGeneratorInterface;
use Sylius\Plus\Returns\Application\Guard\ReturnRequestGuardInterface;
use Sylius\Plus\Returns\Application\Mapper\ReturnRequestUnitMapperInterface;
use Sylius\Plus\Returns\Application\Operator\ReturnInventoryOperatorInterface;
use Sylius\Plus\Returns\Application\Provider\NonReturnableOrderItemUnitIdsProviderInterface;
use Sylius\Plus\Returns\Application\Provider\ReturnRequestProviderInterface;
use Sylius\Plus\Returns\Application\StateResolver\ReturnRequestItemsReturnedToInventoryStateResolverInterface;
use Sylius\Plus\Returns\Application\StateResolver\ReturnRequestPackageReceivedStateResolverInterface;
use Sylius\Plus\Returns\Domain\Notification\ReturnRequestConfirmationSender;
use Sylius\Plus\Returns\Domain\Provider\ReturnRequestResolutionsProvider;
use Sylius\Plus\Returns\Infrastructure\Checker\CsrfCheckerInterface;
use Sylius\Plus\Returns\Infrastructure\Doctrine\ORM\CountOrderItemUnitsQueryInterface;
use Sylius\Plus\SharedKernel\ResourceChannelCheckerInterface;

class SomeRandomService
{
    public function __construct(
        private BusinessUnitAddressExampleFactory $businessUnitAddressExampleFactory,
        private BusinessUnitExampleFactory $businessUnitExampleFactory,
        private ChannelAwareResourceChannelChecker $channelAwareResourceChannelChecker,
        private ResourceChannelChecker $resourceChannelChecker,
        private ChannelRestrictingNewResourceFactory $channelRestrictingNewResourceFactory,
        private AvailableChannelsForAdminProvider $availableChannelsForAdminProvider,
        private ChannelRestrictingProductListQueryBuilderInterface $channelRestrictingProductListQueryBuilder,
        private FindProductsByChannelAndPhraseQueryInterface $findProductsByChannelAndPhraseQuery,
        private CreditMemoResourceChannelChecker $creditMemoResourceChannelChecker,
        private DashboardController $dashboardController,
        private IriToIdentifierConverter $iriToIdentifierConverter,
        private CustomerResourceChannelChecker $customerResourceChannelChecker,
        private SendAccountRegistrationEmailHandler $sendAccountRegistrationEmailHandler,
        private SendAccountVerificationEmailHandler $sendAccountVerificationEmailHandler,
        private CustomerPoolContextInterface $customerPoolContext,
        private CustomerByEmailAndCustomerPoolProvider $customerByEmailAndCustomerPoolProvider,
        private UsernameAndCustomerPoolProvider $usernameAndCustomerPoolProvider,
        private CustomerResolverInterface $customerByEmailAndCustomerPoolResolver,
        private CustomerClassMetadataLoader $customerClassMetadataLoader,
        private CountCustomersQueryInterface $countCustomersQuery,
        private ShipmentRepository $shipmentRepository,
        private InvoiceShopBillingDataFactoryInterface $invoiceShopBillingDataFactory,
        private VariantsQuantityMapFactoryInterface $variantsQuantityMapFactory,
        private ChannelProviderInterface $channelProvider,
        private CustomerPoolProviderInterface $customerPoolProvider,
        private InventorySourceStockApplierInterface $inventorySourceStockApplier,
        private ShipmentInventorySourceAssignerInterface $shipmentInventorySourceAssigner,
        private AvailabilityCheckerInterface $availabilityChecker,
        private IsStockSufficientCheckerInterface $isStockSufficientChecker,
        private VariantAvailabilityCheckerInterface $variantAvailabilityChecker,
        private VariantQuantityMapAvailabilityCheckerInterface $variantQuantityMapAvailabilityChecker,
        private ModifyInventorySourceStockHandler $modifyInventorySourceStockHandler,
        private InventorySourceDataPersister $inventorySourceDataPersister,
        private InventorySourceFactoryInterface $inventorySourceFactory,
        private InventorySourcesFilterInterface $inventorySourcesFilter,
        private CancelOrderInventoryOperatorInterface $cancelOrderInventoryOperator,
        private ChangeInventorySourceOperatorInterface $changeInventorySourceOperator,
        private HoldOrderInventoryOperatorInterface $holdOrderInventoryOperator,
        private InventoryOperatorInterface $inventoryOperator,
        private ShipmentInventoryOperatorInterface $shipmentInventoryOperator,
        private ShipShipmentInventoryOperatorInterface $shipShipmentInventoryOperator,
        private AvailableInventorySourcesProviderInterface $availableInventorySourcesProvider,
        private InsufficientItemFromOrderItemsProviderInterface $insufficientItemFromOrderItemsProvider,
        private InventorySourceResolverInterface $inventorySourceResolver,
        private InventorySourceStockUpdaterInterface $inventorySourceStockUpdater,
        private InventorySourceStockRepositoryInterface $inventorySourceStockRepository,
        private InventorySourceExampleFactory $inventorySourceExampleFactory,
        private CartItemAvailabilityValidator $cartItemAvailabilityValidator,
        private LoyaltyPointsAssignerInterface $loyaltyPointsAssigner,
        private ActionBasedLoyaltyPointsCalculatorInterface $actionBasedLoyaltyPointsCalculator,
        private CustomerEmailAwareInterface $customerEmailAware,
        private BuyLoyaltyPurchaseHandler $buyLoyaltyPurchaseHandler,
        private LoyaltyRuleActionInterface $loyaltyRuleAction,
        private LoyaltyRuleActionFactoryInterface $loyaltyRuleActionFactory,
        private LoyaltyPurchasePromotionCouponInstructionGeneratorInterface $loyaltyPurchasePromotionCouponInstructionGenerator,
        private LoyaltyPointsTransactionLoggerInterface $loyaltyPointsTransactionLogger,
        private LoyaltyPointsAccountModifierInterface $loyaltyPointsAccountModifier,
        private OrdersLoyaltyPointsProviderInterface $ordersLoyaltyPointsProvider,
        private LoyaltyRuleConfigurationInterface $loyaltyRuleConfiguration,
        private LoyaltyRuleActionDataTransformerInterface $loyaltyRuleActionDataTransformer,
        private ChannelRestrictingEnabledLoyaltyPurchaseListQueryBuilderInterface $channelRestrictingEnabledLoyaltyPurchaseListQueryBuilder,
        private AdjustmentDuplicatorInterface $adjustmentDuplicator,
        private ShipmentFactoryInterface $shipmentFactory,
        private OrderShipmentPurifierInterface $orderShipmentPurifier,
        private ShipmentUnitModifierInterface $shipmentUnitModifier,
        private AuthorizationCheckerInterface $authorizationChecker,
        private AdminUserContextInterface $adminUserContext,
        private PrivilegeInterface $privilege,
        private AdminPermissionResolverInterface $adminPermissionResolver,
        private RoleRepositoryInterface $roleRepository,
        private RoleExampleFactory $roleExampleFactory,
        private AclHelper $aclHelper,
        private ReturnRateMetricCalculatorInterface $returnRateMetricCalculator,
        private OrderItemsAvailabilityCheckerInterface $orderItemsAvailabilityChecker,
        private ReturnRequestAllUnitsReceivedCheckerInterface $returnRequestAllUnitsReceivedChecker,
        private ReturnRequestAllUnitsReturnedToInventoryCheckerInterface $returnRequestAllUnitsReturnedToInventoryChecker,
        private ReturnRequestCustomerRelationCheckerInterface $returnRequestCustomerRelationChecker,
        private ReplacementOrderCreatorInterface $replacementOrderCreator,
        private ReturnRequestFactoryInterface $returnRequestFactory,
        private ReturnRequestUnitFactoryInterface $returnRequestUnitFactory,
        private ReturnRequestNumberGenerator $returnRequestNumberGenerator,
        private ReturnRequestPdfFileGeneratorInterface $returnRequestPdfFileGenerator,
        private ReturnRequestGuardInterface $returnRequestGuard,
        private ReturnRequestUnitMapperInterface $returnRequestUnitMapper,
        private ReturnInventoryOperatorInterface $returnInventoryOperator,
        private NonReturnableOrderItemUnitIdsProviderInterface $nonReturnableOrderItemUnitIdsProvider,
        private ReturnRequestProviderInterface $returnRequestProvider,
        private ReturnRequestItemsReturnedToInventoryStateResolverInterface $returnRequestItemsReturnedToInventoryStateResolver,
        private ReturnRequestPackageReceivedStateResolverInterface $returnRequestPackageReceivedStateResolver,
        private ReturnRequestConfirmationSender $returnRequestConfirmationSender,
        private ReturnRequestResolutionsProvider $returnRequestResolutionsProvider,
        private CsrfCheckerInterface $csrfChecker,
        private CountOrderItemUnitsQueryInterface $countOrderItemUnitsQuery,
        private ResourceChannelCheckerInterface $resourceChannelCheckers,
    ) {
    }

    public function someMethod()
    {
        $bussinessUnit = new BusinessUnit();
        $inventorySource = new InventorySource();
        $inventorySourceStock = new InventorySourceStock();
        $splitAndSendShipment = new SplitAndSendShipment(1, [1, 2]);

        if (true === false)
        {
            throw new InventorySourceStockInUseException();
        }
    }
}
