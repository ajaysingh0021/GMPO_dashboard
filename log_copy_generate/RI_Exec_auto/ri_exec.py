import paramiko,pdb,time,socket,subprocess,sys,yaml,platform,os
import urllib.parse,pysftp
from subprocess import Popen


'''Loading Yaml file from the path and saving the data in yaml file to variable config_data'''
filepath = os.path.dirname(os.path.abspath(__file__))
data_file = os.path.join(filepath, sys.argv[1])
config_data = yaml.load(open(data_file, 'r'))
cnopts = pysftp.CnOpts()
cnopts.hostkeys = None

'''Reading each server name and details(if given) and then triggering the run'''

for each_config,data in config_data.items():
    if each_config == 'default':
        continue
    else:
        hostname = each_config
        if "start_execution" in data.keys():
            exec_flag = data['start_execution']
        else:
            exec_flag = config_data['default']['start_execution']
        if exec_flag:
            script_name = data['scriptname']
            if "ssh_username" in data.keys():
                ssh_username = data['ssh_username']
            else:
                ssh_username = config_data['default']['ssh_username']
            if "ssh_password" in data.keys():
                ssh_password = data['ssh_password']
            else:
                ssh_password = config_data['default']['ssh_password']
            if "git_username" in data.keys():
                git_username = data['git_username']
            else:
                git_username = config_data['default']['git_username']
            if "git_password" in data.keys():
                git_password = data['git_password']
            else:
                git_password = config_data['default']['git_password']
            if "git_branchname" in data.keys():
                git_branch_name = data['git_branchname']
            else:
                git_branch_name = config_data['default']['git_branchname']
            if "GMPOserver" in data.keys():
                server_name = data['GMPOserver']
            else:
                server_name = config_data['default']['GMPO_server']

            git_reset = 'git reset --hard'
            git_checkout = 'git checkout -f {}'.format(git_branch_name)
            git_pull = 'git pull https://{}:{}@bitbucket-eng-bgl1.GMPO.com/bitbucket/scm/GMPO/GMPOautomation.git {}'.format(git_username, urllib.parse.quote(u"{}".format(git_password).encode('UTF-8')), git_branch_name)
            print ("###################\n")

            '''Modify the local copy and sftp local GMPO_URL to server'''
            print("Modifying GMPO Server URL...")
            with open("{}\GMPO_URL.properties".format(filepath), 'r')as file:
                init_data = file.readlines()
            print("##########################\n")
            print ("#########################\n")
            print("GMPO URL Info before modification")
            print(init_data)
            for dataline in init_data:
                if "#" not in dataline:
                    init_data[init_data.index(dataline)] = "URL=https://{}\n".format(server_name)
            with open("{}\GMPO_URL.properties".format(filepath), 'w') as file:
                file.writelines(init_data)
            print("GMPO URL Info after modification")
            print(init_data)
            '''connect to the server, delete temp files,git related commands and trigger RI'''
            try:
                ssh = paramiko.SSHClient()
                ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
                ssh.connect(hostname,username=ssh_username,password=ssh_password)
                print("Connected to %s" % hostname)
            except paramiko.AuthenticationException:
                print("Failed to connect to %s due to wrong username/password" %hostname)
                exit(1)
            except Exception as e:
                print ("SSH connection to {} failed with below exception \n".format(hostname))
                print(e)
                exit(2)

            try:
                if platform.system() == "Windows":
                    # print("Rebooting VM")
                    # rstrt_cmd = "shutdown /r /t 0"
                    # ssh.exec_command("cmd.exe /c {}".format(rstrt_cmd))
                    # print ("sleep time after reboot")
                    # time.sleep(120)
                    # print ("###################\n")
                    # print ("###################\n")
                    # print ("After reboot, enabling interactive session detection on remote end")
                    ssh.connect(hostname, username=ssh_username, password=ssh_password)
                    commands = ["cd C:\\", "cd GMPOautomation", git_reset, git_checkout, git_pull]
                    command_1= ["cd C:\\", "cd GMPOautomation","cd NGGMPODriver","mvn clean test -{}".format(script_name)]
                    cmd = " ^& ".join(commands)
                    cmd_1 = " ^& ".join(command_1)
                    print ("Deleting temp files")
                    tmp_files = "del /q/f/s %TEMP%\*"
                    stdin, stdout, stderr = ssh.exec_command("cmd.exe /c {}".format(tmp_files))
                    err = ''.join(stderr.readlines())
                    out = ''.join(stdout.readlines())
                    final_output = str(out) + str(err)
                    print(final_output)
                    stdin, stdout, stderr = ssh.exec_command("cmd.exe /c start cmd.exe /k {}".format(cmd))
                    err = ''.join(stderr.readlines())
                    out = ''.join(stdout.readlines())
                    final_output = str(out) + str(err)
                    print(final_output)
                    with pysftp.Connection(host=hostname,username=ssh_username,password=ssh_password,cnopts=cnopts)as sftp:
                        remotepath = '/GMPOautomation/NGGMPODriver/SUT/GMPO_URL.properties'
                        localpath = 'C:/GMPO/RI_Exec_auto/GMPO_URL.properties'
                        sftp.put(localpath, remotepath)
                        sftp.close()
                    time.sleep(60)
                    print ("Starting RI Execution on {}......".format(hostname))
                    time.sleep(2)
                    stdin,stdout,stderr = ssh.exec_command("cmd /c start cmd.exe /k {}".format(cmd_1))
                    err = ''.join(stderr.readlines())
                    out = ''.join(stdout.readlines())
                    final_output = str(out) + str(err)
                    print(final_output)
                    ssh.close()
                else:
                    commands = ["cd /home/GMPO/ri_exec_auto/GMPOautomation", "cd NGGMPODriver", "mvn clean test -{}".format(script_name)]
                    channel = ssh.invoke_shell()
                    out = channel.recv(9999)
                    for cmd in commands:
                        print ("sending command --- {}"+ '\n'.format(cmd ))
                        channel.send(cmd)
                        while not channel.recv_ready():
                            time.sleep(3)

                        out = channel.recv(9999)
                        print(out.decode("ascii"))
                    ssh.close()

            except Exception as e:
                print(e.message)


