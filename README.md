pennsouth_aweber
================

A Symfony project created in the fall of 2016 by Stephen Frizell for Penn South Coop Apartment Complex.

This project is written in PHP and leverages the PHP Symfony framework's Console component to implement its functionality from the command line.

The application is invoked by issuing the following command from the project's root directory (i.e., pennsouth_aweber) at the command line:
 php app/console app:sync-mds-aweber
 
Issuing the following command will display the command line options for the application:

 php app/console app:sync-mds-aweber -h
 
With no command line options, the application will run with the default option to update Penn South resident subscriber lists defined in Penn South's Aweber.com account from the nightly MDS export file that is ftp'd to Pennsouth's hosting service (Rose Hosting). 

Presented below are all command line options/arguments:

**Options:**

+  \-u, --update-aweber-from-mds=UPDATE-AWEBER-FROM-MDS                        Option to update Aweber from MDS input: y/n \[default: "y"\]
  
+  \-r, --report-on-aweber-email-not-in-mds=REPORT-ON-AWEBER-EMAIL-NOT-IN-MDS  Option to report on subscriber email addresses in Aweber and not in MDS: y/n \[default: "n"\]
  
+  \-p, --parking-lot-report=PARKING-LOT-REPORT                                 Option to create Parking Lot Report: y/n \[default: "n"\]

+ \-i, --homeowners-insurance-report=HOMEOWNERS-INSURANCE-REPORT                Option to create Homeowners Insurance Report: y/n [default: "n"]

+  \-a, --report-on-aweber-updates-from-mds=REPORT-ON-AWEBER-UPDATES-FROM-MDS  Option to generate spreadsheet listing details of updates of Aweber from MDS.: y/n \[default: "n"\]

+  \-b, --report-on-apts-where-no-resident-has-email-address=REPORT-ON-APTS-WHERE-NO-RESIDENT-HAS-EMAIL-ADDRESS  Option to generate spreadsheet listing apts where no resident has email address.: y/n \[default: "n"\]



**Example:**

php app/console app:sync-mds-aweber \-u n  \-p y 

The above command will run the application with the option (a) (the '-u n' option) not to update the Aweber.com subscriber lists and (b) (the '-p y' option) create Parking Lots Report.
 
For better readability, the same command could be issued as follows:

php app/console app:sync-mds-aweber \-\-update-aweber-from-mds=n \-\-parking-lot-report=y

**NOTE:** The '-a' option -- to generate a report on Aweber updates from MDS -- runs into memory limitations when a large set of data is being reported on. For this reason, it is recommended that when this option is invoked it not be combined with running any of the other available application options.



Developers Section
------------------

The main logic of the application is defined in the php class ProgramExecuteCommand in the src/Pennsouth/MdsBundle/Command directory.

As with other Symfony projects, configuration settings are to be found in the app/config folder.

All custom-written code for this project is located within the src folder under the project root directory.

Symfony framework components and other third-party libraries are located in the vendor directory under the project root directory.

Other than the components that are part of the symfony framework, the following additional third party libraries are used:

+ Aweber PHP API library, located in vendor/aweber

+ phpoffice, providing functionality to create excel documents, located in vendor/phpoffice, with a wrapper for using this library in symfony located in vendor/liuggio.

*NOTE:*
For security reasons, the repository does not include the 'parameters.yml' file (in app/config directory) required for the project to run. 
 



