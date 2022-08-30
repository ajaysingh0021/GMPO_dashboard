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


# ordered_dict_odu_grp_info = collections.OrderedDict()
# list_ordered_dict_keys = [
# 'local_request_state',
# 'local_request_signal',
# 'local_bridge_signal',
# 'local_bridge_status',
# 'remote_request_state',
# 'remote_request_signal',
# 'remote_bridge_signal',
# 'remote_bridge_status',
# 'working_controller_name',
# 'working_odu_state',
# 'working_local_failure',
# 'working_remote_failure',
# 'working_wtr_left',
# 'protect_controller_name',
# 'protect_odu_state',
# 'protect_local_failure',
# 'protect_remote_failure',
# 'protect_wtr_left',
# 'restore_controller_name',
# 'restore_odu_state',
# 'restore_local_failure',
# 'restore_remote_failure',
# 'restore_wtr_left',
# 'client_controller_name',
# 'client_odu_state',
# 'wait_to_restore',
# 'hold-off-timer',
# 'current_state',
# 'previous_state'
# ]

# odu_group_info_tmp = {}

# for item in list_ordered_dict_keys:
    # ordered_dict_odu_grp_info[item] = '999999';

# print('ORDERED ODU group info is:\n%s'%ordered_dict_odu_grp_info)

# for key in odu_group_info:
    # ordered_dict_odu_grp_info[key] = odu_group_info[key]

# # for empkey in ordered_dict_odu_grp_info:
    # # if ordered_dict_odu_grp_info[key] == '':
        # # pop
    
    
# {k: v for k, v in ordered_dict_odu_grp_info.items() if v!=None}

    
fo.write('%s'%odu_group_info)
# fo.write('<br>-----<br>')
# fo.write('%s'%ordered_dict_odu_grp_info)

# print('ODU group info is:\n%s'%odu_group_info)
# print('ORDERED ODU group info is:\n%s'%ordered_dict_odu_grp_info)

fo.close()


