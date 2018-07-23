# Silicon Framework

In the era of growing number of regulations, privacy awareness and security
restrictions we felt like it was a good time to introduce the new and
responsible approach to handle sensible data while developing custom tailored
solutions. Our goal is to handle good security and privacy management practices 
and to do it in a way the will make app development and maintenance simpler 
instead of making it harder or more complicated.

Silicon can be viewed as a glue layer between [Laravel](https://laravel.com/) 
and [Keycloak](https://www.keycloak.org). Those technologies combined
provide every required aspect to handle application security, identity 
management and ease of development. It is simple to develop new features and
maintain the app and most probably Silicon will boost your performance but
it's not aimed at everyone, especially not at coding beginners.

Silicon does not reinvent concepts, it just stands on shoulders of giants. 
What it provides is the separation of concerns and modular 
[Laravel](https://laravel.com/) code divided into bundles with security and
identity management concepts included by design. It would probably require
some effort (although it's possible) to include Silicon into an existing 
project but if you are thinking about creating a fresh codebase or new API / 
webapp version it may be a choice worth considering.

## Core benefits

* GDPR friendly (and probably other regulations also)

## Caveats

## How it works

Silicon provides several built-in services that introduce security oriented
code bundles into [Laravel](https://laravel.com/). Concept is somewhat similar
to the [Symfony bundle system](https://symfony.com/doc/3.3/bundles.html). In
[Symfony](https://symfony.com/) world those are considered a legacy feature 
(for a good reason), but in Silicon they play different role than just 
separation of concerns thus they are still relevant and innovative.

Each bundle (or `extensions` - as they are called in Silicon world) besides
a service provider provide entry point class that extends base
`Newride\Silicon\bundles\extensions\Extension`. In their essence, bundles are
automatically registered [Laravel packages](https://laravel.com/docs/5.6/packages)
with built-in additional Silicon features. Extension is the place to register 
[Laravel](https://laravel.com/) policies and provide simple entry point to
check if user has sufficient permissions to use the entire bundle. Users are 
not stored in the application database, they are retrieved by using 
[Keycloak's](https://www.keycloak.org) OAuth access token.

Good practice is to assign a different role to each bundle to easily build
and maintain modular application. For example if your app consist of blog and 
shop you can have two extensions: `shop` and `blog` and `view-shop`, 
`view-blog` roles respectively. Extension entry point should make one or two 
generic checks to cut off access to the extension completely. More specific
permissions, access control lists etc should be moved to 
[Laravel's security policies](https://laravel.com/docs/5.6/authorization#creating-policies).

Given such basic code organisation, your application would not store any 
personal data and be divided into modules with several layers of flexible
security checks.
