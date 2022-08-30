@echo off
title ri Report
echo starting RI Report Tool
set url="http://hostname-win10.GMPO.com/GMPO/reports/02.GMPO_4.0_GA/20200515070513_4.0-GA-develop-1096-rerun/allure-report/index.html"
REM set url="http://hostname-win10.GMPO.com/GMPO/reports/02.GMPO_4.0_GA/20200515070513_4.0-GA-develop-1096-Sanity/allure-report/index.html"
echo %url%
set exec_flag="RI"
set build_name="4.0_GA_4020"
set rel_name="4.0"
echo %~dp0%
"python.exe" %~dp0\read_json_make_xl.py %url% && "python.exe" %~dp0\ri_result_update.py %exec_flag% %build_name% %rel_name%
PAUSE

