<?php declare(strict_types=1);
/*
 * @author digital.manufaktur GmbH
 * @link   https://www.digitalmanufaktur.com/
 */

namespace Dmf\Api\Page\Result\Navigation\AggregationResultHydrator;

use Shopware\Core\Framework\DataAbstractionLayer\Search\AggregationResult\AggregationResult;
use Shopware\Core\Framework\DataAbstractionLayer\Search\AggregationResult\Metric\MaxResult;

class MaxResultHydrator implements AggregationResultHydratorInterface
{
    public function getSupportedAggregationType(): string
    {
        return MaxResult::class;
    }

    public function hydrate(AggregationResult $result): array
    {
        /* @var MaxResult $result */

        return [
            'type' => 'max',
            'values' => $result->getMax(),
        ];
    }
}
