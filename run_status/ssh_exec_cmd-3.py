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
fo = open('ssh_exec_cmd_output.txt', 'w+')
fo.write('Starting ssh_exec.py\n')
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
fo.write('Trying to SSH...host=%s, username=%s, password=*****\n'%(host,user))
try:
    ssh.connect(host, username=user, password=upwd)
except:
    fo.write('ERROR: Incorrect username or password. Received exception while SSH host=%s as user=%s. Exiting\n'%(host,user))
    print('ERROR: Incorrect username or password')
    exit()

fo.write('Connected to host...\n')

initial_str_to_grep = "The result of testcase"
cmd_grep_part = "grep \": %s\""%initial_str_to_grep
cmd_file_part = "/ws/%s-bgl/pyATS/pyats/users/%s/runinfo/%s/TaskLog.__task1"%(executor,executor,jobfile_name)
cmd_cut_part  =  "| cut -d\":\" -f8"
cmd1 = '%s %s %s'%(cmd_grep_part,cmd_file_part, cmd_cut_part)

fo.write('Executing first command=%s\n'%cmd1)
stdin, stdout, stderr =ssh.exec_command(cmd1)
stdin.close()

fo.write('Stderr for cmd1::\n')
finish_error = 'No such file or directory'
for line in stderr.read().splitlines():
    line=str(line,'utf-8')
    fo.write('%s\n'%(line))
    if finish_error in line:
        print('%s. Execution is already complete for the job file.'%finish_error)
        fo.write('Did not find the directory to search for results. Probably the execution is complete. Exiting.')
        exit()
fo.write('---------------------------------\n')

res_out = stdout.read()
fo.write('Stdout for cmd1::\n')
executed_tests_list = []
for line in res_out.splitlines():
    #
    #  b'The result of testcase Txh463741c is => PASSED'
    #  The result of testcase Txh463741c is => PASSED
    # 
    line=str(line,'utf-8')
    line = line.split(initial_str_to_grep)[1]
    print('%s'%(line))
    fo.write('%s\n'%(line))
    executed_tests_list.append(line)
#print('executed_tests_list=%s'%executed_tests_list)

# Finding the Running tests
grep_str_running = "Starting testcase"
cmd2 = "grep \": %s\" /ws/%s-bgl/pyATS/pyats/users/%s/runinfo/%s/TaskLog.__task1 | cut -d\":\" -f8"%(grep_str_running, executor, executor, jobfile_name)
fo.write('Executing the cmd2 = %s\n'%cmd2)
stdin, stdout, stderr = ssh.exec_command(cmd2)
stdin.close()

fo.write('Stderr for command2::\n')
for line in stderr.read().splitlines():
    line=str(line,'utf-8')
    fo.write('%s\n'%line)
    if finish_error in line:
        print('%s. Execution is already complete for the job file.'%finish_error)
        fo.write('Did not find the directory to search for results. Probably the execution is complete. Exiting.')
        exit()
fo.write('---------------------------------\n')

res_out2 = stdout.read()
test_list = []
for line in res_out2.splitlines():
    line=str(line,'utf-8')
    line = line.split(grep_str_running)[1]
    line.strip()
    test_list.append(line)
#print('All test_list=%s'%test_list)    

# Get the last item as that we might need to mark as RUNNING
last_list_elem = ''
#last_list_elem = test_list.pop()
#print('last_list_elem=%s'%last_list_elem)

# Find if it is not already marked as pass/fail/error result
b_found = False
for xx in executed_tests_list:
    if last_list_elem in xx:
        b_found = True
        break
if not b_found:
    print ('%s is => RUNNING'%last_list_elem)


ssh.close()
fo.close()
