[![Build Status](https://travis-ci.com/developerck/moodle-local_enrolstats.svg?branch=master)](https://travis-ci.com/developerck/moodle-local_enrolstats)


# Moodle Local Plugin: Enrollment Statistics Report

This plugin is designed to streamline the process of viewing enrollment statistics.

## Compatibility
This plugin is compatible with **Moodle version > 3.5**.  


## Problem Statement
To see enrollment statistics (how many users are enrolled into a course and by which method), you currently have to go to each individual course.

## Solution
A new capability is available with this plugin that can be assigned at the **category level**.

A person with this capability for a specific category can view the enrollment stats for all courses under that category and its subcategories on a single page, including:
- A breakdown by enrollment method  
- Active/suspended user count  

The **administrator** can view statistics for all courses.

When the enrollment stats page is viewed:
- A **log entry** is created for monitoring who accessed the report.  
- **Direct links** are provided, allowing users with access to go directly to the enrolled user screen for a detailed view.

![enrolstats](https://developerck.com/wp-content/uploads/2020/07/enrolstats.png)



## License ##

2020 
Chandra Kishor
https://developerck.com

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see <http://www.gnu.org/licenses/>.
