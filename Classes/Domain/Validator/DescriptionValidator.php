<?php
namespace NITSAN\NsT3dev\Domain\Validator;

final class DescriptionValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{
    protected function isValid(mixed $value): void
    {
        // $value is the title string
        if (str_starts_with('_', $value)) {
            $errorString = 'The description may not start with an underscore. ';
            $this->addError($errorString, 1297418976);
        }
    }
}