<?php declare(strict_types=1);
/*
 * @author digital.manufaktur GmbH
 * @link   https://www.digitalmanufaktur.com/
 */

namespace Dmf\Api\Page\Loader\Context;

use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;

class PageLoaderContext
{
    /**
     * @var string
     */
    private $resourceType;

    /**
     * @var string
     */
    private $resourceIdentifier;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var SalesChannelContext
     */
    private $context;

    public function getResourceType(): string
    {
        return $this->resourceType;
    }

    public function setResourceType(string $resourceType): void
    {
        $this->resourceType = $resourceType;
    }

    public function getResourceIdentifier(): string
    {
        return $this->resourceIdentifier;
    }

    public function setResourceIdentifier(string $resourceIdentifier): void
    {
        $this->resourceIdentifier = $resourceIdentifier;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    public function getContext(): SalesChannelContext
    {
        return $this->context;
    }

    public function setContext(SalesChannelContext $context): void
    {
        $this->context = $context;
    }
}
