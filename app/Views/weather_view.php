<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Dashboard</title>

    <!-- Carregar o TailwindCSS para o layout -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">

    <!-- Carregar o Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-4xl font-bold mb-6 text-center">Consulta de Clima</h1>

        <!-- Formulário para buscar clima por cidade -->
        <form action="<?= site_url('weather/getWeatherData') ?>" method="get" class="mb-6">
            <input type="text" name="city" placeholder="Digite a cidade" class="p-2 border rounded" required>
            <button type="submit" class="ml-2 p-2 bg-blue-500 text-white rounded">Buscar</button>
        </form>

        <!-- Exibir o histórico de consultas climáticas -->
        <h2 class="text-2xl font-semibold mb-4">Histórico de Clima</h2>
        <?php if (count($weatherData) > 0): ?>
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">Cidade</th>
                        <th class="px-4 py-2">Temperatura (°C)</th>
                        <th class="px-4 py-2">Umidade (%)</th>
                        <th class="px-4 py-2">Descrição</th>
                        <th class="px-4 py-2">Data de Registro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($weatherData as $data): ?>
                        <tr class="border-b">
                            <td class="px-4 py-2"><?= esc($data['city']); ?></td>
                            <td class="px-4 py-2"><?= esc($data['temperature']); ?>°C</td>
                            <td class="px-4 py-2"><?= esc($data['humidity']); ?>%</td>
                            <td class="px-4 py-2"><?= esc($data['weather_description']); ?></td>
                            <td class="px-4 py-2"><?= esc($data['recorded_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center text-gray-500">Nenhum dado de clima disponível.</p>
        <?php endif; ?>

        <!-- Gráfico com os dados -->
        <canvas id="weatherChart" class="mt-6"></canvas>
    </div>

    <script>
        // Criar o gráfico com dados do histórico
        var ctx = document.getElementById('weatherChart').getContext('2d');
        var weatherData = <?php echo json_encode($weatherData); ?>;

        // Preparar os dados para o gráfico
        var cities = weatherData.map(function(item) { return item.city; });
        var temperatures = weatherData.map(function(item) { return item.temperature; });
        var humidities = weatherData.map(function(item) { return item.humidity; });

        // Configuração do gráfico
        var weatherChart = new Chart(ctx, {
            type: 'line', // Tipo de gráfico (linha)
            data: {
                labels: cities, // Labels do eixo X (cidades)
                datasets: [
                    {
                        label: 'Temperatura (°C)',
                        data: temperatures, // Dados de temperatura
                        borderColor: 'rgba(75, 192, 192, 1)', // Cor da linha
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        label: 'Umidade (%)',
                        data: humidities, // Dados de umidade
                        borderColor: 'rgba(255, 159, 64, 1)', // Cor da linha da umidade
                        borderWidth: 2,
                        fill: false,
                        borderDash: [5, 5] // Linha tracejada
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Cidade'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Valor'
                        },
                        min: 0, // Começar do valor mínimo 0
                    }
                },
                plugins: {
                    legend: {
                        position: 'top', // Posição da legenda
                    }
                }
            }
        });
    </script>
</body>
</html>
