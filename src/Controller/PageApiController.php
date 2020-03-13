<?php declare(strict_types=1);
/*
 * @author digital.manufaktur GmbH
 * @link   https://www.digitalmanufaktur.com/
 */

namespace Dmf\Api\Controller;

use Dmf\Api\Page\Loader\Context\PageLoaderContext;
use Dmf\Api\Page\Loader\Context\PageLoaderContextBuilder;
use Dmf\Api\Page\Loader\PageLoaderInterface;
use Dmf\Api\Page\Result\AbstractPageResult;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\RequestCriteriaBuilder;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\System\SalesChannel\Entity\SalesChannelDefinitionInstanceRegistry;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"sales-channel-api"})
 */
class PageApiController extends AbstractController
{
    const PRODUCT_PAGE_ROUTE = 'frontend.detail.page';
    const NAVIGATION_PAGE_ROUTE = 'frontend.navigation.page';

    /**
     * @var EntityRepositoryInterface
     */
    protected $seoUrlRepository;

    /**
     * @var SalesChannelDefinitionInstanceRegistry
     */
    protected $registry;

    /**
     * @var RequestCriteriaBuilder
     */
    protected $criteriaBuilder;

    public function __construct(
        PageLoaderContextBuilder $pageLoaderContextBuilder,
        iterable $pageLoaders
    ) {
        $this->pageLoaderContextBuilder = $pageLoaderContextBuilder;

        /** @var PageLoaderInterface $pageLoader */
        foreach ($pageLoaders as $pageLoader) {
            $this->pageLoaders[$pageLoader->getResourceType()] = $pageLoader;
        }
    }

    /**
     * @Route("/sales-channel-api/v{version}/dmf/page", name="sales-channel-api.action.dmf.page", methods={"POST"})
     */
    public function getPage(Request $request, SalesChannelContext $context): JsonResponse
    {
        $pageLoaderContext = $this->pageLoaderContextBuilder->build($request, $context);

        $pageLoader = $this->getPageLoader($pageLoaderContext);

        if (!$pageLoader) {
            return new JsonResponse(['error' => sprintf('Resource type not supported: "%s"', $pageLoaderContext->getResourceType())], 404);
        }

        /** @var AbstractPageResult $pageResult */
        $pageResult = $pageLoader->load($pageLoaderContext);

        $pageResult->setResourceType($pageLoaderContext->getResourceType());
        $pageResult->setResourceIdentifier($pageLoaderContext->getResourceIdentifier());

        return new JsonResponse($pageResult);
    }

    /**
     * Determines the correct page loader for a given resource type
     */
    private function getPageLoader(PageLoaderContext $pageLoaderContext): ?PageLoaderInterface
    {
        return $this->pageLoaders[$pageLoaderContext->getResourceType()] ?? null;
    }
}
