<?php
namespace Mapbox\Models;
use Yandex\Common\ObjectModel;
/**
 * Class Navigation
 *
 * @package Mapbox\Models
 */
class RetrieveMatrix extends ObjectModel
{
    /**
     * @param array|object $navigation
     *
     * @return Navigation
     */
    public function add($navigation)
    {
        if (is_array($bid)) {
            $this->collection[] = new Navigation($bid);
        } elseif (is_object($bid) && $bid instanceof Navigation) {
            $this->collection[] = $bid;
        }
        return $this;
    }
    /**
     * Get items
     *
     * @return Navigation[]
     */
    public function getAll()
    {
        return $this->collection;
    }
    /**
     * @return Navigation
     */
    public function current()
    {
        return parent::current();
    }
}