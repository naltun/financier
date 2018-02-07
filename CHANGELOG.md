# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)

## [Unreleased]
# Further features to be added accordingly
-Updated README
-Add ncurses function
-Add a script argument that allows a user to *only* view a certain coin's statistics, eg:
	$ financier [-o/--only-display=] reddcoin

Doing so will _also_ display global statistics
-Add 'comparison' feature, which will use a local data store of all the values returned from
	a web request, and will make a comparison to the previous call's values. It will display
	positive/negative changes to each value. This feature will be callable from a command line
	argument, eg:
	$ financier [-c/--compare]

## [0.2.3] - 2018-02-07
### Added
-Added an unreleased feature in CHANGELOG, which will allow a user to specify a script argument to display positive/negative gains as a comparison to previously-
returned values

## [0.2.2] - 2018-01-09
### Added
-Added an unreleased feature in CHANGELOG, which will allow a user specify a script argument to suppress coin statistics except _only_ for the specified coin

## [0.2.1] - 2017-10-13
### Changed
-Changed the shebang line from `/usr/bin/php` to `/usr/bin/env php` (the better way). I also changed the changelog to a Markdown file, and I updated the Unreleased 
section to include `ncurses` functionality.

## [0.2.0] - 2017-09-09
### Added
-Added currency watcher functionality, displaying the top `N' performing currencies by specifying an Integer argument to financier.php

## [0.1.3] - 2017-09-08
### Changed
-Shebang line added to financier.php (I didn't know this was a thing until I read the PHP `man' page in greater detail)

## [0.1.2] - 2017-09-08
### Fixed
-Fixed incorrect version reference in financier.php

## [0.1.1] - 2017-09-08
### Fixed
-Fixed comment mistake on line 53, which referenced a wrong line number

## [0.1.0] - 2017-09-07
### Added
-financier.php
-changelog
-README.md

## [0.0.0] - 2017-09-07
### Added
-LICENSE
