from selenium import webdriver
import requests
import re
import time
import ssl
import sys
import xml.dom.minidom
import urllib.parse
import io
import json
import threading

DEBUG = False
sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')
deviceId = 'e000000000000000'
tip = 1

def getvalue():
    global base_uri,redirect_uri,push_uri
    base_uri = urllib.parse.unquote(sys.argv[1])
    redirect_uri = urllib.parse.unquote(sys.argv[2])
    push_uri = urllib.parse.unquote(sys.argv[3])

def login():
    global skey, wxsid, wxuin, pass_ticket, BaseRequest

    r = myRequests.get(url=redirect_uri)
    r.encoding = 'utf-8'
    data = r.text

    doc = xml.dom.minidom.parseString(data)
    root = doc.documentElement

    for node in root.childNodes:
        if node.nodeName == 'skey':
            skey = node.childNodes[0].data
        elif node.nodeName == 'wxsid':
            wxsid = node.childNodes[0].data
        elif node.nodeName == 'wxuin':
            wxuin = node.childNodes[0].data
        elif node.nodeName == 'pass_ticket':
            pass_ticket = node.childNodes[0].data

    if not all((skey, wxsid, wxuin, pass_ticket)):
        return False

    BaseRequest = {
        'Uin': int(wxuin),
        'Sid': wxsid,
        'Skey': skey,
        'DeviceID': deviceId,
    }
    return True





##
def webwxinit():

    url = (base_uri +
           '/webwxinit?pass_ticket=%s&skey=%s&r=%s' % (
               pass_ticket, skey, int(time.time())))
    params = {'BaseRequest': BaseRequest}
    headers = {'content-type': 'application/json; charset=UTF-8'}

    r = myRequests.post(url=url, data=json.dumps(params), headers=headers)
    r.encoding = 'utf-8'
    data = r.json()
    # print(data)

    if DEBUG:
        f = open(os.path.join(os.getcwd(), 'webwxinit.json'), 'wb')
        f.write(r.content)
        f.close()


    global ContactList, My, SyncKey
    dic = data
    ContactList = dic['ContactList']
    My = dic['User']
    SyncKey = dic['SyncKey']

    state = responseState('webwxinit', dic['BaseResponse'])
    return state


def webwxgetcontact():
    url = (base_uri +
           '/webwxgetcontact?pass_ticket=%s&skey=%s&r=%s' % (
               pass_ticket, skey, int(time.time())))

    headers = {'content-type': 'application/json; charset=UTF-8'}

    r = myRequests.post(url=url, headers=headers)
    r.encoding = 'utf-8'
    data = r.json()

    if DEBUG:
        f = open(os.path.join(os.getcwd(), 'webwxgetcontact.json'), 'wb')
        f.write(r.content)
        f.close()

    dic = data
    MemberList = dic['MemberList']
    SpecialUsers = ["newsapp", "fmessage", "filehelper", "weibo", "qqmail", "tmessage", "qmessage", "qqsync",
                    "floatbottle", "lbsapp", "shakeapp", "medianote", "qqfriend", "readerapp", "blogapp", "facebookapp",
                    "masssendapp",
                    "meishiapp", "feedsapp", "voip", "blogappweixin", "weixin", "brandsessionholder", "weixinreminder",
                    "wxid_novlwrv3lqwv11", "gh_22b87fa7cb3c", "officialaccounts", "notification_messages", "wxitil",
                    "userexperience_alarm"]
    for i in range(len(MemberList) - 1, -1, -1):
        Member = MemberList[i]
        #删除多余用户，只计算通讯录好友
        if Member['VerifyFlag'] & 8 != 0:  # 公众号/服务号
            MemberList.remove(Member)
        elif Member['UserName'] in SpecialUsers:  # 特殊账号
            MemberList.remove(Member)
        elif Member['UserName'].find('@@') != -1:  # 群聊
            MemberList.remove(Member)
        elif Member['UserName'] == My['UserName']:  # 自己
            MemberList.remove(Member)

    return MemberList


def responseState(func, BaseResponse):
    ErrMsg = BaseResponse['ErrMsg']
    Ret = BaseResponse['Ret']
    if DEBUG or Ret != 0:
        print('func: %s, Ret: %d, ErrMsg: %s' % (func, Ret, ErrMsg))

    if Ret != 0:
        return False

    return True


def heartBeatLoop():
    while True:
        selector = syncCheck()
        if selector != '0':
            webwxsync()
        time.sleep(1)


def main():
    global myRequests,friend_array

    if hasattr(ssl, '_create_unverified_context'):
        ssl._create_default_https_context = ssl._create_unverified_context

    headers = {
        'User-agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.125 Safari/537.36'}
    myRequests = requests.Session() #session()模拟登录 默认使用该session之前使用的cookie等参数
    myRequests.headers.update(headers)

    getvalue()

    if not login():
        print('登录失败')
        return

    if not webwxinit():
        print('初始化失败')
        return

    MemberList = webwxgetcontact()

    threading.Thread(target=heartBeatLoop)

    MemberCount = len(MemberList)
    print('通讯录共%s位好友' % MemberCount)

    d = {}
    List = 0
    friend_array=[]
    for Member in MemberList:
        List = List + 1
        # name = '/Users/wetchat-images/' + str(imageIndex) + '.jpg'
        # imageUrl = 'https://wx.qq.com' + Member['HeadImgUrl']
        # r = myRequests.get(url=imageUrl, headers=headers)
        # imageContent = (r.content)
        # fileImage = open(name, 'wb')
        # fileImage.write(imageContent)
        # fileImage.close()
        # print('正在下载第：' + str(imageIndex) + '位好友头像')
        d[Member['UserName']] = (Member['NickName'], Member['RemarkName'])




        # 名字
        name = Member['NickName']
        name = 'NULL' if name == '' else  name
        # 备注名
        remark = Member['RemarkName']
        remark = 'NULL' if remark == '' else remark
        # 城市 -省
        province = Member['Province']
        province = 'NULL' if province == '' else province
        # 城市 -市
        city = Member['City']
        city = 'NULL' if city == '' else  city

        # 个人信息，签名
        # sign = Member['Signature']
        # sign = 'nosign' if sign == '' else  sign
        # 别名
        # alias = Member['Alias']
        # alias = 'noalias' if alias == '' else alias
        # resulf = '名字:'+name+',城市:', province,city, '性别:', Member['Sex'], '备注名:', remark
        friend_info = [name,remark,province,city]
        friend_array.append(friend_info)





if __name__ == '__main__':
    main()
print(friend_array)