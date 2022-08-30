import os,requests,sys
import pdb
# import openpyxl
import time,csv

# sample new_filename:
# GMPO4.1_eft1_legacy_<build#>, GMPO4.1_eft1_newFeatures_<build#>, GMPO4.1_eft1_sanity_<build#>, GMPO4.1_eft1_hpalm_<build#>
# Sample master_filename:
# GMPO4.1_eft1_legacy_master, GMPO4.1_eft1_newFeatures_master, GMPO4.1_eft1_sanity_master, GMPO4.1_eft1_hpalm_master

debug = True

master_file = sys.argv[1]
user_input_url = sys.argv[2]
build_number = sys.argv[3]

master_files_folder = "master_files"
master_filename = master_files_folder + "/" + master_file

temp_res_folder = "temp_results_folder"
new_filename = temp_res_folder + "/" + user_input_url.split('/')[-3] + "--FA.csv"

timestamp = datetime.today().strftime("%Y%m%d%H%M%S")
backup_folder = "backup_folder"
backup_filename = backup_folder + "/" + timestamp + "_" + master_file

if debug:
    master_filename = master_files_folder + "/" + "GMPO4.1_eft1_NewFeatures_master.csv"
    new_filename = temp_res_folder + "/" + "GMPO4.1_eft1_NewFeatures_230.csv"
    #build_number = "231"

os_type = "non-windows"
#os_type = "windows"
if "non-windows" in os_type:
    dir_delimiter = "/"
else:
    dir_delimiter = "\\"

current_directory = os.getcwd()

data = []
data_new = []
diff_data = []
read_file = current_directory + dir_delimiter + new_filename
write_file = current_directory + dir_delimiter + master_filename

# Column Names:
# Status-build_number, FA-State-<build_number>, Owner-<build_number>, Bug/Auton-<build_number>, Comments-<build_number>
col_status = "Status-%s" % build_number
col_fastate = "FA-State-%s" % build_number
col_owner = "Owner-%s" % build_number
col_bug = "Bug/Auton-%s" % build_number
col_comment = "Comments-%s" % build_number


with open(write_file, "r") as w_upd_results:
    w_reader_report = w_upd_results.readlines()

with open(read_file)as r_csv_file:
    with open(write_file, "r") as w_upd_results:
        r_csv_reader = csv.DictReader(r_csv_file, delimiter=",")
        w_csv_reader = csv.DictReader(w_upd_results, delimiter=",")
        
        if len(w_reader_report) <=1 :
            header_names = r_csv_reader.fieldnames
            print("AJ1: %s" % header_names)
            # header_names.append(build_number)
            header_names.append(col_status)
            header_names.append(col_fastate)
            header_names.append(col_owner)
            header_names.append(col_bug)
            header_names.append(col_comment)
        else:
            header_names = w_csv_reader.fieldnames
            print("AJ2: %s" % header_names)
            if col_status not in header_names:
                #header_names.append("Build-%s" %build_number)
                header_names.append(col_status)
                header_names.append(col_fastate)
                header_names.append(col_owner)
                header_names.append(col_bug)
                header_names.append(col_comment)
            else:
                print ("WARNING:: Build %s data already present in master sheet!" % build_number)
        
        for row in r_csv_reader:
            found_flag = False
            row_1 = row
            result = row_1.pop(' Status')
            if len(w_reader_report) <= 1:
                row_1.update({build_name:result})
                data.append(row_1)
                print("AJ3: %s" % data)
            else:
                for row_new in w_csv_reader:
                    if row_1['Suite'] == row_new['Suite']:
                        # tc_flag = True
                        if row_1[' Main-Scenario'] == row_new[' Main-Scenario']:
                            if row_1[' Sub-Scenario'] == row_new[' Sub-Scenario']:
                                if row_1[' Test'] == row_new[' Test']:
                                    if row_1[' Parameter'] == row_new[' Parameter']:
                                        found_flag = True
                                        if col_status in row_new.keys():
                                            row_new[col_status] = result
                                        else:
                                            row_new.update({col_status:result})
                                        data.append(row_new)
                                        break
                if not found_flag:
                    print ("Adding in main report")
                    row_1.update({col_status:result})
                    data.append(row_1)
                    print (row_1)
        print ("################")
        print (len(data))
        print ("################")
#pdb.set_trace()
with open(write_file, "r") as w_upd_results:
    w_csv_reader = csv.DictReader(w_upd_results,delimiter=",")
    for row in w_csv_reader:
        found_flag = False
        for row_new in data:
            if row['Suite'] == row_new['Suite']:
                if row[' Main-Scenario'] == row_new[' Main-Scenario']:
                    if row[' Sub-Scenario'] == row_new[' Sub-Scenario']:
                        if row[' Test'] == row_new[' Test']:
                            if row[' Parameter'] == row_new[' Parameter']:
                                found_flag = True
                                break
        if not found_flag:
            if col_status in row.keys():
                if row[col_status].lower() in ["passed","failed"]:
                    continue
            else:
                row.update({col_status:"Not Executed"})
            data.append(row)
        
        
    with open(write_file,"w",newline='') as write_results:
        writer = csv.DictWriter(write_results,fieldnames=header_names)
        writer.writeheader()        
        writer.writerows(data)


print("<a href=\'%s\'> <img src=\"../images/csv.jpeg\" alt=\"Export Report\" style=\"width:62px;height:62px;\"> </a>" % master_filename)

