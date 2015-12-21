Featured Courses Block for Moodle
---------------------------------

With this block you can select a set of
courses to be displayed on frontpage.

For each course, the block will show it's name
with a link to course page, it's
summary and summary files.

https://moodle.org/plugins/block_featuredcourses

Install
-------

* Put these files at moodle/blocks/featuredcourses/
 * You may use composer
 * or git clone
 * or download the latest version from https://github.com/danielneis/moodle-block_featuredcourses/archive/master.zip
 * or install via web interface (if your Moodle is configured to do so) as it is available at [Plugins Directory](https://moodle.org/plugins/view/block_featuredcourses)
* Log in your Moodle as Admin and go to "Notifications" page
* Follow the instructions to install the block
* This block is only visible on site front page

Usage
-----

* To select featured courses, add the block to front page,
got to edit settings, click on the link on the settings screen.
* The order of the courses displayed by the block is defined
by the "sortorder" field. It is an integer field that the records
are ordered by.

Dev Info
---------
Please, fill issues at: https://github.com/danielneis/moodle-block_featuredcourses/issues

Feel free to send pull requests at: https://github.com/danielneis/moodle-block_featuredcourses/pulls

For translations, please use: http://lang.moodle.org

[![Build Status](https://travis-ci.org/danielneis/moodle-availability_timesinceenrol.svg?branch=master)](https://travis-ci.org/danielneis/moodle-availability_timesinceenrol)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/danielneis/moodle-block_featuredcourses/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/danielneis/moodle-block_featuredcourses/?branch=master)
