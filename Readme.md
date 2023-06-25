# Copyleaks V3 API integration with laraval 8+
A package for integrating Copyleaks plagiarism checker easily in your Laravel app
## Requirements

- PHP 7.4 or above.
- Laravel 8 or above.

## Installation

You can install the package using composer.

```bash
composer require davido/pgchecker
```

You can also add the follow line to you composer.json file and save.

```
...
"davido/pgchecker": "dev-master"
...
```
Then run this command to update composer.
```
composer update
```

You need to also publish the config files

```
php artisan vendor:publish --provider="DavidO\PGChecker\PGCheckerServiceProvider" --tag="config"
```

## Setup
 
1. Sign up on the [Copyleaks website](https://auth.copyleaks.com/account/login).

2. Visit [Copyleaks API Dashboard](https://api.copyleaks.com/dashboard) to generate your api keys.

3. If you previously publish the config file, you must have noticed a new file (config/copyleaks.php) you can edit the config file, or add the following to your .env file.

    ```COPYLEAKS_EMAIL=your_copyleaks_email```

    ```COPYLEAKS_KEY=your_copyleaks_api_key```

    ```COPYLEAKS_SANDBOX=false```

    ```COPYLEAKS_WEBHOOK_BASE=ngrok_url_for_localhost_testing```

## Usage

You can use the following code to scan text and and you get a json data as a response
 
```
PGChecker::scanText("A long text to scan for plagiarism");
```

You can use also submit text for scan only without getting the result immediately.
 
```
PGChecker::submitText("A long text to scan for plagiarism");
```

this will return a unique scan id that can be used to retrieve the result later using the following code.

```
PGChecker::retrieveResult($scanId)
```

## How it works

Under the hood the package authenticate the user with copyleaks and then submits the file or text for scanning, the scanned results are receive via a webhook and the result is saved in the cache using the cache settings defined in the laravel package.

The scan results can be retrieved immediately or later with the unique scan id provided.


## Local Setup and Testing

Since copyleaks uses webhook to return result, on local we will need a ngrok to retrieve the API result.

On mac use,

```
brew install ngrok
```

to install ngrok.

Then start ngrok server using,

```
ngrok http 8002
```

also start a local server on the same port using,

```
php artisan serve --port=8002
```

also update the url gotten from ngrok as the in the .env file

 ```COPYLEAKS_WEBHOOK_BASE=https://example.com```

 we only need this for testing purpose and never forget to remove the variable in staging or production environment.


