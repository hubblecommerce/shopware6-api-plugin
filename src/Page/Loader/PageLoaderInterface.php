<?php declare(strict_types=1);
/*
 * @author digital.manufaktur GmbH
 * @link   https://www.digitalmanufaktur.com/
 */

namespace Dmf\Api\Page\Loader;

use Dmf\Api\Page\Loader\Context\PageLoaderContext;

interface PageLoaderInterface
{
    public function getResourceType(): string;

    public function load(PageLoaderContext $pageLoaderContext);
}
