# StudentHub

Premium front-end WDF college project using HTML5, CSS3, Vanilla JavaScript, Bootstrap 5, Font Awesome and Google Fonts.

## Labs 4-7 added

- **Lab 4:** JavaScript dynamic UI components: notification banner, modal popup, content slider, collapsible FAQ, theme switching and interactive navigation support.
- **Lab 5:** HTML5 registration inputs and JavaScript validation for name, student ID, email, mobile, password/confirm password, course, semester, gender, address and terms.
- **Lab 6:** `campus-data.html` loads `data/events.json`, `data/profiles.json`, `data/notices.json` and `data/faqs.json` using Fetch API, with search, sorting, filtering-by-dataset and pagination.
- **Lab 7:** `register.php` and `contact.php` validate/sanitize POST data and store records in `php-data/*.csv` and `php-data/*.json` using safe file writing.

## Front-end run

Open the `StudentHub` folder in VS Code and use Live Server on `index.html`. Lab 6 works through a local web server because Fetch API requests JSON files.

## PHP run

For Lab 7, place the project inside XAMPP/WAMP `htdocs` (or another PHP-enabled server) and open `register.html` / `contact.html` through `http://localhost/...`. The PHP scripts create the CSV/JSON data files automatically in `php-data/`.

## Demo login

Email: `student@demo.com`
Password: `student123`

## Notes

The original front-end/localStorage workflow is preserved for the academic demo. PHP functionality requires a PHP-enabled server.
