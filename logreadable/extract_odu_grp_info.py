__author__ = 'gmpo admin <gmpoemailid@GMPO.com>'
__copyright__ = 'Copyright 2015, GMPO'
__maintainer__ = 'GMPO automation team'
__email__ = 'GMPO_automation@GMPO.com'
__date__= 'Nov 24, 2015'
__version__ = 1.0

import re

print('Fetching the ODU group info from file fname')
fname = 'extract_odu_grp_info_input.txt'

odu_group_info = {} 
start_flag = 1
odu_pr_type=0
banner_start_end = '+------------------------------------------------------------------------------+'

fo = open('extract_odu_grp_info_output.txt', 'w+')

with open(fname) as f:
    output = f.readlines()

b_skip_lines = True
b_print_this = False
b_print_banner = False
for i in output:
    if banner_start_end in i and 'INFO:' in i:
        if b_print_banner:
            b_print_banner = False
            fo.write(' %s\n\n'%banner_start_end)
        else:
            b_print_banner = True
    if 'ODU  Group Information' in i:
        b_skip_lines = False
    if 'RP/0/RP' in i:
        b_skip_lines = True
    if 'INFO: STEP' in i or 'ERROR:' in i or 'WARNING:' in i:
        b_print_this = True
    if not b_skip_lines:
        i = i.rstrip()
        i = i.lstrip()
        i = " ".join(i.split())
        #print(i)
        #if i!='' and 'GMPO_automation' not in i and 'aetest' not in i:
        if i!='' and 'GMPO_automation' not in i:
            fo.write(i)
            fo.write('\n')
            #print (i)
    if b_print_this and '- Passed' not in i:
        i = i.rstrip()
        i = i.lstrip()
        if 'ERROR:' in i:
            fo.write('<span class="highlightme">')
        fo.write(i)
        if 'ERROR:' in i:
            fo.write('</span>')
        fo.write('\n')
        #print (i)
        b_print_this = False
    if b_print_banner:
        i = i.strip()
        line = i.split('INFO:')
        fo.write(line[1])
        fo.write('\n')
fo.close()
