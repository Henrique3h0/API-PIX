#EXEMPLO EM PYTHON
import urllib.request
from urllib.parse import quote
value = 1
bearer = xxxxxxx
url = "127.0.0.1/api.php?value={}&bearer={}".format(value, bearer)
print(urllib.request.urlopen(url).read())
