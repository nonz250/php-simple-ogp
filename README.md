# php-simple-ogp
simple ogp maker

## Contributing

Feel free to submit a Pull Request. However, please run the `make prod` command and check the test content before submitting your Pull Request.

## Development

We recommend using Docker for this project.

## Make Commands

### Initial Setup

```shell script
make setup
```

### Development Test

Testing under development.

```shell script
make test
```

### Code Fixer

```shell script
make fix
```

### Production Test

Test before you Pull Request.

```shell script
make prod
```

## How to use

For Example.

```php
$ogp = new \SimpleOgp\SimpleOgp('https://labo.nozomi.bike');
// Get web site content and set ogp values.
$ogp->getHtml();
// Get ogp title.
$title = $ogp->title();
// Get ogp description.
$description = $ogp->description();
// Get ogp image path.
$imagePath = $ogp->imagePath();
```
