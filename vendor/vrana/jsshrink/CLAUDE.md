# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Overview

JsShrink is a JavaScript minifier (removes spaces and comments) available in two parallel implementations: PHP (`jsShrink.php`) and JavaScript (`jsShrink.js`).
It is used as a Git submodule of Adminer, whose `compile.php` calls `jsShrink()` to minify bundled JS.
Input code must have statements terminated by semicolons.

## Commands

**Tests** (golden-file comparison, no framework):
```
php tests/run.php            # test the PHP implementation
cscript tests/run.wsf //Nologo   # test the JS implementation (Windows Script Host, JScript)
tests\run.bat                # runs both (Windows)
```

- Each `tests/input/*.js` is minified and compared byte-for-byte against `tests/expect/*.js`. Success is **silent**; failures print `<name> failed.`.
- If an expect file is missing, `run.php` **auto-creates it from the current output** and prints `<name> created.` – so to add a test, drop a file into `tests/input/`, run `run.php`, then manually verify the generated expect file before committing.
- There is no single-test runner; temporarily remove other input files if needed.
- No lint or build steps. PHP >= 5.3 (composer.json).

## Architecture

The entire tool is one function, `jsShrink()`, implemented twice: `jsShrink.php` and `jsShrink.js`.
**Any behavioral change must be made in both files and kept in sync** – the test suite runs the same golden files against each.
The PHP regex uses the `x` flag with comments; read it first, then mirror changes into the uncommented JS regex.

The algorithm is a single large regex plus a stateful callback:

- The regex tokenizes the input into: a regexp literal including flags, preceded by its syntactic context (`^`, `=>`, `[-+\([{}=,:;!%^&*|?~]`, `/`, `return`, `throw` – needed to distinguish regexp from division), single/double-quoted strings, template literals (multi-line; `${}` interpolations are kept verbatim, so a backtick inside an interpolation expression is not supported), identifier/keyword words (`[\w$]+`), runs of `+`/`-`, or any other single character. Each alternative also consumes trailing whitespace and `//`/`/* */` comments.
- The callback tracks the previous token type in a `last` variable and re-inserts a separator only where removal would change semantics:
  - `\n` between two adjacent words (prevents merging identifiers)
  - a space after `return`, `throw`, `break`, `continue`, `yield`, `async`
  - `\n` between runs of the same sign operator (prevents `+ +` becoming `++`)
  - `\n` between `/` and a following regexp literal
  - `\n` between a regexp literal and a following space-separated identifier (directly attached flags stay attached)
- A `\n` is appended to the input before processing (the JS version also prepends one).

The PHP callback keeps `$last` in a `static` variable, but it is effectively reset at the start of each `jsShrink()` call (the `^` empty match hits the reset branch first), so calls are independent in practice.

## Conventions

- Tabs for indentation.
- Test files for reported bugs are named `issueN.js`; fix commits reference `(fix #n)`.
