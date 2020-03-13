<?php declare(strict_types=1);
/*
 * @author digital.manufaktur GmbH
 * @link   https://www.digitalmanufaktur.com/
 */

namespace Dmf\Api\Page\Loader\Context;

use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * This class builds the PageLoaderContext which is required to load a page.
 * It contains the resource type (which maps to the route name, like 'frontend.detail.page') and the corresponding identifier.
 * The path is resolved using the PathResolver class.
 *
 * Other than that it's just a container for the request and sales channel context.
 */
class PageLoaderContextBuilder
{
    /**
     * @var PathResolver
     */
    private $pathResolver;

    public function __construct(PathResolver $pathResolver)
    {
        $this->pathResolver = $pathResolver;
    }

    public function build(Request $request, SalesChannelContext $context): PageLoaderContext
    {
        $path = $request->get('path');

        if ($path === null) {
            throw new NotFoundHttpException('Please provide a path to be resolved.');
        }

        $route = $this->pathResolver->resolve($path, $context->getContext());

        if (!$route) {
            throw new NotFoundHttpException(sprintf('Path `%s` could not be resolved.', $path));
        }

        /*
         * Workaround to come up for: platform/src/Core/Content/Product/SalesChannel/Listing/ProductListingGateway.php:66
         */
        $request->attributes->set('_route_params', [
            'navigationId' => $route->getResourceIdentifier(),
        ]);

        $pageLoaderContext = new PageLoaderContext();
        $pageLoaderContext->setResourceType($route->getRouteName());
        $pageLoaderContext->setResourceIdentifier($route->getResourceIdentifier());
        $pageLoaderContext->setContext($context);
        $pageLoaderContext->setRequest($request);

        return $pageLoaderContext;
    }
}
