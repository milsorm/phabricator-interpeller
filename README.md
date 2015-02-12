# phabricator-interpeller

Phabricator application for displaying dependency graph between Maniphest tasks.

(c) 2015 Copyright Milan Sorm <sorm@is4u.cz>

## Synopsis

Application is created as new libph library which can be used as extension for Phabricator <www.phabricator.org>.
All codes are already liberated through Arcanist so everything necessary for usage for Phabricator is at place.

## Installation

Put all codes next to phabricator main directory (where arcanist, libphutil and phabricator itself are) and add following
configuration to Phabricator:

	./phabricator/bin/config set load-libraries '{ "phabricator-interpeller": "..\/phabricator-interpeller\/src" }'

## Application

In src/ folder you can find two prepared applications:

**Kanban** which add one application icon between the user profile icon and quick creation icon and allow to quick
access first dashboard mainly used as Kanban for the whole project.

**Interpeller** which allow to display graph of all dependencies between opened Maniphest tasks.

Feel free to remove which one you don't want to install in Phabricator.

## Extra attributes

Interpeller use two custom attributes:

	is4u:estimated-hours
	is4u:progress

both integers we are using for planning (how many hours is planned for task and progress in percent.

You can add these custom fields to Maniphest through Phabricator configuration or comment out these lines.

## D3 Library and Apache configuration

Dependency graph is displayed according to D3 Force package from www.d3js.org.
		
You have to include this JavaScript library into your web space - I did it through Apache httpd.conf configuration
through two different settings:

	Alias /ours-js/d3.v3.min.js /export/phabricator/phabricator-interpeller/src/interpeller/js/d3.v3.min.js

	RewriteRule ^/ours-js/(.*)      -       [L,QSA]

First one define internal alias (we use /ours-js folder) for full path two installed JavaScript library. Second one
only exclude the whole folder /ours-js from all rewriting of Phabricator web space. You can run Phabricator on HTTP
or HTTPS protocol, it doesn't matter (internal links goes to `//hostname`).

## Acknowledgements

Thanks to Mike Bostock for excellent D3js library and the whole Phabricator team for such a great tool for organizing development.

