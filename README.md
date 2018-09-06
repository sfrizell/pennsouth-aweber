pennsouth_aweber
================

A Symfony project created in the fall of 2016 by Stephen Frizell for Penn South Coop Apartment Complex.

Depending on command-line arguments passed to the program, the application performs the following functions:
+ updates lists of Pennsouth resident email addresses and associated apartment or resident attributes stored in Aweber, based on information provided in a file ftp'd nightly by Pennsouth's Property Management System (MDS)

+ creates reports based on MDS data and/or comparisons of MDS data with data stored in Aweber.com. See below for details of command-line arguments and their meaning.

This project is written in PHP and leverages the PHP Symfony framework's Console component to implement its functionality from the command line.

The application is invoked by issuing the following command from the project's root directory (i.e., pennsouth_aweber) at the command line:
 php app/console app:sync-mds-aweber
 
Issuing the following command will display the command line options for the application:

 php app/console app:sync-mds-aweber -h
 
With no command line options, the application will run with the default option to update Penn South resident subscriber lists defined in Penn South's Aweber.com account from the nightly MDS export file that is ftp'd to Pennsouth's hosting service (Rose Hosting). The scripts to process the nightly MDS export file are stored in the pennsouth-db-prep project on github (see: https://github.com/sfrizell/pennsouth-db-prep ) 

9/3/2018: The MDS to Aweber sync program has been updated to delete any subscribers defined in Aweber where there is no corresponding email address found in the MDS input, providing the Aweber subscriber does not have a values set for building or floor-number or apt-line.
 
 This update was implemented by invoking the same method used to report on Aweber email addresses not found in MDS. This report is now generated whenever the sync process runs (i.e., the Aweber update process).

Presented below are all command line options/arguments:

**Options:**

+  \-u, --update-aweber-from-mds=y/n                             Option to update Aweber from MDS input: y/n \[default: "y"\], i.e., if the parameter is not included at all the program will run the update of aweber from MDS.
  
+  \-r, --report-on-aweber-email-not-in-mds=y/n                  Option to report on subscriber email addresses in Aweber and not in MDS: y/n \[default: "n"\]
  
+  \-p, --parking-lot-report=y/n                                 Option to create Parking Lot Report: y/n \[default: "n"\]

+ \-i, --homeowners-insurance-report=y/n                         Option to create Homeowners Insurance Report: y/n [default: "n"]

+ \-c, --income-affidavit-report=y/n                             Option to create Income Affidavit Report: y/n [default: "n"]

+ \-d, --mds-data-entry-gaps-report=y/n                             Option to create Income Affidavit Report: y/n [default: "n"]

+  \-a, --report-on-aweber-updates-from-mds=y/n                  Option to generate spreadsheet listing details of updates of Aweber from MDS.: y/n \[default: "n"\]

+  \-b, --report-on-apts-where-no-resident-has-email-address=y/n  Option to generate spreadsheet listing apts where no resident has email address.: y/n \[default: "n"\]



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
 



