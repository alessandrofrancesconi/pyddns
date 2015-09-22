#!/bin/bash

server="http://<my-server-location>/index.php"
ip=$(curl http://ipecho.net/plain)
curl --data "newip=${ip}" ${server}