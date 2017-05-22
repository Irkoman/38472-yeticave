<?php

/**
 * Class LotForm
 */
class LotForm extends BaseForm
{
    public $formName = 'lot';

    protected $fields = ['lot-date', 'category', 'lot-name', 'message', 'lot-file', 'lot-rate', 'lot-step'];

    protected $rules = [
        ['number', ['lot-rate', 'lot-step', 'category']],
        ['date', ['lot-date']],
        ['image', 'lot-file'],
        ['required', ['lot-date', 'category', 'lot-name', 'message', 'lot-file', 'lot-rate', 'lot-step']],
    ];

    /**
     * Проверяет числовые поля на корректность
     * @param array $fields Список полей для проверки
     * @return bool Результат проверки
     */
    protected function runNumberValidator($fields)
    {
        $result = true;

        foreach ($fields as $value) {
            $field = $this->formData[$value];

            if (!filter_var($field, FILTER_VALIDATE_INT)) {
                $result = false;

                $this->errors[$value] = 'Здесь должно быть число';
            }
        }

        return $result;
    }

    /**
     * Проверяет поля с датами на корректность
     * @param array $fields Список полей для проверки
     * @return bool Результат проверки
     */
    protected function runDateValidator($fields)
    {
        $result = true;

        foreach ($fields as $value) {
            $field = $this->formData[$value];
            $date = date_parse_from_format('d.m.Y', $field);

            if (!checkdate($date['month'], $date['day'], $date['year'])) {
                $result = false;

                $this->errors[$value] = 'Некорректная дата';
            }
        }

        return $result;
    }

    /**
     * Проверяет, что загруженный файл является изображением
     * @param string $field Полe с изображением
     * @param string $allowed_mime Допустимые mime_type
     * @return bool Результат проверки
     */
    protected function runImageValidator($field, $allowed_mime = '')
    {
        $result = false;

        if (!empty($_FILES)) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/tiff'];

            if ($allowed_mime) {
                $allowed_types = [$allowed_mime];
            }

            $file = $_FILES[$field];

            if ($file['tmp_name']) {
                $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($fileinfo, $file['tmp_name']);
                $result = in_array($mime, $allowed_types);
            }

            if ($result) {
                move_uploaded_file($file['tmp_name'], 'img/' . $file['name']);
            } else {
                $this->errors[$field] = 'Допустимые форматы изображений: jpeg, png, gif, tiff';
            }
        }

        return $result;
    }
}
