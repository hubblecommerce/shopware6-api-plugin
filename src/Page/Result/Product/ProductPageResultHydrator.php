<?php declare(strict_types=1);
/*
 * @author digital.manufaktur GmbH
 * @link   https://www.digitalmanufaktur.com/
 */

namespace Dmf\Api\Page\Result\Product;

use Dmf\Api\Page\Loader\Context\PageLoaderContext;
use Shopware\Core\Content\Product\SalesChannel\SalesChannelProductEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Search\AggregationResult\AggregationResultCollection;

class ProductPageResultHydrator
{
    public function hydrate(PageLoaderContext $pageLoaderContext, SalesChannelProductEntity $product, AggregationResultCollection $aggregations): ProductPageResult
    {
        $pageResult = new ProductPageResult();

        $pageResult->setProduct($product);

        $pageResult->setAggregations($aggregations);

        $pageResult->setResourceType($pageLoaderContext->getResourceType());
        $pageResult->setResourceIdentifier($pageLoaderContext->getResourceIdentifier());

        return $pageResult;
    }
}
