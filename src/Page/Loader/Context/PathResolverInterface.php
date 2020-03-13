<?php declare(strict_types=1);
/*
 * @author digital.manufaktur GmbH
 * @link   https://www.digitalmanufaktur.com/
 */

namespace Dmf\Api\Page\Loader\Context;

use Dmf\Api\Entity\SalesChannelRoute\SalesChannelRouteEntity;
use Shopware\Core\Framework\Context;

interface PathResolverInterface
{
    public function resolve(string $path, Context $context): ?SalesChannelRouteEntity;
}
