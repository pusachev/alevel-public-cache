<?php

namespace ALevel\PublicCache\Setup\Patch\Data;

use ALevel\PublicCache\Api\Data\PlayerInterface;
use ALevel\PublicCache\Api\Data\PlayerInterfaceFactory;
use ALevel\PublicCache\Api\Repository\PlayerRepositoryInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchInterface;

class GeneratePlayersPatch implements DataPatchInterface
{
    private $playerFactory;

    private $repository;

    public function __construct(
        PlayerInterfaceFactory $playerFactory,
        PlayerRepositoryInterface $playerRepository
    ) {
        $this->playerFactory = $playerFactory;
        $this->repository = $playerRepository;
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

    public function apply()
    {
        $data = [
            [
                'first_name' => 'Dwight',
                'last_name'  => 'Fairfield',
            ],
            [
                'first_name' => 'Meg',
                'last_name'  => 'Thomas',
            ],
            [
                'first_name' => 'Claudette',
                'last_name'  => 'Morel',
            ],
            [
                'first_name' => 'Jake',
                'last_name'  => 'Park',
            ],
            [
                'first_name' => 'Nea',
                'last_name'  => 'Karlsson',
            ],
            [
                'first_name' => 'Laurie',
                'last_name'  => 'Strode',
            ],
            [
                'first_name' => 'Ace',
                'last_name'  => 'Visconti',
            ],
            [
                'first_name' => 'Ace',
                'last_name'  => 'Visconti',
            ],
            [
                'first_name' => 'Feng',
                'last_name'  => 'Min',
            ],
            [
                'first_name' => 'David',
                'last_name'  => 'King',
            ],
        ];

        foreach ($data as $playerData) {
            $player = $this->playerFactory->create(['data' => $playerData]);
            $player->setBloodPoints(rand(0, 1000000));

            $this->repository->save($player);
        }
    }
}
