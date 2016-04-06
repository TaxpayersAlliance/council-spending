# Taxpayers' Data

This is an open API from the TaxPayers' Alliance

This has been built using the Laravel framework. Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Council Spending

This dataset is an archive of historic TPA research into local authorities.

GET requests to [Taxpayers' Data](http://taxpayersdata.com) should be of the following format:
taxpayersdata.com/api/v1/$postcode/$bool

$postcode should be a string with no spaces, ie SW1A1AA
$bool sould be either true or false. Treu returns a formatted, verbose string output, false returns raw data.

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to info@taxpayersalliance.com. All security vulnerabilities will be promptly addressed.
