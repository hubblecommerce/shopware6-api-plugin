<?php declare(strict_types=1);
/*
 * @author digital.manufaktur GmbH
 * @link   https://www.digitalmanufaktur.com/
 */

namespace Dmf\Api\Page\Result\Navigation;

use Dmf\Api\Page\Result\AbstractPageResult;
use Shopware\Core\Content\Cms\CmsPageEntity;

class NavigationPageResult extends AbstractPageResult
{
    /**
     * @var CmsPageEntity|null
     */
    protected $cmsPage;

    /**
     * @var array
     */
    protected $breadcrumb;

    /**
     * @var array
     */
    protected $listingConfiguration;

    public function getCmsPage(): ?CmsPageEntity
    {
        return $this->cmsPage;
    }

    public function setCmsPage(?CmsPageEntity $cmsPage): void
    {
        $this->cmsPage = $cmsPage;
    }

    public function getBreadcrumb(): array
    {
        return $this->breadcrumb;
    }

    public function setBreadcrumb(array $breadcrumb): void
    {
        $this->breadcrumb = $breadcrumb;
    }

    public function getListingConfiguration(): array
    {
        return $this->listingConfiguration;
    }

    public function setListingConfiguration(array $listingConfiguration): void
    {
        $this->listingConfiguration = $listingConfiguration;
    }
}
