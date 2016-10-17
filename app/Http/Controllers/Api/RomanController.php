<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\RomanConversionService;

class RomanController extends Controller
{
  /**
   * Controller service
   * @var RomanConversionService
   */
  private $service;

  /**
   * __construct
   * @param RomanConversionService $service the service that manages Roman model
   */
  public function __construct(RomanConversionService $service)
  {
    $this->service = $service;
  }

  /**
   * Return all of the recent converted integers
   * @param  Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    return response()->json($this->service->list());
  }

  /**
   * Convert an interger to roman numeral and store it in the database
   * @param  Request $request Accepts the number in POST data
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $number = $request->input('number');

    return response()->json($this->service->store($number));
  }

  /**
   * List the top 10 converted integers
   * @return \Illuminate\Http\Response
   */
  public function top()
  {
    return response()->json($this->service->top());
  }
}
