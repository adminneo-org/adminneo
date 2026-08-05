# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

**Run tests** (no framework – plain PHP scripts; each failing check prints `file:line:actual-output`):
```bash
php tests/basic.php    # tests phpShrink()
php tests/types.php    # tests stripTypes()
```

On a clean tree, both scripts print nothing; any output is a regression.

**Run the minifier from CLI:**
```bash
php run.php file1.php file2.php    # concatenates files (inserting ?> between them as needed) and prints minified output
php run.php                        # reads from stdin
```

There is no linter or build step. `composer.json` declares no dependencies.

## Architecture

PhpShrink is a PHP minifier in a single file, `phpShrink.php`, exposing two independent functions:

- **`phpShrink($input)`** – tokenizes the source with `token_get_all()` and runs sequential passes over the token array:
  1. Regex pre-pass: removes `?><?php`, empty `<?php ?>`, trailing `?>`
  2. Converts `?>HTML<?php` into `echo '...'`
  3. Joins consecutive `echo` statements (with `,`), tracking control-structure context via semicolon counting (`$echo_after`)
  4. Removes unnecessary `{}` around single-statement blocks (again via semicolon counting; disabled inside `switch`/`function`/`class`)
  5. Renames local variables to shortest names, most-frequent first (skips superglobals/`$this`; `$GLOBALS` triggers a warning – unsupported). Renaming is suspended after `var`/`public`/`protected`/`private`/class-level `static` so property names are preserved; `public` itself becomes `var` (or is dropped before functions)
  6. Emits tokens, collapsing whitespace to at most one `\n` and dropping comments (the first doc-comment is kept – typically the license header)

- **`stripTypes($input)`** – regex-based removal of PHP 7 scalar type declarations (parameter, property, return types) to produce PHP 5–compatible output. Tokenization is used only by `maskStrings()`/`unmaskStrings()`, which replace strings, comments and inline HTML by `\0<number>\0` placeholders so that the regexes see code only; the regexes themselves are deliberately simple and don't handle union/intersection types.

The main consumer is Adminer's `compile.php` (this repo is the `externals/PhpShrink` submodule).

## Conventions

- Code must stay **PHP 5.3 compatible** (`composer.json` requires `php >= 5.3`): use `array()`, no type declarations, no `[]` short syntax.
- Tabs for indentation; `//!` marks TODOs.
- Tests are ordered: sections commented `// officially unsupported`, `//! bugs`, `//! inefficiencies` at the top document known issues; new regular test cases go below them. A check passes when actual output (and, in `basic.php`, the triggered error level) matches the expectation exactly.
