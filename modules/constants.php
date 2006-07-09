<?php

/**
 * The Constants Definition File.
 *
 * This is where application-specific constants (i.e. constants to be used throughout the web application).
 * For example, it is recommended that you place here the types of the user so that it won't be hardcoded.
 * As for the convention of defining configuration constants, names of the constants must be all uppercase,
 * affixed by the module (a part of the program) that uses it, and USE UNDERSCORES.
 *
 */

/**
 * NOTE: The ENUM type in MySQL have integer equivalents, just like in C. For example, a type of ENUM('FEMALE', 'MALE') in
 * a column of gender can have values of '1' or 'FEMALE', and '2' or 'MALE'.
 *
 */

/* user positions */
define('USER_VOTER', 1);
define('USER_ADMIN', 2);

/* used in confirmvote.do */
define('NO', 0);
define('YES', 1);

?>