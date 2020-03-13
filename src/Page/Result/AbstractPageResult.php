<?php declare(strict_types=1);
/*
 * @author digital.manufaktur GmbH
 * @link   https://www.digitalmanufaktur.com/
 */

namespace Dmf\Api\Page\Result;

use Shopware\Core\Framework\Struct\JsonSerializableTrait;

/**
 * This abstract class gives structure to any page results by dictating them to have a resource and an identifier
 */
abstract class AbstractPageResult implements \JsonSerializable
{
    use JsonSerializableTrait;

    /**
     * @var string
     */
    protected $resourceType;

    /**
     * @var string
     */
    protected $resourceIdentifier;

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
}
