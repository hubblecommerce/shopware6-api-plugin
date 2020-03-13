<?php declare(strict_types=1);
/*
 * @author digital.manufaktur GmbH
 * @link   https://www.digitalmanufaktur.com/
 */

namespace Dmf\Api\Page\Loader;

use Dmf\Api\Page\Loader\Context\PageLoaderContext;
use Dmf\Api\Page\Result\Product\ProductPageResult;
use Dmf\Api\Page\Result\Product\ProductPageResultHydrator;
use Shopware\Core\Content\Product\Exception\ProductNumberNotFoundException;
use Shopware\Core\Content\Product\SalesChannel\ProductAvailableFilter;
use Shopware\Core\Content\Product\SalesChannel\SalesChannelProductDefinition;
use Shopware\Core\Content\Product\SalesChannel\SalesChannelProductEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\RequestCriteriaBuilder;
use Shopware\Core\System\SalesChannel\Entity\SalesChannelRepository;

/**
 * This class is a wrapper/proxy for the Shopware\Storefront\Page\Product\ProductPageLoader which is a part of the Shopware storefront bundle.
 * We don't want dependencies from this layer of the application, that's why there is this facade
 * Once composite page loading will be included in the Shopware core, this layer of abstraction becomes obsolete.
 * Otherwise it can serve as a structural reference for the implementation of the sales channel api.
 */
class ProductPageLoader implements PageLoaderInterface
{
    private const RESOURCE_TYPE = 'frontend.detail.page';

    /**
     * @var SalesChannelRepository
     */
    private $productRepository;

    /**
     * @var ProductPageResultHydrator
     */
    private $resultHydrator;

    /**
     * @var RequestCriteriaBuilder
     */
    private $requestCriteriaBuilder;

    /**
     * @var SalesChannelProductDefinition
     */
    private $productDefinition;

    public function __construct(
        SalesChannelRepository $productRepository,
        ProductPageResultHydrator $resultHydrator,
        RequestCriteriaBuilder $requestCriteriaBuilder,
        SalesChannelProductDefinition $productDefinition
    ) {
        $this->productRepository = $productRepository;
        $this->resultHydrator = $resultHydrator;
        $this->requestCriteriaBuilder = $requestCriteriaBuilder;
        $this->productDefinition = $productDefinition;
    }

    public function getResourceType(): string
    {
        return self::RESOURCE_TYPE;
    }

    /**
     * @throws ProductNumberNotFoundException
     */
    public function load(PageLoaderContext $pageLoaderContext): ProductPageResult
    {
        $criteria = new Criteria([$pageLoaderContext->getResourceIdentifier()]);
        $criteria->setLimit(1);

        $criteria = $this->requestCriteriaBuilder->handleRequest(
            $pageLoaderContext->getRequest(),
            $criteria,
            $this->productDefinition,
            $pageLoaderContext->getContext()->getContext()
        );

        $criteria->addFilter(
            new ProductAvailableFilter($pageLoaderContext->getContext()->getSalesChannel()->getId()),
            new EqualsFilter('active', 1)
        );

        $searchResult = $this->productRepository->search($criteria, $pageLoaderContext->getContext());

        if ($searchResult->count() < 1) {
            throw new ProductNumberNotFoundException($pageLoaderContext->getResourceIdentifier());
        }

        /** @var SalesChannelProductEntity $product */
        $product = $searchResult->first();
        $aggregations = $searchResult->getAggregations();

        return $this->resultHydrator->hydrate($pageLoaderContext, $product, $aggregations);
    }
}
