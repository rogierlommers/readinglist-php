ReadingList
===========

ReadingList allows you to run your own collection of "urls to read". For example: you are reading a webpage and you want to mark it as "read later", you can use this service quickly send the page title and url into your own database. From there, the service generates an RSS feed containing all these urls. You can import this RSS feed into your own, favorite RSS client (f.e. TinyTinyRSS)

Requirements
============
* Server running PHP
* Mysql database

Installation instructions
=========================
* Copy source files to your webserver or check out latest version: "git clone git@github.com:rogierlommers/readinglist.git".
* Copy content of example config file to config.inc.php: "cp config.inc.php.sample config.inc.php" and insert your mysql database connection.
* Run the install.php script: php install.php (or within browser).
* Open index.php
* Create bookmarklet which points to freshly installed reading list app:

```javascript
javascript:location.href='http://youserver.com/readinglist/index.php?url='+encodeURIComponent(window.location.href)+'&title='+encodeURIComponent(document.title)
```

Contact
=======
For more information, please don't hesitate to contact me [@rogierlommers](https://twitter.com/rogierlommers).
