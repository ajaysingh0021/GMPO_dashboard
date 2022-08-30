import re
import time,sys,os
from datetime import datetime
import requests

debug_flag = False

# User input
#user_input_url = "http://hostname-win10.GMPO.com/GMPO/reports/02.GMPO_4.0_GA/20200513053852_4.0-GA-develop-1096/allure-report/data/index.html"
#user_input_url = "http://GMPO-stage-lnx.GMPO.com/hpalm/"
user_input_url = sys.argv[1]
# http://hostname-win10.GMPO.com/GMPO/reports/02.GMPO_4.0_GA/20200513053852_4.0-GA-develop-1096/allure-report/data/index.html
# http://GMPO-stage-lnx.GMPO.com/hpalm/

# Get url to download json file
# http://hostname-win10.GMPO.com/GMPO/reports/02.GMPO_4.0_GA/20200513053852_4.0-GA-develop-1096/allure-report/data/suites.json
# http://GMPO-stage-lnx.GMPO.com/hpalm//data/suites.json

if "data" in user_input_url:
    url = "/".join(user_input_url.split('/')[:-1]) + "/suites.json"
else:
    url = "/".join(user_input_url.split('/')[:-1]) + "/data/suites.json"

# Output file folder
fa_folder = "fa_sheets"
out_folder = fa_folder + "/" + user_input_url.split('/')[-4]
#if not os.path.exists(fa_folder):
#    os.makedirs(fa_folder)
if not os.path.exists(out_folder):
    os.makedirs(out_folder)
# Output file to create
out_file = out_folder + "/" + user_input_url.split('/')[-3] + "--FA.csv"
print("<a href=\'%s\'> <img src=\"../images/csv.jpeg\" alt=\"Export Report\" style=\"width:62px;height:62px;\"> </a>" % out_file)

if debug_flag: print("<br><b>Output will be: %s/%s </b><br>" % (out_folder, out_file))

timestamp = datetime.today().strftime("%Y%m%d%H%M%S")

remote_json_file = "suites.json"
local_json_file = "suites.json"
#local_json_file = "gmpoadmin.json"

download_json = True
if download_json:
    r = requests.get(url, allow_redirects=True)
    #print(r.headers.get('content-type'))
    my_file = open(local_json_file, "w")
    my_file.write(r.text)
    my_file.flush()
    my_file.close()
    # with open(json_file_to_readwrite, "w") as my_file:
    #     my_file.write(r.text)
    if debug_flag: print("Downloaded json file: %s" % local_json_file)
    time.sleep(4)
else:
    if debug_flag: print('Using existing json file: %s' % local_json_file)

# Read the json
f_text = open(local_json_file, "r+")
lines = f_text.readlines()
f_text.close()

# Create output csv file
#excel_to_write = "%s_exec_results.csv" % timestamp
#excel_to_write = "latest_exec_results.csv"
excel_to_write = out_file
f_updated = open(excel_to_write, "w")
if debug_flag: print("Writing to csv file: %s" % excel_to_write)

def xprint(str):
    try:
        f_updated.write('%s\n' % str)
        if debug_flag: print('%s\n' % str)
    except:
        print('*** ERROR: Failed to write : %s ***\n' % str)

xprint("Suite, Main-Scenario, Sub-Scenario, Test, Parameter, Status, Owner, Bug/Auton, Comments")
#2K_Flex suite	 2Kflex user signup	 genericTestGenerator.UserSignup	 userSignUp	  "Flex2k"- "Flex2k" 	 passed

pattern_1 = "\"name\" : \"(.*)\","                  # "name" : "CSDL Test suite GMPO_REL_324",
pattern_2 = "\"status\" : \"(.*)\","                # "status" : "passed",
pattern_3 = "\"parameters\" : \[(.*)\]"             # "parameters" : ["a", "b" ]
#pattern_3 = "\"parameters\" : (.*)"             # "parameters" : ["a", "b" ]
pattern_4 = "}, {"                                  # this is a test
pattern_5 = "} ],"                                  # this is a new sub scenario

data_to_print = ""
level = 0

for line1 in lines:
    if re.search(pattern_1, line1):
        #print("level = %s" % level)
        matched = re.search(pattern_1, line1)
        dd = matched.group(1)
        if dd == "suites":
            #data_to_print = "%s" % dd
            if debug_flag: print("Skip suites line")
        else:
            level = level + 1
            if level == 1:
                data_to_print = "%s" % dd
                # print("line1=%s ===" % line1)
                # print("dd=%s ===" % dd)
                # exit()
            else:
                data_to_print = "%s, %s" % (data_to_print, dd)
        # print("line1=%s ===" % line1)
        # print("dd=%s ===" % dd)
        # exit()
    if re.search(pattern_2, line1):
        matched = re.search(pattern_2, line1)
        rr = matched.group(1)
    if re.search(pattern_3, line1):
        matched = re.search(pattern_3, line1)
        pp = matched.group(1)
        pp = pp.replace(",", "-")
        
        data_to_print = "%s, %s" % (data_to_print, pp)
        data_to_print = "%s, %s" % (data_to_print, rr)
        xprint("%s" % data_to_print)
    #print("===== %s =====" % data_to_print)
    if re.search(pattern_4, line1):
        level = level - 1
        new_data_to_print = data_to_print.split(",")[:level]
        #print("level = %s" % level)
        #print("=====%s" % data_to_print)
        # CSDL Test suite GMPO_REL_324, CSDL_Login Test, CSDLLoginTest.CSDLLoginTest, NewUserSignUp_PassphraseLength_7, [], status
        data_to_print = ",".join(new_data_to_print)
        #print("---- %s ----" % data_to_print)
    
    if re.search(pattern_5, line1):
        level = level - 1
        new_data_to_print = data_to_print.split(",")[:level]
        #print("level = %s" % level)
        #print("---- %s" % data_to_print)
        # CSDL Test suite GMPO_REL_324, CSDL_Login Test, CSDLLoginTest.CSDLLoginTest, NewUserSignUp_PassphraseLength_7, [], status
        data_to_print = ",".join(new_data_to_print)
        #print("---- %s ----" % data_to_print)
        
    if level < 0:
        if debug_flag: print("Finished analysing data")
        break
f_updated.close()

if debug_flag: print("Data written to csv file: %s" % excel_to_write)
if debug_flag: print("Tool execution complete!")

if debug_flag: print("<br> Download this file: %s <br>" % out_file)
