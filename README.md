pennsouth_aweber
================

A Symfony project created in the fall of 2016 by Stephen Frizell for Penn South Coop Apartment Complex.

This project is written in PHP and leverages the PHP Symfony framework's Console component to implement its functionality from the command line.

The application is invoked by issuing the following command from the project's root directory (i.e., pennsouth_aweber) from the command line:
 php app/console app:sync-mds-aweber
 
Issuing the following command will display the command line options for the application:

 php app/console app:sync-mds-aweber -h
 
With no command line options, the application will run with the default option to update Penn South resident subscriber lists defined in Penn South's Aweber.com account from the nightly MDS export file that is ftp'd to Pennsouth's hosting service (Rose Hosting). 

Presented below are all command line options/arguments:

Options:

+  \-u, --update-aweber-from-mds=UPDATE-AWEBER-FROM-MDS                        Option to update Aweber from MDS input: y/n \[default: "y"\]
  
+  \-r, --report-on-aweber-email-not-in-mds=REPORT-ON-AWEBER-EMAIL-NOT-IN-MDS  Option to report on subscriber email addresses in Aweber and not in MDS: y/n \[default: "n"\]
  
+  \-l, --list-management-reports=LIST-MANAGEMENT-REPORTS                      Option to generate list management reports on Parking Lots, etc.: y/n \[default: "n"\]

Example:

php app/console app:sync-mds-aweber \-u n \-r y \-l y 

The above command will run the application with the option (a) (the '-u n' option) not to update the Aweber.com subscriber lists, (b) (the  '-r y' option) to generate a report of Pennsouth resident emails existing in Aweber.com but not in MDS, and (c) (the '-l y' option) generate list management reports on Parking Lots, etc.
 
For better readability, the same command could be issued as follows:

php app/console app:sync-mds-aweber \-\-update-aweber-from-mds=UPDATE-AWEBER-FROM-MDS \-\-report-on-aweber-email-not-in-mds=REPORT-ON-AWEBER-EMAIL-NOT-IN-MDS \-\-list-management-reports=LIST-MANAGEMENT-REPORTS
