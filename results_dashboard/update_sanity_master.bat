@echo off
title SANITY Report
echo starting Sanity Report Tool
REM set url="http://GMPO-stage-lnx.GMPO.com/hpalm/"
set url="http://GMPO-stage-lnx.GMPO.com/new_sanity/"
echo %url%
set exec_flag="Sanity"
REM echo timestamp = %date:~10,4%%date:~4,2%%date:~7,2%
set build_name=%date:~10,4%%date:~4,2%%date:~7,2%
echo buildname=%build_name%
REM set build_name="20200523"
set rel_name="4.2-AC1"
echo %~dp0%
"python.exe" %~dp0\read_json_make_xl.py %url% && "python.exe" %~dp0\ri_result_update.py %exec_flag% %build_name% %rel_name%
REM PAUSE

