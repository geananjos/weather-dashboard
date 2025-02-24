<?php

namespace App\Controllers;

use App\Models\WeatherModel;
use CodeIgniter\Controller;

class WeatherController extends Controller
{
    protected $weatherModel;

    public function __construct()
    {
        $this->weatherModel = new WeatherModel();
    }

    public function index()
    {
        log_message('info', 'Acessando o método index()');

        $city = $this->request->getVar('city');
        log_message('debug', 'Cidade recebida: ' . ($city ?? 'Nenhuma'));

        $weatherData = null;

        if ($city) {
            log_message('info', "Buscando dados no banco para a cidade: {$city}");
            $weatherData = $this->weatherModel->where('city', $city)->orderBy('recorded_at', 'DESC')->first();

            if (!$weatherData) {
                log_message('info', "Nenhum dado encontrado no banco. Consultando API para: {$city}");

                $apiKey = '';
                $apiUrl = "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric&lang=pt_br";

                $client = \Config\Services::curlrequest();

                try {
                    $response = $client->get($apiUrl);
                    log_message('debug', 'Resposta da API recebida');

                    if ($response->getStatusCode() === 200) {
                        $weatherJson = json_decode($response->getBody(), true);
                        log_message('debug', 'Dados da API decodificados com sucesso');

                        if (isset($weatherJson['main'])) {
                            $weatherData = [
                                'city' => $weatherJson['name'],
                                'temperature' => $weatherJson['main']['temp'],
                                'humidity' => $weatherJson['main']['humidity'],
                                'weather_description' => $weatherJson['weather'][0]['description'],
                                'recorded_at' => date('Y-m-d H:i:s')
                            ];

                            $this->weatherModel->insert($weatherData);
                            log_message('info', "Dados inseridos no banco para: {$city}");
                        }
                    } else {
                        log_message('error', "Erro na API OpenWeather: Código {$response->getStatusCode()}");
                    }
                } catch (\Exception $e) {
                    log_message('critical', 'Erro ao acessar a API: ' . $e->getMessage());
                }
            }
        }

        $weatherDataFromDb = $this->weatherModel->findAll();
        log_message('info', 'Enviando dados para a view');

        return view('weather_view', [
            'weatherData' => $weatherDataFromDb
        ]);
    }

    public function getWeatherData()
    {
        log_message('info', 'Acessando getWeatherData()');
    
        $city = $this->request->getGet('city');
        log_message('debug', 'Cidade recebida: ' . ($city ?? 'Nenhuma'));
    
        if (!$city) {
            log_message('error', 'Cidade não fornecida na requisição');
            return redirect()->to('/weather');
        }
    
        log_message('info', "Buscando no banco os dados para: {$city}");
        $weatherData = $this->weatherModel->where('city', $city)->orderBy('recorded_at', 'DESC')->first();
    
        if (!$weatherData) {
            log_message('info', "Nenhum dado encontrado para {$city}, consultando API");
    
            $apiKey = '';
            $apiUrl = "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric&lang=pt_br";
    
            $client = \Config\Services::curlrequest();
    
            try {
                $response = $client->get($apiUrl);
                log_message('debug', 'Resposta da API recebida');
    
                if ($response->getStatusCode() !== 200) {
                    log_message('error', "Erro na API OpenWeather: Código {$response->getStatusCode()}");
                    return redirect()->to('/weather'); // Redireciona de volta caso erro na API
                }
    
                $weatherJson = json_decode($response->getBody(), true);
                log_message('debug', 'Dados da API decodificados com sucesso');
    
                if (isset($weatherJson['main'])) {
                    $weatherData = [
                        'city' => $weatherJson['name'],
                        'temperature' => $weatherJson['main']['temp'],
                        'humidity' => $weatherJson['main']['humidity'],
                        'weather_description' => $weatherJson['weather'][0]['description'],
                        'recorded_at' => date('Y-m-d H:i:s')
                    ];
    
                    $this->weatherModel->insert($weatherData);
                    log_message('info', "Dados salvos no banco para: {$city}");
                }
            } catch (\Exception $e) {
                log_message('critical', 'Erro ao acessar a API: ' . $e->getMessage());
                return redirect()->to('/weather'); // Redireciona em caso de erro na API
            }
        }
    
        return redirect()->to('/weather')->with('weatherData', $weatherData);
    }
}