__author__ = 'gmpo admin <gmpoemailid@GMPO.com>'
__copyright__ = 'Copyright 2015, GMPO'
__maintainer__ = 'GMPO automation team'
__email__ = 'GMPO_automation@GMPO.com'
__date__= 'Jun 23, 2016'
__version__ = 1.0

import pdb
import re
import pprint

fname_in = 'dict_input.txt'
fname_out = 'dict_readable_output.txt'
print('Reading the file: %s'%fname_in)
print('Writing to the file: %s'%fname_out)
fo = open(fname_out, 'w+')

with open(fname_in) as f:
    output = f.readlines()
# restore_revertive_BIDIR-APS_AND_restore_revertive_BIDIR-APS_t1_src_before_lockout

# restore_revertive_BIDIR-APS_AND_restore_revertive_BIDIR-APS_t1_src_before_lockout = {'local_request_state': 'No Request State', 'previous_state': 'No Request State', 'hold-off-timer': '0', 'working_controller_name': 'ODU20_9_0_0_12', 'local_bridge_signal': '1', 'wait_to_restore': '300000', 'working_remote_failure': 'State Ok', 'current_state': 'No Request State', 'working_wtr_left': '0', 'remote_bridge_status': '1+1', 'working_odu_state': 'Active', 'local_request_signal': '0', 'working_local_failure': 'State Ok', 'remote_request_state': 'No Request State', 'remote_bridge_signal': '1', 'local_bridge_status': '1+1', 'client_odu_state': 'Active', 'remote_request_signal': '0', 'client_controller_name': 'ODU20_4_0_3'}
# restore_revertive_BIDIR-APS_AND_restore_revertive_BIDIR-APS_t1_traffic_before_lockout = {'traffic': 'UP'}
# restore_revertive_BIDIR-APS_AND_restore_revertive_BIDIR-APS_alarms_src_main_lockout  = {'alarms_list': ['Lockout Switch Request On Controller or Equipment or UPSR or SNC']}

for i in output:
    i = i.strip()
    print(i)
    # We will make file for each tunnel combination and main_aps_switch
    # pattern1 = '_t1_src_before_'
    # pattern2 = ''
    # if pattern1 in i:
        # fo.close()
        # out_fname_parts = i.split(' = ')[0].split(pattern1)             # out_fname_parts = ['restore_revertive_BIDIR-APS_AND_restore_revertive_BIDIR-APS', 'lockout']
        # out_filename = '%s_%s.txt'%(out_fname_parts[0],out_fname_parts[1])  # out_filename = restore_revertive_BIDIR-APS_AND_restore_revertive_BIDIR-APS_lockout.txt
        # fo = open(out_filename, 'w+')
    out_fname_parts = i.split(' = ')[0]
    # heading_parts = i.split(' = ')[0].split('%s_'%out_fname_parts[0])[1]
    # if pattern1 in heading_parts:
        # fo.write('\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n')
       
    #if 't1_src' in heading_parts:
    if 't1_src' in i:
        fo.write('\n---------------------------------------------\n')
        fo.write('%s\n'%out_fname_parts)
    # fo.write('%s\n'%heading_parts)
    
    # dict_to_print = i.split(' = ')[1]
    # pprint.pprint(dict_to_print,fo)
    
    keys_to_match_for_aps_data = ['local_request_state','local_request_signal','local_bridge_signal','local_bridge_status',
                                      'remote_request_state','remote_request_signal','remote_bridge_signal','remote_bridge_status',
                                      'working_odu_state','working_local_failure','working_remote_failure',
                                      'protect_odu_state','protect_local_failure','protect_remote_failure',
                                      'restore_odu_state','restore_local_failure','restore_remote_failure',
                                      'client_odu_state',
                                      'hold-off-timer','wait_to_restore','current_state']
                                      
    keys_to_match_for_traffic_data = ['traffic']
    key_to_match_for_alarms_data = 'alarms_list'
    
    if '_traffic_' in i:
        # this is traffic data - print accordingly
        # restore_revertive_BIDIR-APS_AND_restore_revertive_BIDIR-APS_t1_traffic_before_lockout = {'traffic': 'UP'}
        value = i.split(' = ')[1]
        fo.write('\t%s'%value)
        
    elif '_alarms_' in i:
        # This is alarms data -- print accordingly
        # restore_revertive_BIDIR-APS_AND_restore_revertive_BIDIR-APS_alarms_src_before_lockout  = {'alarms_list': []}
        value = i.split(' = ')[1]
        fo.write('\t%s'%value)
    else:
        # This is APS data - print accordingly
        # restore_revertive_BIDIR-APS_AND_restore_revertive_BIDIR-APS_t1_src_before_lockout = {'local_request_state': 'No Request State', 'previous_state': 'No Request State', 'hold-off-timer': '0', 'working_controller_name': 'ODU20_9_0_0_12', 'local_bridge_signal': '1', 'wait_to_restore': '300000', 'working_remote_failure': 'State Ok', 'current_state': 'No Request State', 'working_wtr_left': '0', 'remote_bridge_status': '1+1', 'working_odu_state': 'Active', 'local_request_signal': '0', 'working_local_failure': 'State Ok', 'remote_request_state': 'No Request State', 'remote_bridge_signal': '1', 'local_bridge_status': '1+1', 'client_odu_state': 'Active', 'remote_request_signal': '0', 'client_controller_name': 'ODU20_4_0_3'}
        value = i.split(' = ')[1]
        value_dict = eval(value)
        # print('value_dict = %s'%value_dict)
        # print('value_dict Type = %s'%type(value_dict))
        # print('value_dict Keys = %s'%value_dict.keys())
        for key in keys_to_match_for_aps_data:
            key_val = value_dict.get(key,'not-set')
            fo.write('\t%s : %s\n'%(key,key_val))
            #print('\t%s : %s\n'%(key,key_val))
            #pdb.set_trace()
        fo.write('\n')
    
    
fo.close()
