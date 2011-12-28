Manual and API documentation for Aura.
======================================

Located in this repository is the official manual and API documentation, which can be found at: [http://auraphp.github.com/docs/api](http://auraphp.github.com/docs/api).

Updating the documentation
--------------------------
The API documentation can be updated using the accompanied script

### Requirements
The following applications are required in order to update the documentation; please note that they must be present in your `$PATH` for the update script to work.

1. *PHP 5.3+*, Aura is compatible with PHP 5.3 and higher.
2. *Git*, during the update process every `aura.*` repository will be pulled into a local directory `repositories`.
3. *DocBlox 0.17.2+*, this application is responsible for creating the API documentation
   (see [http://www.docblox-project.org/documentation/installation/](http://www.docblox-project.org/documentation/installation/) for installation instructions)

### Usage
1. Clone the `docs` repository

        $ git clone https://github.com/auraphp/docs`

2. Issue `php update-api.php` to update the documentation in the `/api` folder

        $ cd docs
        $ php update-api.php

3. Verify the output of the `update-api` to see if any errors have occurred
4. `git commit` and `git push` the new documentation to GitHub

        $ git add api
        $ git commit -m "<reason for updating>"
        $ git push origin master

### Output
Once the `update-api` script has ran the following has been generated in the folder `api`:
1. A sub-folder for each `aura.*` repository; This folder contains the full API documentation for that repository.
2. The files `index.html` and `menu.html`; these files can be used to ease navigation between each repository's documentation.

### Publishing
To publish the documentation you will have to switch to the gh-pages branch, pull the changes from master and then push to the same branch on Github.

    $ git checkout gh-pages
    $ git pull . master
    $ git push origin gh-pages