<?php

namespace Bundle\WindowsBundle\Doctrine;

use Doctrine\Common\Cache\AbstractCache;

/**
 * WinCache cache driver.
 *
 * @license http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link    www.doctrine-project.org
 * @since   2.0
 * @version $Revision$
 * @author  Juozas Kaziukenas <juozas@juokaz.com>
 */
class WinCacheAdaptor extends AbstractCache
{
    /**
     * {@inheritdoc}
     */
    public function getIds()
    {
        $cache = wincache_ucache_info();

        $keys = array();

        foreach ((array) $cache['ucache_entries'] as $entry) {
            $keys[] = $entry['key_name'];
        }

        return $keys;
    }

    /**
     * {@inheritdoc}
     */
    protected function _doFetch($id)
    {
        return wincache_ucache_get($id);
    }

    /**
     * {@inheritdoc}
     */
    protected function _doContains($id)
    {
        return wincache_ucache_exists($id, $found);
    }

    /**
     * {@inheritdoc}
     */
    protected function _doSave($id, $data, $lifeTime = 0)
    {
        return (bool) wincache_ucache_set($id, $data, (int) $lifeTime);
    }

    /**
     * {@inheritdoc}
     */
    protected function _doDelete($id)
    {
        return wincache_ucache_delete($id);
    }
}