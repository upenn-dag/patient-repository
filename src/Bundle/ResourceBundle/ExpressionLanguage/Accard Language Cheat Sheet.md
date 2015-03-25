Accard Language Cheat Sheet
============================

String Functions
-----------------

1.  **Encrypt**: encrypt(_str_)

    Encode a value, leaving an encrypted string in its place. This can be used to encrypt PHI data before it's sent to a client, while retaining the ability to reconstruct the data locally.

2.  **Hash**: hash(_str_)

    Encode a value, leaving an hashed value in its place. Unlike (encrypt link), these values can not be reconstructed.

3.  **Lower**: lower(_str_)

    Convert a string into lowercase.

4.  **Lower first**: lower_first(_str_)

    Convert the first character in a string to lowercase.

5.  **Trim**: trim(_str_ [, _chars_])

    Remove whitespace from the beginning and end of a string.

6.  **Upper**: upper(_str_)

    Convert a string into uppercase.

7.  **Upper first**: upper_first(_str_)

    Convert the first character in a string to uppercase.

8.  **Upper words**: upper_words(_str_)

    Convert the first character of each word in a string to uppercase.


Integer functions
------------------

1.  **abs**: abs(int)

    Get the absolute value of an integer.

2.  **acos**: acos(int)

    Get the arc cosine value of an integer.

3.  **asin**: asin(int)

    Get the arc sine value of an integer.

4.  **atan**: atan(int)

    Get the arc tan value of an integer.

5.  **ceil**: ceil(int)

    Round a decimal up to the nearest whole.

6.  **cos**: cos(int)

    Get the cosine value of an integer.

7.  **exp**: exp(int)

    Calculate the exponent of an integer from "e".

8.  **floor**: floor(int)

    Round a decimal down to the nearest whole.

9.  **pow**: pow(int, power)

    Calculate an integer to the power of another integer.

10. **round**: round(int [, _precision_ [, _mode_]])

    Round an integer with optional precision and PHP mode. See (PHP link)[options]

11. **sin**: sin(int)

    Get the sine value of an integer.

12. **sqrt**: sqrt(int)

    Get the square root of an integer.

13. **tan**: tan(int)

    Find the tan value of an integer.
