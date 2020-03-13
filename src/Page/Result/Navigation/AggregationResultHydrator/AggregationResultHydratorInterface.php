<?php declare(strict_types=1);
/*
 * @author digital.manufaktur GmbH
 * @link   https://www.digitalmanufaktur.com/
 */

namespace Dmf\Api\Page\Result\Navigation\AggregationResultHydrator;

use Shopware\Core\Framework\DataAbstractionLayer\Search\AggregationResult\AggregationResult;

interface AggregationResultHydratorInterface
{
    public function getSupportedAggregationType(): string;

    public function hydrate(AggregationResult $result): array;
}
