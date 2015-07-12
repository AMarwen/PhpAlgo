[![Build Status](https://travis-ci.org/AMarwen/PhpAlgo.svg?branch=master)](https://travis-ci.org/AMarwen/PhpAlgo)


# String
### 1. remove all spaces from a string
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

