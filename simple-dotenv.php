<?php

function simple_load_dotenv($dotenv_base_path = "", $dotfile = ".evn")
{
    if (!$dotenv_base_path) {
        $dotenv_base_path = getenv('DOTENV_LOCATION');
    }
    //if defined an server/apache ENV
    $dotenv_base_path = rtrim($dotenv_base_path, '/');
    if (file_exists($dotenv_base_path . '/.env')) {
        $dotenv_data = file($dotenv_base_path . '/.env');
    } else if (file_exists($_SERVER['DOTENV_FILE'] . '/.env')) {
        $dotenv_data = file($_SERVER['DOTENV_FILE'] . '/.env');
    } else if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/.env')) {
        $dotenv_data = file($_SERVER['DOCUMENT_ROOT'] . '/.env');
    } else if (file_exists(__DIR__ . '/.env')) {
        $dotenv_data = file(__DIR__ . '/.env');
    } else {
        die("dotenv file not found");
    }
    if (is_array($dotenv_data)) {
        foreach ($dotenv_data as $line) {
            if (preg_match('/^[a-z_\-0-9\_\.\-].*/i', $line)) {
                preg_match('/^(.*?)=[\"\']?([a-z_\-0-9\_\.\-\s\/\$\{\}\:]+)?[\"\']?/i', $line, $matches);
                $_ENV[$matches[1]] = trim($matches[2]);
                $$matches[1]       = $_ENV[$matches[1]];
            }
        }
        foreach ($_ENV as $k => $v) {
            if (preg_match('/.*\$\{.*/', $v)) {
                eval("\$str = \"$v\";");
                $_ENV[$k] = $str;
            }
            defined($k) || define($k, $_ENV[$k]);
        }
    }
}