Akismet-CakePHP [![Build Status](http://coryjthompson.com:8080/buildStatus/icon?job=Akismet-CakePHP)](http://coryjthompson.com:8080/job/Akismet-CakePHP/)
===============


Flexible CakePHP plugin for interacting with Akismet API. Includes both a Component and a Behavior.

Plugin gives a flexible way to integrate Akismet into your CakePHP application. Offers the ability to:

-	Check if comment is spam
-	Report spam to Akismet
-	Report false positives to Akismet.

There are 2 ways of accessing the APIs.

- Component: Gives controllers access to the API. 
- Behavior: Less logic needed. Requires you to structure comment table in a particular way.

Requirements
============
* Akismet API Key (http://akismet.com)
* CakePHP 2.x

Setup
==============
Install
----------
To install the plugin, simply copy/clone the contents of this repo into your app/Plugin directory. 
	
	git clone https://github.com/coryjthompson/Akismet-CakePHP.git app/Plugin/Akismet 

Add to app/Config/bootstrap.php

	CakePlugin::load('Akismet');

Configuration
-------------------
Configuration is located into app/Plugin/Akismet/Config/config.php

	$config['Akismet']['ApiKey'] = 'your-api-key';

Component Usage
==============
Add Plugin to your components property.
	
	public $components = array('Akismet.Akismet);

Then simply call    

	$this->Akismet->isSpam($content, $author, $authorEmail, $authorUrl);


Behavior Usage
==============
Review configuration in app/Plugin/Akismet/Config/config.php and ensure fields match up to your database schema.

In Model class specify property.

	public $actsAs = array('Akismet.Akismet');

Akismet plugin will load beforeSave and ensure item is not spam.

Contribute
===============
If you think i've missed anything, or there is something you think could be done better I would love for you to contribute to the project. I often check for pull request.

More Resources
===============
Akismet - [http://akismet.com/](http://akismet.com/) 

Contributors 
================
@CoryJThompson - [http://coryjthompson.com](http://coryjthompson.com)

