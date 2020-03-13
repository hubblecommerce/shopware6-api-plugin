<?php declare(strict_types=1);
/*
 * @author digital.manufaktur GmbH
 * @link   https://www.digitalmanufaktur.com/
 */

namespace Dmf\Api\Page\Loader\Context;

use Dmf\Api\Controller\PageApiController;
use Dmf\Api\Entity\SalesChannelRoute\SalesChannelRouteEntity;
use Dmf\Api\Entity\SalesChannelRoute\SalesChannelRouteRepository;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;

/**
 * Resolves a url path to get a route.
 */
class PathResolver implements PathResolverInterface
{
    private const MATCH_MAP = [
        PageApiController::NAVIGATION_PAGE_ROUTE => '/^\/?navigation\/([a-f0-9]{32})$/',
        PageApiController::PRODUCT_PAGE_ROUTE => '/^\/?detail\/([a-f0-9]{32})$/',
    ];

    /**
     * @var SalesChannelRouteRepository
     */
    private $routeRepository;

    public function __construct(SalesChannelRouteRepository $routeRepository)
    {
        $this->routeRepository = $routeRepository;
    }

    /**
     * First, we search for the route within the route repository.
     * If it doesn't exist in there, we do some generic matching with regular expressions.
     */
    public function resolve(string $path, Context $context): ?SalesChannelRouteEntity
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('seoPathInfo', $path));

        $routes = $this->routeRepository->search($criteria, $context);

        if (count($routes) === 0) {
            return $this->resolveTechnicalPath($path);
        }

        return array_shift($routes);
    }

    /**
     * Tries to resolve the route given the regular expressions above (to imitate the annotated routing)
     */
    private function resolveTechnicalPath(string $path): ?SalesChannelRouteEntity
    {
        $matches = null;

        foreach (self::MATCH_MAP as $routeName => $routePattern) {
            if (preg_match($routePattern, $path, $matches)) {
                $route = new SalesChannelRouteEntity();
                $route->setResource($routeName);
                $route->setResourceIdentifier($matches[1]);
                $route->setPathInfo($path);
                $route->setRouteName($routeName);

                return $route;
            }
        }

        return null;
    }
}
