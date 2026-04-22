# AC Datasource Cookbook

A collection of annotated code examples that show how to register custom
**Data Sources** for [Admin Columns Pro](https://www.admincolumns.com/).

📘 **[Read the full documentation](https://codepress.github.io/ac-datasource-cookbook/)**

> Replace the link above with your actual GitHub Pages URL once the repo
> is published and Pages is enabled.

## Requirements

- WordPress 5.9 or later
- PHP 7.4 or later
- Admin Columns Pro
- The **Data Sources** addon (bundled with ACP)

## Quick start

1. Copy or clone this directory into `wp-content/plugins/`.
2. Activate **AC Datasource Cookbook** from the WordPress plugins screen.
3. Open [`bootstrap.php`](./bootstrap.php) and comment out recipes you do
   not want to load.
4. A **DS Cookbook** item appears in the WordPress admin sidebar with a
   submenu for each enabled recipe.

## Recipes

The source of every recipe lives under [`examples/`](./examples). Each
file is self-contained, heavily commented, and registers its Data Source
through the `acp/data-sources/register` hook.

| # | File | What it teaches |
| --- | --- | --- |
| 01 | [`01-super-simple.php`](./examples/01-super-simple.php) | The absolute minimum: register a table as a Data Source with no configuration. |
| 02 | [`02-human-readable.php`](./examples/02-human-readable.php) | Human-readable column labels plus a couple of typed columns. |
| 03 | [`03-defined-columns.php`](./examples/03-defined-columns.php) | Declare columns explicitly and filter unwanted columns out of the table. |
| 04 | [`04-table-relation.php`](./examples/04-table-relation.php) | Join a second table into a Data Source via a `has_one` relation. |

For walkthroughs, the complete API reference, and navigation, see the
[documentation site](https://codepress.github.io/ac-datasource-cookbook/).

## Building the documentation locally

The docs are built with [MkDocs Material](https://squidfunk.github.io/mkdocs-material/).

```bash
python3 -m venv .venv
source .venv/bin/activate
pip install -r requirements-docs.txt
mkdocs serve   # http://127.0.0.1:8000
```

On every push to `main` the site is rebuilt and deployed to GitHub Pages
by [`.github/workflows/docs.yml`](./.github/workflows/docs.yml). Enable
Pages under the repository's **Settings → Pages** and set the source to
**GitHub Actions**.
