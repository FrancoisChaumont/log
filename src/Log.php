<?php

namespace FC\Logger;

/**
 * Log class based on Monolog to handle writing logs to file
 */
final class Log
{
    const DEFAULT_CHANNEL_NAME = "general";
    const DEFAULT_FILE_NAME = __DIR__ . "/logs/default.log";
    const DEFAULT_ERROR_LEVEL = \Monolog\Logger::DEBUG;
    const DEFAULT_DATE_FORMAT = "Y-m-d H:i:s";
    const DEFAULT_OUTPUT_FORMAT = "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n";

    private static $ready = false;

    /**
     * State reflecting that the logger is ready to write to the log file (file permissions...)
     *
     * @return boolean
     */
    public static function isReady(): bool
    {
        return self::$ready;
    }

    /**
     * Get an instance of the logger
     *
     * @param string $channelName channel name (appears in the logs to help determine where the log is coming from)
     * @param string $logFileName log file name
     * @param integer $logErrorLevel error level of the log to be written
     * @param string $dateFormat format for the output date
     * @param string $outputFormat format for the output text
     * @return null|\Psr\Log\LoggerInterface
     */
    public static function getLogger(
        string $channelName = self::DEFAULT_CHANNEL_NAME, 
        string $logFileName = self::DEFAULT_FILE_NAME, 
        int $logErrorLevel = self::DEFAULT_ERROR_LEVEL, 
        string $dateFormat = self::DEFAULT_DATE_FORMAT, 
        string $outputFormat = self::DEFAULT_OUTPUT_FORMAT
    ): ?\Psr\Log\LoggerInterface
    {
        $logger = null;

        try {
            // make sure the file exists and has the right permissions to be written
            if (file_put_contents($logFileName, '', FILE_APPEND) === false) {
                throw new Exceptions\LogFileNotFoundException($logFileName);
            }

            $logger = new \Monolog\Logger($channelName);

            $stream = new \Monolog\Handler\StreamHandler($logFileName, $logErrorLevel);
            $stream->setFormatter(self::initFormatter($dateFormat, $outputFormat));

            $logger->pushHandler($stream);

            self::$ready = true;
        } catch (\Exception $e) {
            self::$ready = false;
        }

        return $logger;
    }

    /**
     * Initialize predefined or customized log text format
     *
     * @param string $dateFormat
     * @param string $outputFormat
     * @return \Monolog\Formatter\FormatterInterface
     */
    private static function initFormatter(string $dateFormat, string $outputFormat): \Monolog\Formatter\FormatterInterface
    {
        // create a formatter
        $formatter = new \Monolog\Formatter\LineFormatter($outputFormat, $dateFormat);

        return $formatter;
    }
}

