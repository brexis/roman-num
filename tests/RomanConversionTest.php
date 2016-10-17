<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Roman;

class RomanConversionTest extends TestCase
{
  use DatabaseMigrations;

  /**
   * Check if the the number is converted and store to the database
   * When executing the create request
   * @return void
   */
  public function testShouldStoreTheRomanNumber()
  {
    $this->post('/api/roman', ['number' => 99])
    ->seeJsonStructure([
      'data' => ['id', 'number', 'result', 'created_at']
    ])
    ->seeJson([
      'number' => 99,
      'result' => 'XCIX'
    ]);
  }

  /**
   * Test the index request. Shoul return the list of the recent roman numbers
   * @return void
   */
  public function testShouldGetTheListOsRomanNumbers()
  {
    $romans = factory(Roman::class, 5)->create();

    $this->get('/api/roman')
    ->seeJsonStructure([
      'data' => [
        '*' => ['id', 'number', 'result', 'created_at']
      ],
      'meta' => [
        'pagination' => ['total', 'count', 'per_page', 'current_page', 'total_pages', 'links']
      ]
    ])
    ->seeJsonEquals([
      'data' => $romans->toArray(),
      'meta' => [
        'pagination' => [
          'total' => 5,
          'count' => 5,
          'per_page' => 10,
          'current_page' => 1,
          'total_pages' => 1,
          'links' => []
        ]
      ]
    ]);
  }

  /**
   * Test the top 10 converted integers request
   * @return void
   */
  public function testShouldGetTheTopTenRomanNumbers()
  {
    $ten = factory(Roman::class, 2)->create([
      'number' => 10,
      'result' => 'X'
    ]);

    $nine = factory(Roman::class, 5)->create([
      'number' => 9,
      'result' => 'IX'
    ]);

    $five = factory(Roman::class, 10)->create([
      'number' => 5,
      'result' => 'V'
    ]);

    $top = collect([$five->first(), $nine->first(), $ten->first()]);

    $this->get('/api/roman/top')
    ->seeJsonStructure([
      'data' => [
        '*' => ['id', 'number', 'result', 'created_at']
      ]
    ])
    ->seeJsonEquals([
      'data' => $top->toArray(),
    ]);
  }
}
