# AdminNeo Coverage Page

This page provides a **code coverage dashboard** for AdminNeo, allowing developers to monitor which parts of the code are tested, untested, or dead. It integrates with **Xdebug** to collect coverage data and visualize it in a modern, interactive way.

---

## Features

- **Overall Coverage Summary**
  - Shows total % coverage across all files at the top of the page.

- **File-Level Coverage**
  - Lists all relevant PHP files (`admin/`, `editor/`, `core/`, `drivers/`) with percentage coverage.
  - Color-coded:  
    - **Green** → High/tested coverage  
    - **Yellow** → Medium coverage  
    - **Red** → Low/untested coverage  
    - **Gray** → Dead code

- **Line-Level View**
  - Click on a file to see coverage per line.
  - Lines are highlighted as **tested**, **untested**, or **dead**.
  - Hovering can show line status (planned enhancement for tooltips).

- **Filter by Folder**
  - Quickly filter files by folder (`admin/`, `editor/`, or all).

- **Export Coverage**
  - Export all file coverage stats as **CSV** for CI/CD integration.

- **Start/Stop Coverage**
  - Toggle coverage collection with a single button.

- **Legend**
  - Color guide for understanding coverage status.

---

## Requirements

- PHP with **Xdebug enabled**.
- Browser with JavaScript enabled (optional for future enhancements).
- Access to AdminNeo project files.

---

## Usage

1. **Start Coverage**
   - Click `▶️ Start coverage` to begin collecting data.

2. **View Coverage**
   - Browse the file table to see per-file coverage.
   - Click a file to view line-by-line coverage.

3. **Filter Files**
   - Use the filter links to show only `admin/` or `editor/` files.

4. **Stop Coverage**
   - Click `⏹️ Stop coverage` to stop collecting data.

5. **Export CSV**
   - Click `📄 Export CSV` to download coverage statistics.

---

## Folder / Files Coverage

- `coverage.php` → Main coverage page.
- Collects and displays data from:
  - `../admin/*.php`
  - `../admin/core/*.php`
  - `../admin/include/*.php`
  - `../admin/drivers/*.php`
  - `../editor/*.php`
  - `../editor/core/*.php`
  - `../editor/include/*.php`

---

## Notes for Contributors

- Ensure **Xdebug** is installed before using this page.
- When adding new PHP files, `coverage.php` automatically detects them.
- You can extend the page to:
  - Add **tooltips for line details**.
  - Integrate clickable lines for IDE navigation.
  - Store historical coverage for trend analysis.

---

## License

Same as AdminNeo: [MIT License](LICENSE)

---

## Screenshots

![Coverage Table](docs/images/coverage-table.webp)  
*File-level coverage table showing percentages and color codes.*

![Line-Level View](docs/images/coverage-file-view.webp)  
*Detailed per-line coverage view with highlights for tested, untested, and dead code.*
