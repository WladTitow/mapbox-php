<?php
namespace Mapbox\Models\Response;
use Yandex\Common\Model;
class RetrieveMatrixRequest extends Model
{
    protected $bids;
    protected $mappingClasses = [
        'bids' => Bids::class,
    ];
    /**
     * @return Bids
     */
    public function getRetrieveMatrix()
    {
        return $this->bids;
    }

    public function buildQueryString()
    {
        
    }
}