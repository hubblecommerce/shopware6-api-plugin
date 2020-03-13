<?php declare(strict_types=1);
/*
 * @author digital.manufaktur GmbH
 * @link   https://www.digitalmanufaktur.com/
 */

namespace Dmf\Api\Page\Result\Product;

use Dmf\Api\Page\Result\AbstractPageResult;
use Shopware\Core\Content\Product\SalesChannel\SalesChannelProductEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Search\AggregationResult\AggregationResultCollection;

class ProductPageResult extends AbstractPageResult
{
    /**
     * @var SalesChannelProductEntity
     */
    protected $product;

    /**
     * @var AggregationResultCollection
     */
    protected $aggregations;

    public function getProduct(): SalesChannelProductEntity
    {
        return $this->product;
    }

    public function setProduct(SalesChannelProductEntity $product): void
    {
        $this->product = $product;
    }

    public function setAggregations(AggregationResultCollection $aggregations): void
    {
        $this->aggregations = $aggregations;
    }

    /**
     * @return AggregationResultCollection
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }
}
