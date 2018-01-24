# Request Resolver Bundle

[![Build Status](https://travis-ci.org/CodingCulture/request-resolver-bundle.svg?branch=master)](https://travis-ci.org/CodingCulture/request-resolver-bundle) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/77b920001474495283ba5fa974fc3835)](https://www.codacy.com/app/nielsvermaut/request-resolver-bundle?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=CodingCulture/request-resolver-bundle&amp;utm_campaign=Badge_Grade) [![Latest Stable Version](https://img.shields.io/packagist/v/codingculture/request-resolver-bundle.svg)](https://packagist.org/packages/codingculture/request-resolver-bundle) [![Total Downloads](https://img.shields.io/packagist/dt/codingculture/request-resolver-bundle.svg?)](https://packagist.org/packages/codingculture/request-resolver-bundle)

This Symfony bundle tries to make request assertion a little bit easier.

This bundle is still a work in progress.

PHP7.1+ only.

## Usage

```
<?php

...

class SomeController extends Controller
{
    public function someAction()
    {
        $request = $this->get('codingculture.requestresolver.resolver')->resolve(new SomeRequest());
        
        $request->getId();
    }
}
```

```
<?php

...

final class SomeRequest implements ResolvableRequestInterface
{
    private $options = [];
    
    public function getId(): string
    {
        return $this->options['id'];
    }

    public function defineOptions(OptionsResolver $resolver): OptionsResolver
    {
        $resolver->setRequired('id')
    }
    
    public function setOptions(array $options)
    {
        $this->options = $options;
    }
    
    public function getContentType(): string
    {
        return RequestResolver::CONTENT_TYPE_ALLOW_ALL;
    }
}
```

If a user sent a bad request, an InvalidArgumentException (or an extension of it) will be thrown on resolve method.

## Todo

- [ ] Write better docs
