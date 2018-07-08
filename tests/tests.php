<?php

require __DIR__ . "/../vendor/autoload.php";

// define your logger parameters here
const LOG_CHANNEL_NAME = "test";
const LOG_FILE_NAME = __DIR__ . "/logs/tests.log";
const LOG_ERROR_LEVEL = \Monolog\Logger::DEBUG;
const LOG_DATE_FORMAT = "Y-m-d H:i:s";
const LOG_OUTPUT_FORMAT = "[%datetime%] %channel%.%level_name%: %message%\n";

$logger = \FC\Logger\Log::getLogger(
    LOG_CHANNEL_NAME, 
    LOG_FILE_NAME, 
    LOG_ERROR_LEVEL,
    LOG_DATE_FORMAT,
    LOG_OUTPUT_FORMAT
);

if (\FC\Logger\Log::isReady()) {
    $logger->debug("DEBUG level");
    $logger->info("INFO level");
    $logger->notice("NOTICE level");
    $logger->warning("WARNING level");
    $logger->error("ERROR level");
    $logger->critical("CRITICAL level");
    $logger->alert("ALERT level");
    $logger->emergency("EMERGENCY level");
}

print "Done.";

