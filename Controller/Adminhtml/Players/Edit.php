<?php


namespace ALevel\PublicCache\Controller\Adminhtml\Players;

use ALevel\PublicCache\Controller\Adminhtml\Players;

class Edit extends Players
{
    const ACL_RESOURCE = 'ALevel_PublicCache::players_grid';

    protected function getAclResource()
    {
        return self::ACL_RESOURCE;
    }
}
