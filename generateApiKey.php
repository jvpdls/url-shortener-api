<?php

/**
 * Generates a random API key.
 *
 * @return string The generated API key.
 */
function generateApiKey()
{
    $apiKey = bin2hex(random_bytes(32));
    return $apiKey;
}

/**
 * Updates the API key in the .env file.
 *
 * @param string $apiKey The API key to be updated.
 * @return void
 */
function updateApiKeyInEnvFile($apiKey)
{
    $envFilePath = './.env';

    // Create .env file if it doesn't exist
    if (!file_exists($envFilePath)) {
        $defaultEnvContent = "API_KEY = " . $apiKey . "\n";
        if (file_put_contents($envFilePath, $defaultEnvContent) === false) {
            echo "Failed to create .env file. Please check the file path and permissions.\n";
            return;
        }
    }

    $envContent = file_get_contents($envFilePath);
    $updatedEnvContent = preg_replace('/API_KEY = (.*)/', 'API_KEY = ' . $apiKey, $envContent);

    if (file_put_contents($envFilePath, $updatedEnvContent) === false) {
        echo "Failed to write to .env file. Please check the file path and permissions.\n";
    }
}

$apiKey = generateApiKey();
updateApiKeyInEnvFile($apiKey);

echo "\n" . "Generated API Key: " . $apiKey . "\n";
echo "This API Key will disappear in 30 seconds.\n";

sleep(30);
system('clear');

echo "\n" . "API Key has been removed from screen.\n";
