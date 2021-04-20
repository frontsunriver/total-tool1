<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.11
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\components\validators;

use Yii;
use yii\validators\FileValidator as BaseFileValidator;
use yii\web\UploadedFile;

/**
 * Class FileValidator
 * @package app\components\validators
 */
class FileValidator extends BaseFileValidator
{

    /**
     * {@inheritdoc}
     */
    protected function validateValue($values)
    {

        if ($this->maxFiles != 1 || $this->minFiles > 1) {

            if (!is_array($values)) {
                return [$this->uploadRequired, []];
            }

            if (empty($values)) {
                return [$this->uploadRequired, []];
            }

            $filesCount = count($values);
            if ($this->maxFiles && $filesCount > $this->maxFiles) {
                return [
                    $this->tooMany,
                    ['limit' => $this->maxFiles],
                ];
            }

            if ($this->minFiles && $this->minFiles > $filesCount) {
                return [
                    $this->tooFew,
                    ['limit' => $this->minFiles],
                ];
            }

        }

        foreach ($values as $value) {

            if (!$value instanceof UploadedFile || $value->error == UPLOAD_ERR_NO_FILE) {
                return [$this->uploadRequired, []];
            }

            switch ($value->error) {
                case UPLOAD_ERR_OK:
                    if ($this->maxSize !== null && $value->size > $this->getSizeLimit()) {
                        return [
                            $this->tooBig,
                            [
                                'file' => $value->name,
                                'limit' => $this->getSizeLimit(),
                                'formattedLimit' => Yii::$app->formatter->asShortSize($this->getSizeLimit()),
                            ],
                        ];
                    } elseif ($this->minSize !== null && $value->size < $this->minSize) {
                        return [
                            $this->tooSmall,
                            [
                                'file' => $value->name,
                                'limit' => $this->minSize,
                                'formattedLimit' => Yii::$app->formatter->asShortSize($this->minSize),
                            ],
                        ];
                    } elseif (!empty($this->extensions) && !$this->validateExtension($value)) {
                        return [$this->wrongExtension, ['file' => $value->name, 'extensions' => implode(', ', $this->extensions)]];
                    } elseif (!empty($this->mimeTypes) && !$this->validateMimeType($value)) {
                        return [$this->wrongMimeType, ['file' => $value->name, 'mimeTypes' => implode(', ', $this->mimeTypes)]];
                    }

                    return null;
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    return [$this->tooBig, [
                        'file' => $value->name,
                        'limit' => $this->getSizeLimit(),
                        'formattedLimit' => Yii::$app->formatter->asShortSize($this->getSizeLimit()),
                    ]];
                case UPLOAD_ERR_PARTIAL:
                    Yii::warning('File was only partially uploaded: ' . $value->name, __METHOD__);
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    Yii::warning('Missing the temporary folder to store the uploaded file: ' . $value->name, __METHOD__);
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    Yii::warning('Failed to write the uploaded file to disk: ' . $value->name, __METHOD__);
                    break;
                case UPLOAD_ERR_EXTENSION:
                    Yii::warning('File upload was stopped by some PHP extension: ' . $value->name, __METHOD__);
                    break;
                default:
                    break;
            }

        }

        return [$this->message, []];
    }

}