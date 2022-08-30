import os,requests,pdb,openpyxl,sys
import time,csv
run_flag = sys.argv[1]
#run_flag = "RI"
build_name = sys.argv[2]
#build_name = "GA_1403"
current_directory = os.getcwd()
build_number = sys.argv[3]
#build_number = "4.0"

filename = "latest_exec_results.csv"
if run_flag.lower() == "sanity":
    master_filename = "Master_Report_Sanity_{}.csv".format(build_number)
if run_flag.lower() == "ri":
    master_filename = "Master_Report_RI_{}.csv".format(build_number)
else:
    master_filename = "Master_Report_{}_{}.csv".format(run_flag, build_number)
data = []
data_new = []
diff_data = []
read_file = current_directory+"\\"+filename
    
with open(current_directory+"\\"+master_filename, "r") as upd_results:
    reader_report = upd_results.readlines()

with open(read_file)as csv_file:
    with open(current_directory+"\\"+master_filename, "r") as upd_results:
        csv_reader = csv.DictReader(csv_file,delimiter=",")
        reader = csv.DictReader(upd_results,delimiter=",")
        if len(reader_report) <=1 :
            header_names = csv_reader.fieldnames
            header_names.append(build_name)
        else:
            header_names = reader.fieldnames
            if build_name not in header_names:
                header_names.append(build_name)
            else:
                print ("Build already exists")
        
        for row in csv_reader:
            found_flag = False
            row_1 = row
            result= row_1.pop(' Status')
            if len(reader_report) <= 1:
                row_1.update({build_name:result})
                data.append(row_1)
            else:
                for row_new in reader:
                    if row_1['Suite'] == row_new['Suite']:
                        tc_flag = True
                        if row_1[' Main-Scenario'] == row_new[' Main-Scenario']:
                            if row_1[' Sub-Scenario'] == row_new[' Sub-Scenario']:
                                if row_1[' Test'] == row_new[' Test']:
                                    if row_1[' Parameter'] == row_new[' Parameter']:
                                        found_flag = True
                                        if build_name in row_new.keys():
                                            row_new[build_name] = result
                                        else:
                                            row_new.update({build_name:result})
                                        data.append(row_new)
                                        break
                if not found_flag:
                    print ("Adding in main report")
                    row_1.update({build_name:result})
                    data.append(row_1)
                    print (row_1)
        print ("################")
        print (len(data))
        print ("################")
with open(current_directory+"\\"+master_filename, "r") as upd_results:
    reader = csv.DictReader(upd_results,delimiter=",")
    for row in reader:
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
            if build_name in row.keys():
                if row[build_name].lower() in ["passed","failed"]:
                    continue
            else:
                row.update({build_name:"Not Executed"})
            data.append(row)
        
        
    with open(current_directory+"\\"+master_filename,"w",newline='') as write_results:
        writer = csv.DictWriter(write_results,fieldnames=header_names)
        writer.writeheader()        
        writer.writerows(data)
                
                
        
        
