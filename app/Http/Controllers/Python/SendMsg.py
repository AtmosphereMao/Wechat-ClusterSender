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

# base_uri = urllib.parse.unquote(sys.argv[1])
# redirect_uri = urllib.parse.unquote(sys.argv[2])
# push_uri = urllib.parse.unquote(sys.argv[3])

print(sys.argv[1])