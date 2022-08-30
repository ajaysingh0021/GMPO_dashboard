__author__ = 'gmpo admin <gmpoemailid@GMPO.com>'
__copyright__ = 'Copyright 2015, GMPO'
__maintainer__ = 'GMPO automation team'
__email__ = 'GMPO_automation@GMPO.com'
__date__= 'Nov 24, 2015'
__version__ = 1.0

import re
import collections

fname = 'convert_odu_grp_info_input.txt'

odu_group_info = {} 
start_flag = 1
odu_pr_type=0
banner_start_end = '+------------------------------------------------------------------------------+'

print('Fetching the ODU group info from file %s'%fname)
fo = open('convert_odu_grp_info_output.txt', 'w')

with open(fname) as f:
    output = f.readlines()
#print(output)
#exit()
# output = ExecuteCommand.exec_xr(h,showcmd)
# if not output:
    # log.error(banner('show controller failed for the node %s'%h))
    # result = self.fail_cnst
    # return result
#output = output.split('\n')
pat1='([\w+\-?\s+?]+)\s+\:?\s([\w+\-?\d+?\s?]+)'
pat2='(^\w+\S$)'
for i in output:
    i.rstrip('\n')
    if i == '':
        continue
        
    #i = i.rstrip()
    # if start_flag:
        # if not '----' in i:
            # start_flag = 1
            # continue
        # else:
            # start_flag =0
            # continue
    b = re.search(pat1,i,re.S|re.M|re.I)
    c = re.search(pat2,i,re.S|re.I)

    if c:
        odu_pr_type=c.group(1).strip().lower()
        #log.info('odu controller type is %s'%odu_pr_type)
    if b:
        if b.group(2).strip()and odu_pr_type:
            key='_'.join(b.group(1).strip().lower().split())
            if key in ['wait_to_restore','hold-off-timer','current_state' ,'previous_state']:
                key_val = b.group(2).strip()
                if ' ms' in key_val:
                    key_val = key_val.split(' ms')[0]
                odu_group_info[key]= key_val
                #odu_group_info[key]= b.group(2).strip()
                #log.info('%s is %s'%(key,b.group(2).strip()))
                #log.info('%s is %s'%(key,key_val))
            else:
                key_val = b.group(2).strip()
                if ' ms' in key_val:
                    key_val = key_val.split(' ms')[0]
                    str = 'test_kwargs[\'%s_%s\'] = \'%s\''%(odu_pr_type,key,key_val)
                #odu_group_info['%s_%s'%(odu_pr_type,key)]= b.group(2).strip()
                odu_group_info['%s_%s'%(odu_pr_type,key)]= key_val
                #log.info('odu controller type %s_%s is %s'%(odu_pr_type,key,b.group(2).strip()))
                #log.info('odu controller type %s_%s is %s'%(odu_pr_type,key,key_val))


    
print(odu_group_info)

# import pdb
# pdb.set_trace()

#fo.write('%s'%odu_group_info)

#odu_group_info

list_ordered_dict_keys = [
    'local_request_state',
    'local_request_signal',
    'local_bridge_signal',
    'local_bridge_status',
    'remote_request_state',
    'remote_request_signal',
    'remote_bridge_signal',
    'remote_bridge_status',
    'working_controller_name',
    'working_odu_state',
    'working_local_failure',
    'working_remote_failure',
    'working_wtr_left',
    'protect_controller_name',
    'protect_odu_state',
    'protect_local_failure',
    'protect_remote_failure',
    'protect_wtr_left',
    'restore_controller_name',
    'restore_odu_state',
    'restore_local_failure',
    'restore_remote_failure',
    'restore_wtr_left',
    'client_controller_name',
    'client_odu_state',
    'wait_to_restore',
    'hold-off-timer',
    'current_state',
    'previous_state'
]
out_headings = '%s'%odu_group_info
#all_headings = output[0].split(',')
all_headings = out_headings.split(',')
fo.write('{')
count = 0
for item in list_ordered_dict_keys:
    count = count + 1
    for heading in all_headings:
        heading_pattern = '\'%s\':\s+(.*)'%item
        res = re.search(heading_pattern,heading,re.S|re.M|re.I)
        if res:
            head_value = res.group(1)
            head_value = head_value.replace('}','')
            value_to_push = '\'%s\': %s'%(item,head_value)
            #print('--- %s ---'%value_to_push)
            if count > 1:
                fo.write(', ')
            fo.write('%s'%value_to_push)
    
fo.write('}')
fo.close()


