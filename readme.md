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
