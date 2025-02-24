<?php

namespace App\Models;

use CodeIgniter\Model;

class WeatherModel extends Model
{
    protected $table = 'weather_data';
    protected $primaryKey = 'id';
    protected $allowedFields = ['city', 'temperature', 'humidity', 'weather_description', 'recorded_at'];
    protected $returnType = 'array';
    protected $useTimestamps = false;
}
