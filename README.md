# Registration Data Access Protocol – core objects implementation package according to the RFC 7483

[![Latest Stable Version](https://poser.pugx.org/hiqdev/rdap/v/stable)](https://packagist.org/packages/hiqdev/rdap)
[![Total Downloads](https://poser.pugx.org/hiqdev/rdap/downloads)](https://packagist.org/packages/hiqdev/rdap)
[![Build Status](https://img.shields.io/travis/hiqdev/rdap.svg)](https://travis-ci.org/hiqdev/rdap)
[![Scrutinizer Code Coverage](https://img.shields.io/scrutinizer/coverage/g/hiqdev/rdap.svg)](https://scrutinizer-ci.com/g/hiqdev/rdap/)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/hiqdev/rdap.svg)](https://scrutinizer-ci.com/g/hiqdev/rdap/)

## RDAP server library

This PHP library makes it very easy to build an RDAP server that talks with your registry back-end.

# Features
* Include this library in your PHP web application to significantly ease implementing an RDAP server and client
* Can be combined with any back-end by simply implementing one or more methods
* All you need to do is retrieve the data and populate some PHP objects

## Installation

The preferred way to install this project is through [composer](http://getcomposer.org/download/).

```sh
php composer.phar require hiqdev/rdap:dev-master
```

or add

```
"hiqdev/rdap": "dev-master"
```
to the require section of your composer.json.

# Details

This library understands and supports the following RFC's:

* [RFC-7480 : HTTP Usage in the Registration Data Access Protocol (RDAP)](http://tools.ietf.org/html/rfc7480)
* [RFC-7481 : Security Services for the Registration Data Access Protocol (RDAP)](http://tools.ietf.org/html/rfc7481)
* [RFC-7482 : Registration Data Access Protocol (RDAP) Query Format](http://tools.ietf.org/html/rfc7482)
* [RFC-7483 : JSON Responses for the Registration Data Access Protocol (RDAP)](http://tools.ietf.org/html/rfc7483)
* [RFC-7484 : Finding the Authoritative Registration Data (RDAP) Service](http://tools.ietf.org/html/rfc7484)

# How it works

* The library contains a number of PHP objects representing the data structures defined in rfc7483
* You need to write the code to populate these objects whenever a query comes in

# How to use

We have created a sample project which could help you with your implementation. You can find both the source and instructions in the following project: [rdap-server-example](https://github.com/hiqdev/rdap-server-example)

## Simple usage:
    
    use hiqdev\rdap\core\Infrastructure\Provider\DomainProviderInterface;
    use hiqdev\rdap\core\Domain\Constant\Role;
    use hiqdev\rdap\core\Domain\Entity\Domain;
    use hiqdev\rdap\core\Domain\ValueObject\DomainName;

    class DomainProvider implements DomainProviderInterface
    {
        /** @var object */
        private $domainInfo;
        
        public function get(DomainName $domainName): Domain
        {
            $domain = new Domain(DomainName::of($this->domainInfo->domainName));
            $domain->setPort43(DomainName::of($this->domainInfo->rdapServer));
            $domain->addEntity($this->domainInfo->getEntity(Role::REGISTRANT()));
            
            return $domain;
        }
    }

## License

This project is released under the terms of the BSD-3-Clause [license](LICENSE).
Read more [here](http://choosealicense.com/licenses/bsd-3-clause).

Copyright © 2019, HiQDev (http://hiqdev.com/)
