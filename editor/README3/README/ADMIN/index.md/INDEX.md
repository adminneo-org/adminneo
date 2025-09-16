# AdminNeo - Updated Features

This document summarizes the **new features and changes** implemented in AdminNeo, focusing on improvements in code coverage, batch SQL execution, and plugin management.

---

## New Features Added

### 1. Coverage Page
- **URL Trigger:** `?coverage=1`
- **Purpose:** Visualize which parts of AdminNeo’s PHP code are tested, untested, or dead.
- **Highlights:**
  - Overall coverage percentage.
  - File-level coverage table with color coding:
    - Green → High/tested
    - Yellow → Medium
    - Red → Low/untested
    - Gray → Dead code
  - Line-by-line coverage view for each file.
  - Filter by folders (`admin/`, `editor/`).
  - Export coverage report as CSV for CI/CD integration.
  - Start/Stop coverage collection with a toggle button.
- **File Added:** `coverage.php`

---

### 2. Batch SQL Execution
- **URL Trigger:** `?batchsql=1`
- **Purpose:** Execute multiple SQL commands in a single operation.
- **Highlights:**
  - Paste or upload SQL scripts.
  - Execute all commands sequentially.
  - View results and errors in a clear UI.
- **File Added:** `batchsql.inc.php`

---

### 3. Plugin Management
- **URL Trigger:** `?plugins=1`
- **Purpose:** View and manage installed AdminNeo plugins and custom extensions.
- **Highlights:**
  - Enable or disable plugins.
  - Install new plugins via UI.
  - View plugin metadata and author information.
- **File Added:** `plugins.inc.php`

---

## Changes in `index.php`
- Added logic to handle the new features (`coverage`, `batchsql`, `plugins`) before existing page handling.
- Preserved all existing page logic for backward compatibility.
- Ensures each feature page can handle its own footer independently.

---

## Usage

1. **Coverage Page**
   - Open `index.php?coverage=1` to view coverage.
   - Filter files by folder or export CSV.

2. **Batch SQL**
   - Open `index.php?batchsql=1`.
   - Paste SQL commands or upload scripts and run them.

3. **Plugin Management**
   - Open `index.php?plugins=1`.
   - Manage installed plugins or add new ones.

---

## Contribution Notes

- New pages should follow AdminNeo coding standards.
- Coverage page requires **Xdebug** enabled in PHP.
- Batch SQL page must sanitize inputs to prevent dangerous queries.
- Plugin management page should validate plugin integrity before enabling.

---

## Screenshots

- Coverage Table  
  ![Coverage Table](docs/images/coverage-table.webp)

- Line-Level Coverage View  
  ![Line-Level View](docs/images/coverage-file-view.webp)

- Batch SQL Execution Page  
  ![Batch SQL](docs/images/batchsql-page.webp)

- Plugin Management Page  
  ![Plugin Management](docs/images/plugins-page.webp)

---

## License

Same as AdminNeo: [MIT License](LICENSE)

---

## Links

- [AdminNeo Official Site](https://www.adminneo.org/)
- [Original Adminer Project](https://www.adminer.org/)
