import re
import logging

import requests
from urllib3.exceptions import InsecureRequestWarning
from bs4 import BeautifulSoup


def irandjstore(link, headers, site):
    try:
        requests.packages.urllib3.disable_warnings(category=InsecureRequestWarning)
        response = requests.get(link.url, headers=headers, verify=False)
        soup = BeautifulSoup(response.text, "html.parser")
    except Exception as e:
        logger = logging.getLogger(__name__)
        logger.info('%s :  %s,', site, e)

        return None

    if soup.find("button", attrs={"class": "btn btn-primary btn-lg btn-block"}):
        s = soup.find("label",attrs={"class":"control-label price-title"})
        if s is not None:
            a = re.sub(r',', '', s.parent.text).strip()
            b = re.findall(r'\d+', a)
            return int(b[0])
    else:
        return -1