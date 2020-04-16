from selenium import webdriver
import requests
import re
import time
import ssl
import sys
import xml.dom.minidom
# driver = webdriver.Chrome()
# driver.get('https://login.weixin.qq.com/')
# content = driver.page_source
deviceId = 'e000000000000000'
tip = 0
def getUUID():
    global uuid,tip

    url = 'https://login.weixin.qq.com/jslogin'
    params = {
        'appid': 'wx782c26e4c19acffb',
        'fun': 'new',
        'lang': 'zh_CN',
        '_': int(time.time()),
    }

    r = requests.get(url=url, params=params)
    r.encoding = 'utf-8'
    data = r.text

    # print(data)

    # window.QRLogin.code = 200; window.QRLogin.uuid = "oZwt_bFfRg==";
    regx = r'window.QRLogin.code = (\d+); window.QRLogin.uuid = "(\S+?)"'
    pm = re.search(regx, data)

    code = pm.group(1)
    uuid = pm.group(2)

    if code == '200':
        tip = 1
        return True

    return False

getUUID()
print(uuid)

#1
# headers = {
# 'User-Agent':'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36'
# }
# content = requests.get("https://wx.qq.com/",headers=headers)
# pattent = re.compile('<div class="qrcode".*?<img class="img".*?src="https://login.weixin.qq.com/qrcode/(.*?)" mm-src-load=".*?">',re.S)
# resulf = re.findall(pattent,content.text)
# print(resulf)

#2
# pattent = re.compile('<div class="book-info">.*?href="(.*?)".*?target="_blank">(.*?)</a>.*?<div class="author">(.*?)</div>',re.S)
# print(content.text)
# for resulf in resulf:
    # url,name,author=resulf
    # print(url,name,author)