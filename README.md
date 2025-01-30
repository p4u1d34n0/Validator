# FormValidation - PHP Validation Library

## Overview
`FormValidation` is a lightweight, extensible PHP validation library that allows you to validate form input easily. It comes with built-in validation rules and supports custom rule extensions.

---

## Installation

1. **Clone or Download the Repository**
2. **Install Dependencies Using Composer**

```sh
composer dump-autoload
```

Ensure your `composer.json` includes:
```json
{
    "autoload": {
        "psr-4": {
            "FormValidation\\": "src/FormValidation/"
        }
    }
}
```

---

## Usage

### 1. Basic Example
```php
require 'vendor/autoload.php';

use FormValidation\Validator;

$validated = Validator::validate([
    'username' => ['required', 'min:3', 'max:20'],
    'email' => ['required', 'email'],
    'website' => ['url'],
]);

if ($validated->passed()) {
    echo "Validation passed!";
} else {
    print_r($validated->errors());
}
```

### 2. HTML Form with Validation
```php
require 'vendor/autoload.php';

use FormValidation\Validator;

$validated = Validator::validate([
    'username' => ['required', 'min:3'],
    'email' => ['required', 'email'],
    'website' => ['url'],
]);

$errors = $validated->errors();
?>

<form method="POST">
    <label>Username:</label>
    <input type="text" name="username" value="<?= $_POST['username'] ?? '' ?>">
    <?php if (isset($errors['username'])): ?>
        <p style="color: red;"> <?= implode('<br>', $errors['username']) ?> </p>
    <?php endif; ?>
    <br>

    <label>Email:</label>
    <input type="email" name="email" value="<?= $_POST['email'] ?? '' ?>">
    <?php if (isset($errors['email'])): ?>
        <p style="color: red;"> <?= implode('<br>', $errors['email']) ?> </p>
    <?php endif; ?>
    <br>

    <label>Website:</label>
    <input type="text" name="website" value="<?= $_POST['website'] ?? '' ?>">
    <?php if (isset($errors['website'])): ?>
        <p style="color: red;"> <?= implode('<br>', $errors['website']) ?> </p>
    <?php endif; ?>
    <br>

    <button type="submit">Submit</button>
</form>
```

---

## Adding Custom Validation Rules
You can extend the validator with custom rules dynamically.

### Example: Adding an `alpha` rule
```php
Validator::addRule('alpha', function ($validator, $field, $value) {
    if (!ctype_alpha($value)) {
        $validator->addError($field, "$field should only contain letters.");
    }
});

$validated = Validator::validate([
    'name' => ['required', 'alpha'],
]);
```

---

## Default Validation Rules
| Rule      | Description |
|-----------|------------|
| `required` | Ensures the field is not empty. |
| `min:X`   | Ensures the field has at least `X` characters. |
| `max:X`   | Ensures the field has no more than `X` characters. |
| `email`   | Ensures the field is a valid email address. |
| `url`     | Ensures the field is a valid URL. |

---

## Folder Structure
```
/src
  /FormValidation
    Validator.php
    Rules.php
```

---

## License
MIT License

---

## Contributions
Feel free to contribute by submitting a pull request!

## Authout
Paul Dean