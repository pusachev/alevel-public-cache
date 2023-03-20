<?php


namespace ALevel\PublicCache\Block;


use ALevel\PublicCache\Api\Repository\PlayerRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Players extends Template implements IdentityInterface
{
    private $repository;

    /** @var SearchCriteriaBuilder  */
    private $searchCriteriaBuilder;

    /**
     * Players constructor.
     * @param Context $context
     * @param PlayerRepositoryInterface $playerRepository
     * @param SearchCriteriaBuilder $builder
     * @param array $data
     */
    public function __construct(
        Context $context,
        PlayerRepositoryInterface $playerRepository,
        SearchCriteriaBuilder $builder,
        array $data = []
    ) {
        $this->repository = $playerRepository;
        $this->searchCriteriaBuilder = $builder;
        parent::__construct($context, $data);
    }

    public function getPlayersData()
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();

        return $this->repository->getList($searchCriteria);
    }

    public function getIdentities()
    {
        return ['alevel_publiccahe_playes'];
    }
}
