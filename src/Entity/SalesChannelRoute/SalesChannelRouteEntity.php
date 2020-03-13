<?php declare(strict_types=1);
/*
 * @author digital.manufaktur GmbH
 * @link   https://www.digitalmanufaktur.com/
 */

namespace Dmf\Api\Entity\SalesChannelRoute;

use Shopware\Core\Content\Seo\SeoUrl\SeoUrlEntity;
use Shopware\Core\Framework\Struct\Struct;

class SalesChannelRouteEntity extends Struct
{
    /**
     * @var string
     */
    protected $routeName;

    /**
     * @var string
     */
    protected $pathInfo;

    /**
     * @var string
     */
    protected $seoPathInfo;

    /**
     * @var string
     */
    protected $isCanonical;

    /**
     * @var string
     */
    protected $resource;

    /**
     * @var string
     */
    protected $resourceIdentifier;

    public function getRouteName(): string
    {
        return $this->routeName;
    }

    public function setRouteName(string $routeName): void
    {
        $this->routeName = $routeName;
    }

    public function getPathInfo(): string
    {
        return $this->pathInfo;
    }

    public function setPathInfo(string $pathInfo): void
    {
        $this->pathInfo = $pathInfo;
    }

    public function getSeoPathInfo(): string
    {
        return $this->seoPathInfo;
    }

    public function setSeoPathInfo(string $seoPathInfo): void
    {
        $this->seoPathInfo = $seoPathInfo;
    }

    public function getIsCanonical(): string
    {
        return $this->isCanonical;
    }

    public function setIsCanonical(string $isCanonical): void
    {
        $this->isCanonical = $isCanonical;
    }

    public function getResource(): string
    {
        return $this->resource;
    }

    public function setResource(string $resource): void
    {
        $this->resource = $resource;
    }

    public function getResourceIdentifier(): string
    {
        return $this->resourceIdentifier;
    }

    public function setResourceIdentifier(string $resourceIdentifier): void
    {
        $this->resourceIdentifier = $resourceIdentifier;
    }

    public static function createFromUrlEntity(SeoUrlEntity $urlEntity): self
    {
        $route = new self();
        $route->setRouteName($urlEntity->getRouteName());
        $route->setPathInfo($urlEntity->getPathInfo());
        $route->setSeoPathInfo($urlEntity->getSeoPathInfo());
//        $route->setIsCanonical($urlEntity->getIsCanonical());
        $route->setResource($urlEntity->getRouteName());
        $route->setResourceIdentifier($urlEntity->getForeignKey());

        return $route;
    }
}
