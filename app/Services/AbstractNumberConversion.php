<?php

namespace App\Services;

use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use DB;

abstract class AbstractNumberConversion
{
  protected $model;

  protected $transformer;

  protected $perPage = 10;

  public function convert($num)
  {
    return $num;
  }

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

  protected function getColumns()
  {
    $model = $this->getModel();
    $resource = new $model;

    return DB::getSchemaBuilder()->getColumnListing($resource->getTable());
  }

  protected function getModel()
  {
    if (! class_exists($this->model)) {
      throw new \Exception("Model \"{$this->model}\" not found. Please provide an eloquent model to the service.");
    }

    return $this->model;
  }

  protected function getTransformer()
  {
    if (! class_exists($this->transformer)) {
      throw new \Exception("Transformer \"{$this->transformer}\" not found. Please provide a fractal transformer to the service.");
    }

    return $this->transformer;
  }
}
