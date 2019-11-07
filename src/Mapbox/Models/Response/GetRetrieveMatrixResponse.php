<?php
namespace Mapbox\Models\Response;
use Yandex\Common\Model;
use Mapbox\Models\RetrieveMatrix;
class GetRetrieveMatrixResponse extends Model
{
    protected $retrieveMatrix;
    protected $mappingClasses = [
        'retrieveMatrix' => RetrieveMatrix::class,
    ];
    /**
     * @return RetrieveMatrix
     */
    public function getRetrieveMatrix()
    {
        return $this->retrieveMatrix;
    }
}