<?php

namespace ALevel\PublicCache\Api\Repository;

use ALevel\PublicCache\Api\Data\PlayerInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Interface PlayerRepositoryInterface
 * @package ALevel\PublicCache\Api\Repository
 */
interface PlayerRepositoryInterface
{
    const CACHE_PLAYER_ID = 'alevel_player_%s';

    const CACHE_COLLECTION_ID = 'alevel_player_collection_%s';

    /**
     * @param int $playerId
     * @throws NoSuchEntityException
     * @return PlayerInterface
     */
    public function getById(int $playerId) : PlayerInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria) : SearchResultsInterface;

    /**
     * @param PlayerInterface $player
     * @throws CouldNotSaveException
     * @return PlayerRepositoryInterface
     */
    public function save(PlayerInterface $player) : PlayerRepositoryInterface;

    /**
     * @param PlayerInterface $player
     * @throws CouldNotDeleteException
     * @return PlayerRepositoryInterface
     */
    public function delete(PlayerInterface $player) : PlayerRepositoryInterface;

    /**
     * @param int $playerId
     * @throws CouldNotDeleteException
     * @return PlayerRepositoryInterface
     */
    public function deleteById(int $playerId) : PlayerRepositoryInterface;
}
