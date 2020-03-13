<?php declare(strict_types=1);
/*
 * @author digital.manufaktur GmbH
 * @link   https://www.digitalmanufaktur.com/
 */

namespace Dmf\Api\Controller;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\RequestCriteriaBuilder;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\System\SalesChannel\Entity\SalesChannelDefinitionInstanceRegistry;
use Shopware\Core\System\SalesChannel\Entity\SalesChannelDefinitionInterface;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"sales-channel-api"})
 */
class SeoUrlApiController extends AbstractController
{
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
        EntityRepositoryInterface $seoUrlRepository,
        SalesChannelDefinitionInstanceRegistry $registry,
        RequestCriteriaBuilder $criteriaBuilder
    ) {
        $this->seoUrlRepository = $seoUrlRepository;
        $this->registry = $registry;
        $this->criteriaBuilder = $criteriaBuilder;
    }

    /**
     * @Route("/sales-channel-api/v{version}/dmf/seo-url", name="sales-channel-api.action.dmf.seo-url", methods={"GET"})
     */
    public function getAllUrls(Request $request, SalesChannelContext $context): JsonResponse
    {
        /** @var SalesChannelDefinitionInterface|EntityDefinition $definition */
        $definition = $this->registry->getByEntityName('seo_url');

        $criteria = $this->criteriaBuilder->handleRequest($request, new Criteria(), $definition, $context->getContext());
        $seoUrls = $this->seoUrlRepository->search($criteria, $context->getContext());

        return new JsonResponse([
            'total' => $seoUrls->getTotal(),
            'data' => array_values($seoUrls->getElements()),
        ]);
    }
}
