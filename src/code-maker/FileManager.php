<?php
/**
 * This file is part of Zepgram\CodeMaker
 *
 * @package    Zepgram\CodeMaker
 * @file       FileManager.php
 * @date       31 08 2019 17:27
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker;


class FileManager
{
    public static function parseTemplate(string $templatePath, array $parameters): string
    {
        ob_start();
        extract($parameters, EXTR_SKIP);
        include $templatePath;

        return ob_get_clean();
    }

    public static function scanDir($directory)
    {
        return array_diff(scandir($directory), ['..', '.']);
    }

    public static function mkdir($directory)
    {
        if (is_dir($directory)) {
            return;
        }
        if (!mkdir($concurrentDirectory = $directory) && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }
    }

    public static function writeFiles($filePath, $content)
    {
        $exploded = explode(DIRECTORY_SEPARATOR,$filePath);
        array_pop($exploded);
        $directoryPathOnly = implode(DIRECTORY_SEPARATOR,$exploded);
        if (!file_exists($directoryPathOnly)) {
            self::mkdir($directoryPathOnly);
        }
        file_put_contents($filePath, $content);
    }
}