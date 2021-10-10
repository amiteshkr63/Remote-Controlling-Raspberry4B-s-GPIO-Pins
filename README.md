# Remote-Controlling-Raspberry4B-s-GPIO-Pins

## Part-A via Configuring PHP to Apache2

Part-1 Creating webpage interface to control GPIO pins via Apache2

Part-2 Enabling Google Home Voice to control GPIO pins

### Connecting Bluetooth Headset to Raspberry pi(Tested and Verified)

http://youness.net/raspberry-pi/how-to-connect-bluetooth-headset-or-speaker-to-raspberry-pi-3

> 
Testing:
Make sure the speaker is working. The command below can be used for speaker output test. To end the test, Ctrl+Z

`speaker-test -t wav`

Check the current volume.

`amixer`

From here use following commands to configure your BLUETOOTH HEADSET TO Raspberry pi 4B:

`sudo apt update`

`sudo apt full-upgrade`

`sudo apt-get install pi-bluetooth`

`sudo apt-get install bluetooth bluez blueman`

`sudo apt-get install bluez`

` apt-get install pulseaudio-*.`

`sudo apt-get autoremove`

`sudo reboot`

`sudo apt-get install pulseaudio pulseaudio-module-bluetooth`

if it works for you then, use it Otherwise left it:
`dpkg -l pulseaudio pulseaudio-module-bluetooth`

if bluetooth headset configuration not done after following below all commands:
you have to purge all audio subsystem regarding bluealsa, at last resort. Then, try from start:
`sudo apt purge bluealsa` try after only if you are not able to configure your bluetooth device for recording and speaker purpose

Bluetooth Connection
Now we will connect to the Bluetooth headset (or speaker)
The same steps like in my previous tutorials using bluetoothctl.

Start Bluetoothctl tool and initiate it:

`bluetoothctl`

`power on`

`agent on`

`default-agent`

Turn ON the headset, for mine I press and hold the button till I see white LED blinking + earcon.

Start the scan:

`scan on`

After some seconds, you will see the headset name and `MAC address (xx:xx:xx:xx:xx:xx)`
While scanning, we will kill Bluealsa, and start PulseAudio:

`sudo killall bluealsa`

`pulseaudio --start`

Go back to Bluetoothctl: Pair, trust and connect your device:

`pair xx:xx:xx:xx:xx:xx`

`trust xx:xx:xx:xx:xx:xx`

`connect xx:xx:xx:xx:xx:xx`

At this step, you should have you device successfully connected to Raspberry Pi.

##### A2DP Support
Now let’s check that A2DP streaming is working.
We start by checking that PulseAudio is listing the Bluetooth sound card:

`pacmd list-cards`

The Bluetooth card will be index #1, you can also see the supported profiles (a2dp, hsp, off…)
Bluetooth Headset will be in index #2, you can also see the supported profiles (a2dp, hsp, off…)
Set A2DP as active profile:

`pacmd set-card-profile bluez_card.xx_xx_xx_xx_xx_xx a2dp_sink`

Set the Bluetooth device as output audio:

`pacmd set-default-sink bluez_sink.xx_xx_xx_xx_xx_xx.a2dp_sink`

Download this file and play it:

`wget http://youness.net/wp-content/uploads/2016/08/h2g2.ogg -P /tmp/`

`paplay /tmp/h2g2.ogg`

HSP Support
Now we will check for HSP profile.
If you try to switch to headset_head_unit profile and use parecord to record your voice, it will not work. This is due to an incorrect audio routing of SCO. To correct that, use this command:
`sudo hcitool cmd 0x3F 0x01C 0x01 0x02 0x00 0x01 0x01`
As it is dont include bluetooth mac address here

This is a vendor-specific hexadecimal command, that changes the Broadcom (or Cypress) BCM43438 configuration.

At this step, I couldn’t switch to headset_head_unit:

`pacmd set-card-profile bluez_card.xx_xx_xx_xx_xx_xx headset_head_unit`

I got the error:
Failed to set card profile to ‘headset_head_unit’.

So I rebooted, removed the Bluetooth device and started again from the pairing step.
I can’t tell your what was the problem, but I’m used to this kind of instabilities, just try again.

This time the switch to HSP profile was OK:

`pacmd set-card-profile bluez_card.xx_xx_xx_xx_xx_xx headset_head_unit`

Set the sink and source:

`pacmd set-default-sink bluez_sink.xx_xx_xx_xx_xx_xx.headset_head_unit`

`pacmd set-default-source bluez_source.xx_xx_xx_xx_xx_xx.headset_head_unit`

If you play an audio sound, you will notice the mono quality of headset audio.

`/tmp/h2g2.ogg`

if doesn't work don't worry move ahead

Try to record your voice via Bluetooth device:

`parecord -v /tmp/voice.wav`

Play it back via Bluetooth device:

`paplay -v /tmp/voice.wav`

IT WORKS!
#### Steps for enabling google home assistant to raspberrypi 4b
Reference:
https://developers.google.com/assistant/sdk/guides/service/python

#### Configuring recorder and speaker for raspberry pi 4b

Reference:
https://www.youtube.com/watch?v=mu-Ghn-aeO8&t=93s


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



