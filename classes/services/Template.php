<?php
namespace yeticave\services;

/**
 * Class Template
 */
class Template
{
    /**
     * Ищет шаблон и возвращает HTML, который в нём содержится
     * @param string $path Путь к файлу шаблона
     * @param array $data Ассоциативный массив с данными
     * @return string HTML страницы
     */
    public static function render($path, $data)
    {
        if (!file_exists($path)) {
            return '';
        }

        Formatter::secureData($data);
        ob_start();
        include($path);
        $html = ob_get_clean();

        return $html;
    }
}
