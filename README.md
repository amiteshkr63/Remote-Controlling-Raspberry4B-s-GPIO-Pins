# Remote-Controlling-Raspberry4B-s-GPIO-Pins

## Part-A via Configuring PHP to Apache2

Part-1 Creating webpage interface to control GPIO pins via Apache2

Part-2 Enabling Google Home Voice to control GPIO pins

#### Steps for enabling google home assistant to raspberrypi 4b
Reference:
https://developers.google.com/assistant/sdk/guides/service/python

#### Configuring recorder and speaker for raspberry pi 4b

Reference:
https://www.youtube.com/watch?v=mu-Ghn-aeO8&t=93s

Steps
1. Setting Up

2. Connect the speakers into 3.5 mm audio jack.

3. Connect the USB mic into USB ports.

4. Boot up Raspberry Pi Board. If it’s not set up yet, please refer this post.

5. Make sure the speaker is working. The command below can be used for speaker output test. To end the test, press Ctrl-C.

`speaker-test -t wav`

if speaker is not working then edit `.asoundrc` file loction: `home/pi/`

`sudo nano .asoundrc`



#### Basic hardware requirements

Before you begin, you'll need the following components:
-A device running on one of the supported platforms, with internet connectivity
-A microphone
-A speaker

#### How to Record and Playback Audio on Raspberry PI


## Part-B via Configuring Django WebServer to Apache2

Part-1 Creating webpage interface to control GPIO pins via Apache2

Part-2 Enabling Google Home Voice to control GPIO pins

### Hosting Webpage on Raspberry via installing Apache web Server on Raspberry Pi 4B

First step:
ssh to your raspberry pi followed by your password.

```ssh pi@192.168.29.45```

syntax:

```ssh <your pi user name>@<your pi ip address>```

commands:

To make insure that you have latest software package

```sudo apt update```

To ugrade the software apache

```sudo apt upgrade```

To install apache2

```sudo apt install apache2```

To check the status of apache2

```systemctl status apache2```

check if it installed OK

default config file for apache2 is at: ```/etc/apache2/sites-available/000-default.conf```

To view this file
```vi /etc/apache2/sites-available/000-default.conf```

To check the root of your website in
check ```DocumentRoot``` in 

```/etc/apache2/sites-available/000-default.conf file```

this contains some default website files here

Generally ```/var/www/html```

![1](https://user-images.githubusercontent.com/88953654/135122575-5de4c203-5f28-4aab-804f-a1954c46aa59.png)


Goto this directory

```cd /var/www/html```

```ls -la```

generally contains ```index.html```

here only root user can access index.html

so to change ownership, for only html file directory we use cmmnd:

```sudo chown pi:pi .```

if you dont want to change ownership

then, everytime you have to use "sudo" to do anything with this file

Then,

```rm index.html```

then, 

```ls``` 

to check it is removed

then, cut-copy paste your desired html file to index.html

```vi index.html```



 



https://www.youtube.com/watch?v=D6LRa0M4LBI



