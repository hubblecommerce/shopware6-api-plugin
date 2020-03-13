<?php declare(strict_types=1);
/*
 * @author digital.manufaktur GmbH
 * @link   https://www.digitalmanufaktur.com/
 */

namespace Dmf\Api\Page\Result\Navigation\AggregationResultHydrator;

use Shopware\Core\Framework\DataAbstractionLayer\Search\AggregationResult\AggregationResult;
use Shopware\Core\Framework\DataAbstractionLayer\Search\AggregationResult\Metric\StatsResult;

class StatsResultHydrator implements AggregationResultHydratorInterface
{
    public function getSupportedAggregationType(): string
    {
        return StatsResult::class;
    }

    public function hydrate(AggregationResult $result): array
    {
        /* @var StatsResult $result */

        return [
            'type' => 'range',
            'values' => [
                'max' => $result->getMax(),
                'min' => $result->getMin(),
            ],
        ];
    }
}
