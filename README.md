# Loan Interest Earnings Calculator

A system that allows investments to be made in tranches of a loan.

The system can work out interest earnings on a monthly basis. 

## Getting Started
The system has been built with Laravel.

Composer is required to set up the app.

To get up and running simply execute the following command in the project root:
```console
composer install
```
A hosting environment is required to view the app. The system was developed with Laradock which is easy to install.\
The hosting environment should point to the( public folder. Laradock will do this automatically if installed in the root folder of the project.
(See Laradock instructions to setup that docker environment)

## Example implementation of the custom classes
The following classes have been created:
app\Classes\Loan.php\
app\Classes\Tranche.php\
app\Classes\Investor.php\
app\Classes\Investment.php\
app\Classes\InvestmentManager.php\

The implementation of the classes is demonstrated below.

Set up our loan with time period.
```php
$loan = new Loan("2020-10-01", "2020-11-15");
```

Set up a tranche with name, interest rates & available amount.
```php
$trancheA = new Tranche("Tranche A", 3, 1000);
```

Add the tranche to this loan.
```php
$loan->addTranche($trancheA);
```

Create an investor.
```php
$investor1 = new Investor("Investor 1");
```

Create the investment manager instance.
```php
$investmentManager = new InvestmentManager($loan);
```

Make an investment.
```php
$investmentManager->makeInvestment("2020-10-03", $trancheA, $investor1, 1000);
```

Get interest earned in an associate array from the investment manager instance passing in a month and year values as integers.
```php
$earningsArr = $investmentManager->getInterestEarned($month, $year)
```
##	To run the automated tests
PHPUnit tests for the custom classes have been provided in the test\ directory.

The following command should run these automated unit tests:
```console
./vendor/bin/phpunit tests
```

## Version history
v1.0 - 22 October 2020: Initial Version. 


### Prerequisites
- PHP 7.3 is required 
- Composer is required to install the app

Tested with PHP 7.4.11

## Built With

* [Composer](https://getcomposer.org/) - PHP Dependency manager
* [Laravel](https://laravel.com/) - The php framework used
* [PHPUnit](https://phpunit.de/) - The testing framework used
* [Laradock](https://laradock.io/) - Docker Development environment for PHP
* [Bootstrap 4](https://getbootstrap.com/docs/4.0/getting-started/introduction/) - Bootstrap styles

## Authors

* **[Andrew Nicholson](https://github.com/agdnicholson)**