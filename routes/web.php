<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['as' => 'site'], function () use ($router) {
    $router->get('/', ['as' => 'home', 'uses' => 'SiteController@index']);
    $router->get('/services', ['as' => 'services', 'uses' => 'SiteController@services']);
    $router->get('/services/{slug}', ['as' => 'service', 'uses' => 'SiteController@service']);
    $router->get('/service-areas', ['as' => 'service-areas', 'uses' => 'SiteController@serviceAreas']);
    $router->get('/service-areas/{slug}', ['as' => 'service-area', 'uses' => 'SiteController@serviceArea']);
    $router->get('/quote', ['as' => 'quote', 'uses' => 'SiteController@quote']);
    $router->get('/contact', ['as' => 'contact', 'uses' => 'SiteController@contact']);
    $router->get('/how-it-works', ['as' => 'how-it-works', 'uses' => 'SiteController@howItWorks']);
    $router->get('/faq', ['as' => 'faq', 'uses' => 'SiteController@faq']);
    $router->get('/privacy-policy', ['as' => 'privacy-policy', 'uses' => 'SiteController@privacy']);
    $router->get('/terms', ['as' => 'terms', 'uses' => 'SiteController@terms']);
    $router->get('/thank-you', ['as' => 'thank-you', 'uses' => 'SiteController@thankYou']);
    $router->get('/sitemap.xml', ['as' => 'sitemap', 'uses' => 'SiteController@sitemap']);
    $router->get('/robots.txt', ['as' => 'robots', 'uses' => 'SiteController@robots']);
});
