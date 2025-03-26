# NWWeather

Receives, stores, distributes and displays weather data from weather stations that can send sensor data in the Wunderground format.

## Usage

The weather station (i.e. Ecowitt) sends its sensor data via an HTTP GET Request to the endpoint (`path-to-nwweather/endpoints/post/wunderground/v1/endpoint.php`).

NWWeather handles the data depending on the settings in `path-to-nwweather/sys/var/settings.php`: `NWWeatherSettings::relaisList`

### Relais

A relais defines what happens to the data. Currently implemented relais:

- `NWWRelaisWindy` - sends the data to `windy.com`
- `NWWRelaisSQLite`- stores the data in a local SQLite database (needed to display the weather date in the dashboard)
 - `NWWRelaisInfluxDB` - sends the data to InfluxDB

## Requirements

- PHP 8.2
- ext-sqlite3
- ext-curl
- nitricware\Tonic
- nilportugues\sql-query-builder

## Installation

1. Upload `scr/`
2. run `composer install`
3. Point the EcoWitt weather station to the api endpoint in `path-to-nwweather/endpoints/post/wunderground/v1/endpoint.php`