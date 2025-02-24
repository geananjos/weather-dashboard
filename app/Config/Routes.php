<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rota para exibir a página inicial do clima (homepage)
$routes->get('/', 'WeatherController::index');

// Rota para exibir o formulário de busca do clima
$routes->get('weather', 'WeatherController::index');

// Rota para buscar os dados do clima por cidade
$routes->get('weather/getWeatherData', 'WeatherController::getWeatherData');