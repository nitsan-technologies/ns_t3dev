<?php

namespace NITSAN\NsT3dev\Domain\Validator;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * Validator based on Compare Captcha.
 */
class CompareCaptchaValidator extends AbstractValidator
{
    protected $acceptsEmptyValues = false;
    /**
     * @var array
     */
    protected $supportedOptions = [
        'captchaCompare' => ['', 'The captchaCompare to use for validation Captcha', 'string', true],
        'errorMessage' => ['', 'Error Message to show when validation fails', 'string', false],
    ];

    /**
     * Checks if the given value matches the specified regular expression.
     *
     * @param mixed $value The value that should be validated
     * @throws \TYPO3\CMS\Extbase\Validation\Exception\InvalidValidationOptionsException
     */
    public function isValid($value)
    {
        if ($this->options['captchaCompare'] != $value || trim($value)=='') {
            $errorMessage = $this->getErrorMessage();
            $this->addError(
                $errorMessage,
                1221565130
            );
        }
    }

    protected function getErrorMessage(): string
    {
        $errorMessage = (string)($this->options['errorMessage'] ?? '');
        return $this->translateErrorMessage(
            $errorMessage,
            'extbase'
        );
    }
}
