## Objetivo
O objetivo desse codigo fonte e aprender o basico de como o CodeIgniter 4 funciona e compreender sua estrutura de arquivos. Com isso foi aprendido:
✔ Consumo de APIs externas  
✔ Manipulação de dados e armazenamento no banco
✔ Uso de gráficos para visualização dinâmica
✔ Conhecimento de **frontend + backend** com o framework usando PHP 8.4 + CodeIgniter 4

## **🛠️ Tecnologias utilizadas**

- **CodeIgniter 4** → Para a API e backend
- **OpenWeather API** → Para obter os dados climáticos
- **MySQL** → Para armazenar histórico
- **Bootstrap/Tailwind + Chart.js** → Para o dashboard

---

## **📌 Funcionalidades do Projeto**

### ✅ 1. Consulta de Clima por Cidade 🌎

- O usuário digita o nome da cidade, e a API busca os dados no **OpenWeather**.

### ✅ 2. Exibição de Temperatura e Condições ☀️🌧️

- Mostra temperatura atual, sensação térmica, umidade e previsão.

### ✅ 3. Histórico de Pesquisas 📜

- Guarda as últimas cidades pesquisadas no banco de dados.

### ✅ 4. Dashboard com Gráficos 📊

- Exibição de temperatura das últimas buscas usando **Chart.js**.

## Passos para execucao do projeto

1. Colocar a pasta do projeto devidamente na pasta do Xampp ou Wamp.
2. Criar um banco de dados chamado weather_db e configurar no arquivo Database.php
3. Gerar um Api Key da OpenWeather e colocaca-la na variavel apiKey no arquivo WeatherController.php