<?php


namespace ALevel\PublicCache\Repository;

use ALevel\PublicCache\Model\Cache\Type\PublicCacheType;
use Psr\Log\LoggerInterface;

use ALevel\PublicCache\Api\Data\PlayerInterface;
use ALevel\PublicCache\Api\Data\PlayerInterfaceFactory;
use ALevel\PublicCache\Api\Repository\PlayerRepositoryInterface;
use ALevel\PublicCache\Model\ResourceModel\Player as ResourceModel;
use ALevel\PublicCache\Model\ResourceModel\Player\CollectionFactory;
use ALevel\PublicCache\Model\ResourceModel\Player\Collection;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\App\Cache\TypeListInterface;

class PlayerRepository implements PlayerRepositoryInterface
{
    private $resourceModel;

    private $playerFactory;

    private $collectionFactory;

    private $searchResultsFactory;

    private $collectionProcessor;

    private $publicCacheType;

    private $cacheList;

    private $serializer;

    private $logger;

    public function __construct(
        ResourceModel $resourceModel,
        PlayerInterfaceFactory $playerFactory,
        CollectionFactory $collectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor,
        PublicCacheType $publicCacheType,
        SerializerInterface $serializer,
        TypeListInterface $cacheTypeList,
        LoggerInterface $logger
    ) {
        $this->resourceModel        = $resourceModel;
        $this->playerFactory        = $playerFactory;
        $this->collectionFactory    = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor  = $collectionProcessor;
        $this->publicCacheType      = $publicCacheType;
        $this->serializer           = $serializer;
        $this->cacheList            = $cacheTypeList;
        $this->logger               = $logger;
    }

    public function getById(int $playerId): PlayerInterface
    {
        $cacheId = $this->getCacheId('player', $playerId);

        if (!$this->publicCacheType->load($cacheId)) {
            /** @var PlayerInterface $player */
            $player = $this->playerFactory->create();

            $this->resourceModel->load($player, $playerId);

            if (empty($player->getId())) {
                throw new NoSuchEntityException(__("Player %1 not found", $playerId));
            }

            $this->publicCacheType->save(
                $this->serializer->serialize($player),
                $cacheId,
                [PublicCacheType::CACHE_TAG]
            );
        }

        /** @var PlayerInterface $player */
        $player = $this->serializer->unserialize($this->publicCacheType->load($cacheId));

        return $player;
    }

    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setItems($collection->getItems());
        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;
    }

    public function save(PlayerInterface $player): PlayerRepositoryInterface
    {
        try {
            $this->resourceModel->save($player);
            $this->cacheList->invalidate(PublicCacheType::TYPE_IDENTIFIER);
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);
            throw new CouldNotSaveException(__("Player %1 could not save", $player->getFullName()));
        }

        return $this;
    }

    public function delete(PlayerInterface $player): PlayerRepositoryInterface
    {
        try {
            $this->resourceModel->delete($player);
            $this->cacheList->invalidate(PublicCacheType::TYPE_IDENTIFIER);
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);
            throw new CouldNotDeleteException(__("Player %1 could not delete", $player->getId()));
        }

        return $this;
    }

    public function deleteById(int $playerId): PlayerRepositoryInterface
    {
        try {
            $player = $this->getById($playerId);
            $this->delete($player);
        } catch (NoSuchEntityException $e) {
            $this->logger->info(sprintf("player %d already deleted", $playerId));
        }

        return $this;
    }

    private function getCacheId($type, $suffix)
    {
        $cachePrefix = ($type === 'player') ? self::CACHE_PLAYER_ID : self::CACHE_COLLECTION_ID;

        return sprintf($cachePrefix, $suffix);
    }
}
