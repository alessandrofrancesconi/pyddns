pyddns
======
The simplest solution for a personal DDNS
-----------------------------------------

One day I received a [Raspberry Pi 2 Model B](https://www.raspberrypi.org/products/raspberry-pi-2-model-b/) by some friends and I started some experiments with it.

One of the first tasks was a classic: to build a Linux-powered server so I can access my files from outside my Local Area Network.
Tipically, one should follow these steps:

1. Install Apache2 or similar into the Raspberry (or whatever)
2. Test if it's accessible from inside the LAN using its local address, like `http://192.168.0.100:80`
3. Make it reachable from *anywhere* outside by doing:
    * Port forwarding, so when I type `http://<my-external-ip>:<my-port>` it's like I'm calling `http://192.168.0.100:80`
    * Set up a (free?) Dynamics DNS account somewhere so I can forget about IPs and just reach my machine using `http://<my-account>.ddns.net`
    
After finishing the last point (by the way, I had a [No-Ip](http://www.noip.com/) account) I realized that... *was it that simple?*

I already have a personal website on a shared-hosting running PHP, why should I depend on another service (with potential limitations due to a free account)? 
So here is **pyddns**!


What does pyddns do?
--------------------

pyddns makes your current website a real Dynamic Domain Name Server, without efforts. Say you own a website like `http://www.example.com`, you will 
end up with the possibility to reach your home server with `http://www.example.com/home` as it will always point to the most recent IP.
The process that maintains the IP updated is automatic.

*P.S.: "pyddns" comes from "Pi" + "My" + "DDNS"*

How to install it?
------------------

First, the requirements:

* An home server (Raspberry? Banana Pi? Traditional PC? ...) running Linux
* A website hosted somewhere capable of running PHP
* 5 minutes of your spare time

There is another fundamental requirement, anyway: your home router must forward the traffic coming from an external port (like `12345`)
to the internal IP of your home server. There is a guide [here](http://raspisimon.no-ip.org/portforwarding.php).

This project is composed by two folders: `/client` and `/server`. We start with the second one: create a folder in your hosted website 
(e.g. `http://www.example.com/home`) and **upload `index.php` and `ip.txt` in it**.

`index.php` is your DNS. When you reach it, it reads the contents of `ip.txt`, that simply contains the most recent public IP of your home LAN.
If it is valid, it redirects you to `http://<the-ip>:12345` (the port you opened before) and you will say *hurray!*

How to maintain `ip.txt` updated? `index.php` accepts a POST request in the form `"newip=XXX.XXX.XXX.XXX"`. When it receives that kind of request, 
it simply overrides the previous IP with the new one given. But who makes this request? The client!

Just open the `/client` folder, edit the `renew-ip.sh` file and replace `<server-location>` with your DNS address (like `http://www.example.com/home`). 
Then **copy it to your home server in this location: `/etc/network/if-up.d`**. Ensure it is executable using `chmod +x renew-ip.sh`. 
This script runs every time the connection is established and fires the POST request to the server. 

No more. Goodbye!