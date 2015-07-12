[![Build Status](https://travis-ci.org/AMarwen/PhpAlgo.svg?branch=master)](https://travis-ci.org/AMarwen/PhpAlgo)
[![Latest Stable Version](https://poser.pugx.org/phpalgo/phpalgo/v/stable)](https://packagist.org/packages/phpalgo/phpalgo) [![Total Downloads](https://poser.pugx.org/phpalgo/phpalgo/downloads)](https://packagist.org/packages/phpalgo/phpalgo) [![Latest Unstable Version](https://poser.pugx.org/phpalgo/phpalgo/v/unstable)](https://packagist.org/packages/phpalgo/phpalgo) [![License](https://poser.pugx.org/phpalgo/phpalgo/license)](https://packagist.org/packages/phpalgo/phpalgo)

# String
### 1. remove all spaces from a string

[![Join the chat at https://gitter.im/AMarwen/PhpAlgo](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/AMarwen/PhpAlgo?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
**Syntax :**
 ```php
  string  PhpAlgo\Str\removeallSpaces(string $str);
 ```
   - **Description :** Remove all spaces from a string.
   - **Parameters :**
     - **$str :** the string that you want to remove all spaces from.
   - **Return Value :** return a string without any single space.

**Example :**
 ```php
   $str = PhpAlgo\Str\removeallSpaces("all     spaces will     be removed    from this       string") ;
   echo $str;
 ```
 **Output :**
```
 allspaceswillberemovedfromthisstring
```

