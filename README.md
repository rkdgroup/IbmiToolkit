PHP Toolkit for IBM i 
=====================

This is a fork of the IBM i Toolkit.  For offical repository, visit [zendtech/IbmiToolkit](https://github.com/zendtech/IbmiToolkit) on GitHub.

This fork is designed to provide access to patches that are not tagged in official repository.  Eventually, it may include custom features or enhancements.

**The introduction below is from the official release and does not reflect the plans of this fork.**


Introduction
------------

The PHP Toolkit for IBM i (Toolkit) is a PHP-based front end to [XMLSERVICE](http://www.youngiprofessionals.com/wiki/XMLSERVICE) that helps programmers call RPG and CL programs along with other native resources from within PHP. 

The Toolkit is open source and has been developed with help from Alan Seiden and the community. 

Discussion of the Toolkit takes place in GitHub Discussions:
https://github.com/zendtech/IbmiToolkit/discussions

Current Main Features:

- Ability to call RPG, CL, and COBOL
- Ability call IBM i native resources such as Spool Files, Data Areas, and System Values
- Run interactive commands such as ‘wrkactjob’
- Designed to used a choice of transports including DB2, ODBC , and HTTP
- Compatibility wrapper to execute Easycom syntax

Planned Features:

- More and better code samples (coming along: https://github.com/zendtech/IbmiToolkit/tree/master/samples) 
- Inline transport (not requiring DB2 connection)
- Improve usability of the API
- Optimizations for larger data sets

XMLSERVICE and the IBM i Toolkit are already shipped with Zend Server and Seiden CommunityPlus+ PHP. But being 
open source they can also be downloaded, installed, and upgraded separately.

For more information and examples, please visit the wiki:
https://github.com/zendtech/IbmiToolkit/wiki
