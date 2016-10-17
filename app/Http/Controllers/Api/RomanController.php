<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\RomanConversionService;

class RomanController extends Controller
{
  private $service;

  public function __construct(RomanConversionService $service)
  {
    $this->service = $service;
  }

  public function index(Request $request)
  {
    return response()->json($this->service->list());
  }

  public function store(Request $request)
  {
    $number = $request->input('number');

    return response()->json($this->service->store($number));
  }

  public function top()
  {
    return response()->json($this->service->top());
  }
}
