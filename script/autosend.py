#!/usr/bin/env python
# -*- coding: utf-8 -*-
import os
import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText

import subprocess
import sys

######## SendMail #######
def sendMail(filename, magnet, filesize):

    ######## Mail Setup ##########
    userid = 'send gmail address'
    userpw = 'send gmail password'
    smtp_host = 'smtp.gmail.com'
    smtp_port = 587
    from_mail = userid
    to_mail = 'Receive email address'

    ######## Mail Content ########
    subject = '[title]' + str(filename).replace('Name:', '').lstrip()
    message = '[Download complete]\ntitle='+ str(filename).replace('Name: ','') + '\n\nMargnet=' + str(magnet).replace("Magnet: ",'') + '\n\nFile Size=' + str(filesize).replace("Have: ","")

    ######## Mail Message Setting #############
    msg = MIMEMultipart('alternative')
    msg['Subject'] = subject
    msg['From'] = from_mail
    msg['To'] = to_mail
    msg.attach(MIMEText(message, 'plain'))

    ######## Mail ##########
    server = smtplib.SMTP(smtp_host, smtp_port)
    server.ehlo()
    server.starttls();
    server.login(userid, userpw)
    server.sendmail(from_mail, to_mail, msg.as_string())
    server.close()


if __name__ == '__main__' :
    sendMail(sys.argv[1],sys.argv[2],sys.argv[3])
