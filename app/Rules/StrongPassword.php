<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StrongPassword implements Rule
{
    /** @var int  */
    protected int $requiredHits = 3;

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
      $hits = 0;

      if ($this->hasLowerCaseLetter($value)) {
        $hits++;
      }

      if ($this->hasUpperCaseLetter($value)) {
        $hits++;
      }

      if ($this->hasDigit($value)) {
        $hits++;
      }

      if ($this->hasSpecialCharacter($value)) {
        $hits++;
      }

      return $hits >= $this->requiredHits;
    }

    /**
     * Get the validation error message.
     *
     * @return array|string
     */
    public function message(): string|array
    {
      return <<<MSG
  Must follow $this->requiredHits of the following rules:
  - At least 1 lowercase letter.
  - At least one uppercase letter.
  - At least 1 digit.
  - At least 1 special character
  MSG;
    }

    /**
     * hasLowerCaseLetter
     *
     * @param string $value
     * @return bool
     */
    protected function hasLowerCaseLetter(string $value): bool
    {
      return preg_match('/^.*[a-z].*$/', $value) === 1;
    }

    /**
     * hasUpperCaseLetter
     *
     * @param string $value
     * @return bool
     */
    protected function hasUpperCaseLetter(string $value): bool
    {
      return preg_match('/^.*[A-Z].*$/', $value) === 1;
    }

    /**
     * hasDigit
     *
     * @param string $value
     * @return bool
     */
    protected function hasDigit(string $value): bool
    {
      return preg_match('/^.*[0-9].*$/', $value) === 1;
    }

    /**
     * hasSpecialCharacter
     *
     * @param string $value
     * @return bool
     */
    protected function hasSpecialCharacter(string $value): bool
    {
      return preg_match('/^.*[^a-zA-Z0-9].*$/', $value) === 1;
    }
}
