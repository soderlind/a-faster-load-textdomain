## Changelog

### 2.1.5

- Bump version to force deploy to WordPress.org

### 2.1.4

- Deploy with GitHub Actions to WordPress.org

### 2.1.3

- Remove `mkdir()`

### 2.1.2

- fail gracefully if `$cache_path` can't be created.

### 2.1.1

- Add filter `a_faster_load_textdomain_cache_path`

### 2.1.0

- Rename namespace to `Soderlind\Plugin\A_Faster_Load_Textdomain`
- Rename cache directory to `WP_CONTENT_DIR . '/cache/a-faster-load-textdomain'`

### 2.0.1

- Rename file to `a-faster-load-textdomain.php` to follow WordPress plugin standards.

### 2.0.0

- Refactor code, instead of using a transient, save .mo file as an PHP array, and [include](https://www.php.net/manual/en/function.include.php) the array instead of the .mo file.

### 1.0.3

- Housekeeping.

### 1.0.2

- DRY (Don't Repeat Yourself) code. Add namespace.

### 1.0.1

- Add multisite support

### 1.0.0

- Initial release
