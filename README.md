Manual and API Documentation for Aura
=====================================

Located in this repository is the official manual and API documentation, which
can be found at <http://auraphp.github.com/docs/api>.

Updating the API Docs
---------------------

### Requirements

The following applications are required in order to update the documentation;
please note that they must be present in your `$PATH` for the update script to
work.

1. *PHP 5.3+*. Aura is compatible with PHP 5.3 and higher.

2. *Git*. During the update process every `Aura.*` repository will be pulled
into a local directory `repositories`.

3. *DocBlox 0.17.2+*. This application is responsible for creating the API
documentation (see
<http://www.docblox-project.org/documentation/installation>).

### Usage

1. Clone the `docs` repository.

        $ git clone https://github.com/auraphp/docs`

2. Switch to the `gh-pages` branch.

        $ cd docs
        $ git checkout gh-pages
        
2. Issue `php update-api.php` to update the documentation in the `/api` folder

        $ php update-api.php

3. Verify the output of the `update-api` to see if any errors have occurred

4. Commit and publish the documentation to GitHub.

        $ git add .
        $ git commit --message="updated api docs"
        $ git push

### Output

The `update-api` script generates the following in the `api` directory:

1. A sub-folder for each `Aura.*` repository with full API documentation for
   that repository.

2. The files `index.html` and `menu.html`; these files can be used to ease
   navigation between each repository's documentation.

