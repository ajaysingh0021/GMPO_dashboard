__author__ = 'gmpo admin <gmpoemailid@GMPO.com>'
__copyright__ = 'Copyright 2015, GMPO'
__maintainer__ = 'GMPO automation team'
__email__ = 'GMPO_automation@GMPO.com'
__date__= 'Nov 24, 2015'
__version__ = 1.0

import re
import collections

fname = 'convert_odu_grp_info_output.txt'
odu_group_info = {} 

print('Fetching the ODU group info DICT from file %s'%fname)
fo = open('convert_odu_grp_info_output_final.txt', 'w')
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

with open(fname) as f:
    output = f.readlines()
    print('---------------------')
    print(output)
    print('======================')
    
    all_headings = output[0].split(',')
    
    for item in list_ordered_dict_keys:
        for heading in all_headings:
            heading_pattern = '\'%s\':\s+(.*)'%item
            res = re.search(heading_pattern,heading,re.S|re.M|re.I)
            if res:
                head_value = res.group(1)
                head_value = head_value.replace('}','')
                value_to_push = '\'%s\': %s'%(item,head_value)
                print('--- %s ---'%value_to_push)
            
    
    
exit()

fo.close()


