<?php

namespace App\Services;

use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use DB;

/**
 * Abstract number conversion service class
 */
abstract class AbstractNumberConversion
{
  /**
   * The model that is managing
   * @var Illuminate\Database\Eloquent\Model
   */
  protected $model;

  /**
   * Fractal transformer of the model
   * @var League\Fractal\TransformerAbstract
   */
  protected $transformer;

  /**
   * Number of items per page
   * @var integer
   */
  protected $perPage = 10;

  /**
   * Convert a given number to a target type
   * @param  integer $num
   * @return mixed
   */
  public function convert($num)
  {
    return $num;
  }

  /**
   * Convert and store the converted number in the database
   * @param  integer $num
   * @return array the saved model trasformed to array using the transformer
   */
  public function store($num)
  {
    $result = $this->convert($num);
    $model = $this->getModel();
    $transformer = $this->getTransformer();

    $resource = new $model;
    $resource->number = $num;
    $resource->result = $result;

    $resource->save();

    return fractal()->item($resource, new $transformer)->toArray();
  }

  /**
   * Return all the recent converted numbers returned as array using the transformer
   * @return array
   */
  public function list()
  {
    $model = $this->getModel();
    $transformer = $this->getTransformer();

    $paginator = $model::orderBy('created_at', 'DESC')->paginate($this->perPage);
    $resources = $paginator->getCollection();

    return fractal()
    ->collection($resources, new $transformer)
    ->paginateWith(new IlluminatePaginatorAdapter($paginator))->toArray();
  }

  /**
   * Return the top 10 converted number
   * @return array
   */
  public function top()
  {
    $model = $this->getModel();
    $transformer = $this->getTransformer();

    $columns = $this->getColumns();
    $columns = array_diff($columns, ['created_at']);

    $resources = $model::select($columns)
    ->addSelect(DB::raw('MAX(created_at) AS created_at'))
    ->groupBy('number')
    ->orderBy(DB::raw('COUNT(number)'), 'DESC')
    ->take(10)
    ->get();

    return fractal()
    ->collection($resources, new $transformer)->toArray();
  }

  /**
   * Return the model table columns
   * @return array the model table columns
   */
  protected function getColumns()
  {
    $model = $this->getModel();
    $resource = new $model;

    return DB::getSchemaBuilder()->getColumnListing($resource->getTable());
  }

  /**
   * Return the model class. Throw an error if it's not defined
   * @return string
   */
  protected function getModel()
  {
    if (! class_exists($this->model)) {
      throw new \Exception("Model \"{$this->model}\" not found. Please provide an eloquent model to the service.");
    }

    return $this->model;
  }

  /**
   * Return the model transformer. Throw an error if it's not defined
   * @return string
   */
  protected function getTransformer()
  {
    if (! class_exists($this->transformer)) {
      throw new \Exception("Transformer \"{$this->transformer}\" not found. Please provide a fractal transformer to the service.");
    }

    return $this->transformer;
  }
}
