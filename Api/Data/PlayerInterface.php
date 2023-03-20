<?php

namespace ALevel\PublicCache\Api\Data;

interface PlayerInterface
{
    public function getId();

    public function setFirstName(string $firtsName) : PlayerInterface;

    public function getFirstName() : ?string;

    public function setLastName(string $lastName) : PlayerInterface;

    public function getLastName() : ?string;

    public function setBloodPoints(int $bloodPoints) : PlayerInterface;

    public function getBloodPoints() : ?int;

    public function getFullName() : ?string;
}
