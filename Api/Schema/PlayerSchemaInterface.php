<?php

namespace ALevel\PublicCache\Api\Schema;

interface PlayerSchemaInterface
{
    const TABLE_NAME = 'alevel_player';

    const ID_COLUMN_NAME            = 'player_id';
    const FIRST_NAME_COLUMN_NAME    = 'first_name';
    const LAST_NAME_COLUMN_NAME     = 'last_name';
    const BLOOD_POINTS_COLUMN_NAME  = 'blood_points';
}
