#!/bin/bash

 use Net::FTP::Recursive;

 $ftp = Net::FTP::Recursive->new('www.schoolbag.ie', Debug => 0);
 $ftp->login('w00140631', 'm*No1mS?Zi6');
 $ftp->rget();
 $ftp->quit;
