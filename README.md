# Email Blur

This is version 2, derived from `wobeto/email-blur`.

To install via composer, run:

```
# composer require dillchuk/email-blur
# composer install
```

Use with default mask:

```php
<?php

include 'vendor/autoload.php';
use Wobeto\EmailBlur\Blur;

$blur = new Blur();
$obscured = $blur->make('example@test.com');
var_dump($obscured); // exa***@t***.com
```

Use with mask changed:

```php
$blur = new Blur(mask: '<REDACTED>');
$obscured = $blur->make('example@test.com');

var_dump($obscured); // exa<REDACTED>@t<REDACTED>.com
```

Handles free email providers:

```php
$blur = new Blur();
$obscured = $blur->make('example@gmail.com');
var_dump($obscured); // exa***@gmail.com

$blur = new Blur(maskFree: true);
$obscured = $blur->make('example@gmail.com');
var_dump($obscured); // exa***@gm***.com
```

Handles second-level domains:

```php
$blur = new Blur();
$obscured = $blur->make('example@example.co.uk');
var_dump($obscured); // exa***@exa***.co.uk
```

See additional configuration options in the constructor.
- `mask`
- `maskDomain`
- `maskFree`
