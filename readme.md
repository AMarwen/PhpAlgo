[![Build Status](https://travis-ci.org/AMarwen/PhpAlgo.svg?branch=master)](https://travis-ci.org/AMarwen/PhpAlgo)
[![Latest Stable Version](https://poser.pugx.org/phpalgo/phpalgo/v/stable)](https://packagist.org/packages/phpalgo/phpalgo) [![Total Downloads](https://poser.pugx.org/phpalgo/phpalgo/downloads)](https://packagist.org/packages/phpalgo/phpalgo) [![Latest Unstable Version](https://poser.pugx.org/phpalgo/phpalgo/v/unstable)](https://packagist.org/packages/phpalgo/phpalgo) [![License](https://poser.pugx.org/phpalgo/phpalgo/license)](https://packagist.org/packages/phpalgo/phpalgo)
[![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/AMarwen/PhpAlgo?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)
 > Php Algo is a library that consist of a single file that contain a set of functions that will do a Complex things for you and return a simple to understand result.just with a simple function Call.

php has a lot of built in functions but sometimes we need a function that did a custom thing that php built in function can't , so bottomline :
if you search for a function that do a specific thing for you , you may found it in this library:

 for ex axample we suppose that we we want to highlight a specific string in syntax to do so we can call a simple function which will do that for us instead of losing our time writing one from scratch : 

in the Example below the function will search for each instance of `php` in `php and the php World, yahoo with php .` then it will highlight it using the `highlightClass` class :

```php
echo PhpAlgo\CSS\highlightMatches("php","php and the php World, yahoo with php .",'highlightClass');}
```
**Output :**

![phpAlgo_1](http://imagizer.imageshack.us/v2/337x52q90/901/wrSJkq.jpg)
