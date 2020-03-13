<?php declare(strict_types=1);
/*
 * @author digital.manufaktur GmbH
 * @link   https://www.digitalmanufaktur.com/
 */

namespace Dmf\Api\Entity\SalesChannelRoute;

use Shopware\Core\Content\Seo\SeoUrl\SeoUrlEntity;
use Shopware\Core\Framework\Api\Context\SalesChannelApiSource;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;

class SalesChannelRouteRepository
{
    /**
     * @var EntityRepositoryInterface
     */
    private $seoUrlRepository;

    public function __construct($seoUrlRepository)
    {
        $this->seoUrlRepository = $seoUrlRepository;
    }

    public function search(Criteria $criteria, Context $context): array
    {
        /** @var SalesChannelApiSource $contextSource */
        $contextSource = $context->getSource();

        $criteria->addFilter(new EqualsFilter('languageId', $context->getLanguageId()));
        $criteria->addFilter(new EqualsFilter('salesChannelId', $contextSource->getSalesChannelId()));

        /** @var EntitySearchResult $seoUrlCollection */
        $seoUrlCollection = $this->seoUrlRepository->search($criteria, $context);

        return $this->prepareRoutes($seoUrlCollection->getElements());
    }

    public function getSeoRoute(Context $context, string $name, string $resourceIdentifier): SalesChannelRouteEntity
    {
        $criteria = new Criteria();
        $criteria->addFilter(
            new EqualsFilter('foreignKey', $resourceIdentifier)
        );

        $routes = $this->search($criteria, $context);

        if (count($routes) >= 1) {
            return $routes[0];
        }

        $route = new SalesChannelRouteEntity();

        $route->setPathInfo('/');
        $route->setSeoPathInfo('/');
        $route->setResourceIdentifier($resourceIdentifier);
        $route->setRouteName($name);
        $route->setResource($name);

        return $route;
    }

    /**
     * @param SeoUrlEntity[] $routes
     *
     * @return SalesChannelRouteEntity[]
     */
    private function prepareRoutes($routes): array
    {
        $preparedRoutes = [];

        foreach ($routes as $route) {
            $preparedRoutes[] = SalesChannelRouteEntity::createFromUrlEntity($route);
        }

        return $preparedRoutes;
    }
}
