# Request Resolver Bundle

[![Build Status](https://travis-ci.org/CodingCulture/request-resolver-bundle.svg?branch=master)](https://travis-ci.org/CodingCulture/request-resolver-bundle)

This Symfony bundle tries to make request assertion a little bit easier.

This bundle is still a work in progress.

PHP7+ only.

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

- [ ] Test RequestResolver.php
- [ ] Symfony Flex support