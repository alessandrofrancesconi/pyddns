#!/bin/bash

server="http://<server-location>/index.php"
ip="$(curl http://ipecho.net/plain)"
curl --data "newip=${ip}" ${server}
