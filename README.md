# Email Blur

To install via composer, run:

```
composer require wobeto/email-blur
```

Use with default mask:

```php
<?php

include 'vendor/autoload.php';

use Wobeto\EmailBlur\Blur;

$blur = new Blur('example@test.com');
    
$obscured = $blur->make();

var_dump($obscured); // exa***@***.com
```

Use with total mask changed:

```php
<?php

include 'vendor/autoload.php';

use Wobeto\EmailBlur\Blur;

$blur = new Blur('example@test.com');
$blur->setTotalMask(5);
    
$obscured = $blur->make();

var_dump($obscured); // exa*****@*****.com
```

Use with chaining methods:

```php
<?php

include 'vendor/autoload.php';

use Wobeto\EmailBlur\Blur;

$obscured = (new Blur('example@test.com'))
    ->setTotalMask(4)
    ->make();

var_dump($obscured); // exa****@****.com
```

Use with show domain option:

```php
<?php

include 'vendor/autoload.php';

use Wobeto\EmailBlur\Blur;

$obscured = (new Blur('example@test.com'))
    ->showDomain()
    ->make();

var_dump($obscured); // exa***@test.com
```

Enjoy...