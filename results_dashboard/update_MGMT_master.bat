@echo off
title MGMT-COMPARE Report
echo starting MGMT-COMPARE Report Tool
REM set url="http://hostname-win10.GMPO.com/GMPO/reports/01.GMPO_4.0_LA/allure-report_LA-FCS/allure-report/index.html"
set url="http://hostname-win10.GMPO.com/GMPO/reports/02.GMPO_4.0_GA/20200524011221_4.0-GA-develop-1106/allure-report/index.html"
echo %url%
set exec_flag="MgmtCompare"

REM set build_name="LA-FCS"
set build_name="GA-1106"

echo buildname=%build_name%
set rel_name="4.0"
echo %~dp0%
"python.exe" %~dp0\read_json_make_xl.py %url% && "python.exe" %~dp0\ri_result_update.py %exec_flag% %build_name% %rel_name%
PAUSE

