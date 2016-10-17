# Laravel Api test app

[![Build Status](https://travis-ci.org/brexis/roman-num.svg?branch=master)](https://travis-ci.org/brexis/roman-num)

Implemented files

* The controller `app/Http/Controllers/Api/RomanController.php`
* The model `app/Roman.php`
* The roman table migration `database/migrations/2016_10_16_221936_create_roman_table.php`
* The Abstract conversion class `app/Services/AbstractNumberConversion.php`
* The integer to roman conversion class `app/Services/RomanConversionService.php`
* Fractal Roman model trasformer `app/Transformers/RomanTransformer.php`
* The phpunit test file `tests/RomanConversionTest.php`
* The Roman model fatory `database/factories/RomanFactory.php`


# Api Documentation
### Convert an integer and store in the database

```
POST http://localhost:8000/api/roman
```

### Example
```
$ curl http://localhost:8000/api/roman \
   -H "Content-Type: application/x-www-form-urlencoded" \
   -d number=19
```

### Response

```
{
  "data":
    {
      "id":1,
      "number":"19",
      "result":"XIX",
      "created_at":"2016-10-17 10:11:06"
    }
}
```
### Get the list of recently converted integers

```
GET http://localhost:8000/api/roman
```

### Example
```
$ curl http://localhost:8000/api/roman
```

### Response

```
{
  "data":
    [
      {
        "id":1,
        "number":19,
        "result":"XIX",
        "created_at":"2016-10-17 10:11:06"
      }
    ],
  "meta":
    {
      "pagination":
        {
          "total":1,
          "count":1,
          "per_page":10,
          "current_page":1,
          "total_pages":1,
          "links":[]
        }
    }
}
```
### Get the list of top 10 converted integers

```
GET http://localhost:8000/api/roman/top
```

### Example
```
$ curl http://localhost:8000/api/roman/top
```

### Response

```
{
  "data":
    [
      {
        "id":1,
        "number":19,
        "result":"XIX",
        "created_at":"2016-10-17 10:11:06"
      }
    ]
}
```
