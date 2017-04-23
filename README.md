MediaBundle
=============
The **MediaBundle** is media library for managing entity files. Use it on your risk.

| SensioLabs Insight | Travis CI | Scrutinizer CI|
| ------------------------|-------------|-----------------|
|[![SensioLabsInsight](https://insight.sensiolabs.com/projects/b7db0a5f-09a4-4c10-a01b-98dcbb37aa36/mini.png)](https://insight.sensiolabs.com/projects/b7db0a5f-09a4-4c10-a01b-98dcbb37aa36)|[![Build Status](https://travis-ci.org/development-x/MediaServiceProvider.svg?branch=master)](https://travis-ci.org/development-x/MediaServiceProvider)|[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/development-x/MediaBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/development-x/MediaBundle/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/development-x/MediaBundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/development-x/MediaBundle/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/development-x/MediaBundle/badges/build.png?b=master)](https://scrutinizer-ci.com/g/development-x/MediaBundle/build-status/master)

[![Latest Stable Version](https://poser.pugx.org/development-x/media-bundle/v/stable)](https://packagist.org/packages/development-x/media-bundle) [![Total Downloads](https://poser.pugx.org/development-x/media-bundle/downloads)](https://packagist.org/packages/development-x/media-bundle) [![Latest Unstable Version](https://poser.pugx.org/development-x/media-bundle/v/unstable)](https://packagist.org/packages/development-x/media-bundle) [![License](https://poser.pugx.org/development-x/media-bundle/license)](https://packagist.org/packages/development-x/media-bundle) [![composer.lock](https://poser.pugx.org/development-x/media-bundle/composerlock)](https://packagist.org/packages/development-x/media-bundle)

# Features
- save uploaded file in to database via DoctrineORM
- all settings, templates and translations is highly customized

# Installation

### Step1: Download bundle
This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

```console
$ composer require development-x/media-bundle "~1"
```

### Step2: Enable bundle

```
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new MediaBundle\MediaBundle(),
        );

        // ...
    }

    // ...
}
```

### Step3: Edit configuration in config.yml
```
twig:
    form_themes:
        - 'MediaBundle:Form:fields.html.twig'
```

### Step4: Install bootstrap-fileinput js plugin
Plugin installation could be found [here](http://plugins.krajee.com/file-input#installation). When you done with install, just load js * css files
```
<link type="text/css" href="{{ asset('library/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet" media="all" />
```
```
<script type="text/javascript" src="{{ asset('library/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
```

# More configuration
- [Using CollectionType for hold files](doc/collection.md)

# Contributing
However, if you are interested and want to send a bug fix, new functionality or better realization, just send a pull request :)

# License
This bundle is under the MIT license. See the complete license [in the bundle](LICENSE)
