import { AbstractControl, ValidationErrors, ValidatorFn } from '@angular/forms';

export function passwordMatchValidator(
  passwordField: string,
  confirmPasswordField: string
): ValidatorFn {
  return (form: AbstractControl): ValidationErrors | null => {
    const password = form.get(passwordField)?.value;
    const confirmPassword = form.get(confirmPasswordField)?.value;

    if (password !== confirmPassword) {
      form.get(confirmPasswordField)?.setErrors({
        passwordMismatch: true
      });

      return { passwordMismatch: true };
    }

    return null;
  };
}