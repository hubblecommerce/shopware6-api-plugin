<?php declare(strict_types=1);
/*
 * @author digital.manufaktur GmbH
 * @link   https://www.digitalmanufaktur.com/
 */

namespace Dmf\Api\Page\Loader;

use Dmf\Api\Page\Loader\Context\PageLoaderContext;
use Dmf\Api\Page\Result\Navigation\NavigationPageResult;
use Dmf\Api\Page\Result\Navigation\NavigationPageResultHydrator;
use Shopware\Core\Content\Category\Exception\CategoryNotFoundException;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\EntityResolverContext;
use Shopware\Core\Content\Cms\SalesChannel\SalesChannelCmsPageLoader;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\System\SalesChannel\Entity\SalesChannelRepositoryInterface;

/**
 * This is a composite loader which utilizes the Shopware\Core\Content\Cms\SalesChannel\SalesChannelCmsPageLoader.
 * On top of fetching a resolved and hydrated CMS page, it fetches additional information about the category.
 */
class NavigationPageLoader implements PageLoaderInterface
{
    private const RESOURCE_TYPE = 'frontend.navigation.page';

    /**
     * @var SalesChannelCmsPageLoader
     */
    private $cmsPageLoader;

    /**
     * @var SalesChannelRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @var NavigationPageResultHydrator
     */
    private $resultHydrator;

    /**
     * @var EntityDefinition
     */
    private $categoryDefinition;

    public function __construct(SalesChannelRepositoryInterface $categoryRepository, SalesChannelCmsPageLoader $cmsPageLaoder, NavigationPageResultHydrator $resultHydrator, EntityDefinition $categoryDefinition)
    {
        $this->cmsPageLoader = $cmsPageLaoder;
        $this->categoryRepository = $categoryRepository;
        $this->resultHydrator = $resultHydrator;
        $this->categoryDefinition = $categoryDefinition;
    }

    public function getResourceType(): string
    {
        return self::RESOURCE_TYPE;
    }

    /**
     * @throws CategoryNotFoundException
     */
    public function load(PageLoaderContext $pageLoaderContext): NavigationPageResult
    {
        $categoryResult = $this->categoryRepository->search(
            $this->prepareCategoryCriteria($pageLoaderContext),
            $pageLoaderContext->getContext()
        );

        if (!$categoryResult->has($pageLoaderContext->getResourceIdentifier())) {
            throw new CategoryNotFoundException($pageLoaderContext->getResourceIdentifier());
        }

        $category = $categoryResult->get($pageLoaderContext->getResourceIdentifier());

        // The cms page might be empty or non-existent
        if ($category->getCmsPageId() !== null) {
            $resolverContext = new EntityResolverContext(
                $pageLoaderContext->getContext(),
                $pageLoaderContext->getRequest(),
                $this->categoryDefinition,
                $category
            );

            $cmsPages = $this->cmsPageLoader->load(
                $pageLoaderContext->getRequest(),
                new Criteria([$category->getCmsPageId()]),
                $pageLoaderContext->getContext(),
                $category->getSlotConfig(),
                $resolverContext
            );

            $cmsPage = $cmsPages->get($category->getCmsPageId()) ?? null;
        }

        $pageResult = $this->resultHydrator->hydrate($pageLoaderContext, $category, $cmsPage ?? null);

        return $pageResult;
    }

    public function prepareCategoryCriteria(PageLoaderContext $pageLoaderContext): Criteria
    {
        $criteria = new Criteria([$pageLoaderContext->getResourceIdentifier()]);
        $criteria->addAssociation('media');

        return $criteria;
    }
}
