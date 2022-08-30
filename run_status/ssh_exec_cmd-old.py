__author__ = 'gmpo admin <gmpoemailid@GMPO.com>'
__copyright__ = 'Copyright 2017, GMPO'
__maintainer__ = 'GMPO automation team'
__email__ = 'GMPO_automation@GMPO.com'
__date__= 'Mar 25, 2017'
__version__ = 1.0

import re
import paramiko
import time, sys

# DO NOT ADD/REMOVE ANY PRINT STATEMENTS IN THIS FILE. IT WILL AFFECT PARSING IN PHP FILE WHICH IS CALLING THIS.

#fo = open('ssh_exec_cmd_output.txt', 'w+')

ssh = paramiko.SSHClient()
#ssh.load_system_host_keys()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())

host = 'bgl-xdm-136'
# user = 'gmpoemailid'
# upwd = 'gmpoadmin'
# jobfile_name = 'sauron_gmpls_aps_98_regression_job'
# executor = 'somane'

user = sys.argv[1]
upwd = sys.argv[2]
jobfile_name = sys.argv[3]
executor = sys.argv[4]

ssh.connect(host, username=user, password=upwd)
print ('Connected...Running remote command')

cmd1 = 'ls -l'
grep_str1 = "The result of testcase"
grep_str3 = " is => "

grep_str_running = "Starting testcase"

cmd_part0 = "grep \": %s\""%grep_str1
cmd_part1 =  "/ws/%s-bgl/pyATS/pyats/users/%s/runinfo/%s/TaskLog.__task1 | cut -d\":\" -f8"%(executor,executor,jobfile_name)
cmd = '%s %s'%(cmd_part0,cmd_part1)
print('command=%s'%cmd)
stdin, stdout, stderr =ssh.exec_command(cmd)
#print('stdin=%s stdout=%s stderr=%s'%(stdin,stdout,stderr))
stdin.close()

res_out = stdout.read()
#print('Stdout::%s'%res_out)
print('Stdout::')
executed_tests_list = []
for line in res_out.splitlines():
    #
    #  b'The result of testcase Txh463741c is => PASSED'
    #  The result of testcase Txh463741c is => PASSED
    # 
    line=str(line,'utf-8')
    line = line.split(grep_str1)[1]
    print ('%s'%(line))
    executed_tests_list.append(line)
    
#print('executed_tests_list=%s'%executed_tests_list)
cmd2 = "grep \": %s\" /ws/%s-bgl/pyATS/pyats/users/%s/runinfo/%s/TaskLog.__task1 | cut -d\":\" -f8"%(grep_str_running, executor, executor, jobfile_name)
stdin, stdout, stderr =ssh.exec_command(cmd2)
stdin.close()
res_out2 = stdout.read()
test_list = []
for line in res_out2.splitlines():
    line=str(line,'utf-8')
    line = line.split(grep_str_running)[1]
    line.strip()
    test_list.append(line)

#print('test_list=%s'%test_list)    
last_list_elem = test_list.pop()
#print('last_list_elem=%s'%last_list_elem)
b_found = False
for xx in executed_tests_list:
    if last_list_elem in xx:
        b_found = True
        break
if not b_found:
    print ('%s is => RUNNING'%last_list_elem)
# print('Stderr::')
# for line in stderr.read().splitlines():
    # print ('%s$: %s' % (host, line + "\n"))
        
#time.sleep(1)
ssh.close()
#fo.close()
