from lxml import html
import requests
import xlwt
import re
import pdb
import sys

# easy_install lxml
# easy_install requests
# easy_install xlwt

print('Script started')
user_name = sys.argv[1]
password = sys.argv[2]
result_path = sys.argv[3]

# print('user_name = %s'%user_name)
# print('password = %s'%password)
# print('result_path = %s'%result_path)
# print('--------------------')
# USER INPUT NEEDED: CEC Username, CEC Password, Result-path
# user_name = 'gmpoemailid'
# password = ''
#result_path = 'http://earms-trade.GMPO.com/tradeui/CLResults.jsp?ats=/ws/gmpoemailid-bgl/pyATS/pyats&archive=2016/07/09/22/45/sauron_gmpls_aps_job.2016Jul09_22:45:55.zip'
#result_path = 'http://earms-trade.GMPO.com/tradeui/CLResults.jsp?ats=/ws/gmpoemailid-bgl/pyATS/pyats&archive=2016/08/16/23/12/sauron_gmpls_aps_job.2016Aug16_23:12:34.zip'

#result_path = 'http://earms-trade.GMPO.com/tradeui/CLResults.jsp?ats=/ws/somane-bgl/pyATS/pyats&archive=2017/03/02/08/07/sauron_gmpls_aps_98_regression_job.2017Mar02_08:07:32.zip'
#result_path = 'http://earms-trade.GMPO.com/tradeui/CLResults.jsp?ats=/ws/somane-bgl/pyATS/pyats&archive=2017/03/08/17/31/sauron_gmpls_aps_98_regression_job.2017Mar08_17:31:08.zip'
# result_path = 'http://earms-trade.GMPO.com/tradeui/CLResults.jsp?ats=/ws/tpalled-bgl/pyATS/pyats&archive=2017/03/10/17/04/envmon.2017Mar10_17:04:23.zip'

#log_parser_xl_file = 'c:\\log_parser_time_status.xls'
log_parser_xl_file = 'log_parser_time_status.xls'
regexp = re.compile("\d{2}\:\d{2}\:\d{2}")
book = xlwt.Workbook(encoding="utf-8")
sheet = book.add_sheet("result")

print('Reading: %s'%result_path)
page = requests.get(result_path,auth=(user_name, password))
print('Finished reading')
print('Page: %s'%page)
if page.status_code == 401:
    print('ERROR: Incorrect user/password. Provide \'user_name\' and \'password\' in the file')
    exit()
if page.status_code == 500:
    print('ERROR: Incorrect result path specified. Provide correct \'result_path\' in the file')
    exit()
tree = html.fromstring(page.content)
table_list = tree.xpath('//tr/td/text() | //tr/td/span/text()')
print('table_list: %s'%table_list)

b_start = False
count = 0
after_image = 0
str_list = []
start_str = ''
middle_str = '\t'
row = 0
col = 0

# Find the testbed name - after that only testdata starts in the table.
testbed_name = 'GMPO'
for i in range(len(table_list)):
    list_data = table_list[i]
    #print('table_list[%s] = %s'%(i,list_data))
    if 'Testbed' in list_data:
        #print('Found Testbed at position: %s'%i)
        testbed_name = table_list[i+1]
        print('Testbed Name = %s'%testbed_name)
        #exit()

# Creating a HTML file with results table 
fhtml = open('logs_test_time_status.html', 'w')

fhtml.write('<html><head><style>')
fhtml.write('table, th, td {border: 1px solid black;}')
fhtml.write('</style></head><body>')

fhtml.write('<table>')
#style="border: 1px solid black;"
fhtml.write('<tr><th>Test</th><th>Time</th><th>Status</th></tr>')

#for i in output:
for item in table_list:
    #pdb.set_trace()
    i=item.replace('\n','')
    i=i.replace('\t','')
    
    if re.match('^\S+',i):
        i = i.rstrip()
        i = i.lstrip()
        #print("1-%s"%i)
        #if 'GMPO' in i or 'GMPO' in i:
        if testbed_name in i:
            b_start = True
            after_image = 1
            print('-----STARTED PARSING NOW-----')
            #exit()
            continue
        if not b_start:
            continue
        if after_image == 1:
            after_image = 0
            str_to_print = 'Total_Time\t\t%s'%i
            #col = 1
            print(str_to_print)
            row = row + 1
            col = 0
            data = 'Total_Time'
            sheet.write(row,col,data)
            fhtml.write('<tr><td>Total_Time</td>')
            #row = row + 1
            col = 2
            data = '%s'%i
            sheet.write(row,col,data)
            #fhtml.write('<td></td><td>%s</td><td></td></tr>'%data)
            fhtml.write('<td>%s</td><td></td></tr>'%data)
            #fhtml.write('<tr> <td></td> <td></td> <td>%s</td> <td></td> </tr>'%data)
            
            continue
        if 'passed' in i or 'failed' in i or 'errored' in i:
            count = 0
            str_list = []
        if 'Txh' in i and not 'test_Txh' in i:
            start_str = ''
            middle_str = '\t'
        if 'test_setup' in i or 'intial_setup' in i:
            start_str = '\t'
            middle_str = ''
        if 'common cleanup' in i:
            start_str = ''
            middle_str = '\t'
        str_list.append(i)
        if len(str_list) > 2:
            str_to_print = '%s%s\t%s%s\t%s'%(start_str,str_list[2],middle_str,str_list[1],str_list[0])
            print(str_to_print)
            fhtml.write('<tr>')
            row = row + 1
            col = 0
            if start_str == '':
                col = 0
            else:
                col = col+1
            data = '%s'%str_list[2]
            sheet.write(row,col,data)
            fhtml.write('<td>%s</td>'%data)
            
            # base_str = ''
            # for xx in range(col):
                # base_str = '%s<td></td>'%base_str
            # base_str = '%s<td>%s</td>'%(base_str,data)
            # fhtml.write(base_str)
            
            if middle_str == '':
                col = col+1
            else:
                col = col+2
            data = '%s'%str_list[1]
            sheet.write(row,col,data)
            fhtml.write('<td>%s</td>'%data)
            
            # base_str = ''
            # for xx in range(col):
                # base_str = '%s<td></td>'%base_str
            # base_str = '%s<td>%s</td>'%(base_str,data)
            # fhtml.write(base_str)
            # fhtml.write(' <td></td> <td>%s</td> '%data)
            
            col = col + 1
            data = '%s'%str_list[0]
            sheet.write(row,col,data)
            fhtml.write('<td>%s</td>'%data)
            fhtml.write('</tr>')
            # fhtml.write(' <td>%s</td> </tr>'%data)
            
        count = count + 1
        # if count == 3:
            # print('-------------------------------')
            # str_list = []
        if 'test_cleanup' in i:
            start_str = ''
            middle_str = '\t'
        if 'disconnect_devices' in i:
            b_start = False
        if 'common setup' in i:
            start_str = '\t'
            middle_str = ''

book.save(log_parser_xl_file)
print('Saved xls file: %s'%log_parser_xl_file)
fhtml.write('</table></body></html>')
fhtml.close()