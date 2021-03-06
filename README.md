# Remote-Controlling-Raspberry4B-s-GPIO-Pins

## Part-A via Configuring PHP to Apache2

Part-1 Creating PHP webpage interface to control GPIO pins using Python via Apache2 webserver

php and python files in Repository

![ezgif com-gif-maker (1)](https://user-images.githubusercontent.com/88953654/137594159-a2ad5b67-3741-483d-b879-6f26138ef2f6.gif)

![Screenshot (1868)](https://user-images.githubusercontent.com/88953654/137594812-bf5d42f2-02f8-4398-bfff-59acac5b4bdd.png)

Part-2 Enabling Google Home Voice to control GPIO pins using Bluetooth Headset

### Connecting Bluetooth Headset to Raspberry pi(Tested and Verified)

Demonstration Video: https://drive.google.com/file/d/1dn_fwHKDbtVWa4r5jnmrnZIOquhN2Hd0/view?usp=sharing

![A2DPHSP-768x569](https://user-images.githubusercontent.com/88953654/136789043-27c8233c-a2e2-475f-a101-271dde5dddcc.jpg)

Compatability For Diff, Bluetooth Headsets for Raspberry pi: https://wiki.gentoo.org/wiki/Bluetooth_headset

Testing:
Make sure the speaker is working. The command below can be used for speaker output test. To end the test, Ctrl+Z

`speaker-test -t wav`

Check the current volume.

`amixer`

`sudo apt-get update`

`sudo apt-get upgrade`

Adding Pi To Bluetooth Users

`sudo usermod -G bluetooth -a pi`

Now reboot:

`sudo reboot now`

Install Bluealsa and Pulseaudio Module(Audio subsystem for pi):

`
sudo apt-get install bluealsa pulseaudio
`

SAP Driver Initialization Failure:

check bluetooth service starting status:

`
sudo systemctl status bluetooth.service
`

![Screenshot (1796)](https://user-images.githubusercontent.com/88953654/136737149-8ff1c8db-9fb7-4d11-baec-629031f57a2c.png)

The “Sap driver initialization failed.” notices that someting is going wrong on startup. This can be fixed simply stopping the SIM profile loading. With your favourite text editor (mine one is nano), modify “/lib/systemd/system/bluetooth.service” file to add “–noplugin=sap” option near “ExecStart=/usr/lib/bluetooth/bluetoothd” configuration:

`
sudo nano /lib/systemd/system/bluetooth.service
`

![Screenshot (1797)](https://user-images.githubusercontent.com/88953654/136737325-9975dcae-1708-4e16-8765-8a76f46aac9a.png)

Now Reboot:

`
sudo reboot now
`

Privacy Setting Rejected Failure:

once again check blutooth service

`
sudo systemctl status bluetooth.service
`

![Screenshot (1798)](https://user-images.githubusercontent.com/88953654/136737588-4cb12e91-f56b-4a9a-a854-faa112d4883d.png)

`
sudo nano /lib/systemd/system/bthelper@.service
`

and make it the same as the following:

```

[Unit]
Description=Raspberry Pi bluetooth helper
Requires=bluetooth.service
After=bluetooth.service

[Service]
Type=simple
ExecStartPre=/bin/sleep 2
ExecStart=/usr/bin/bthelper %I


```

![Screenshot (1799)](https://user-images.githubusercontent.com/88953654/136737748-349c0248-5e5f-42f6-91a8-1008fa973dd8.png)

Reboot again and now everything should be ok with sudo systemctl status bluetooth.service.

Check That Pulseaudio Is Running:

`
ps aux | grep pulseaudio
`

If this command returns the following output:

> pi@raspberrypi:~ $ ps aux | grep pulseaudio
> pi 538 0.0 0.0 7348 504 pts/0 S+ 22:01 0:00 grep --color=auto pulseaudio
> 

then you must manually launch pulseaudio:

```
pulseaudio --start
```
so that you should see the correct status from ps aux | grep pulseaudio command:

> 
> pi@raspberrypi:~ $ ps aux | grep pulseaudio
> pi 544 4.3 1.8 181592 17720 ? Sl 22:02 0:00 pulseaudio --start
> pi 564 0.0 0.0 7348 488 pts/0 S+ 22:02 0:00 grep --color=auto pulseaudio

![Screenshot (1801)](https://user-images.githubusercontent.com/88953654/136737856-2f402aa2-1a8d-411e-a60f-3ca7f3bfad46.png)

##### Now, Pair Bluetooth Device


if it works for you then, use it Otherwise left it:

`dpkg -l pulseaudio pulseaudio-module-bluetooth`

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
We are doing it because we can't run pulseaudio and bluealsa simultaneously:

`sudo killall bluealsa`

`pulseaudio --start`

Go back to Bluetoothctl: Pair, trust and connect your device:

`bluetoothctl`

`pair EB:06:EF:6A:D4:17`

`trust EB:06:EF:6A:D4:17`

`connect EB:06:EF:6A:D4:17`


At this step, you should have you device successfully connected to Raspberry Pi.

> if you are able to connect bluetooth device, then skip to 'A2DP Support' section

 
> If you are able to pair and trust the bluetooth device but not able to connect to it:
 Then,

`bluetoothctl`

`remove EB:06:EF:6A:D4:17`

Press `Ctrl+Z` get out of it.

```

bluetoothctl

power on

agent on

default-agent

scan on

```
wait for it to detect your bluetooth device, Then `Ctrl+Z` to get out of it. if it is not detecting your bluetooth device.Then, Switch off your bluetooth device and
 try to repeat the same above procedure but just before entering cmmnd 'scan on' switch ON your Bluetooth device. After this it should detect your bluetooth device. Even now if it doesn't detect it.Then, your 'Raspberry pi bluetooth is NOT DISCOVERABLE make it DISCOVERABLE'.

```

sudo killall bluealsa

pulseaudio --start

bluetoothctl

power on

agent on

default-agent

pair EB:06:EF:6A:D4:17

trust EB:06:EF:6A:D4:17

```

Press `Ctrl+Z` to get out of it.

```
sudo apt install pulseaudio-module-bluetooth 

pulseaudio -k

pulseaudio --start
 
bluetoothctl

power on

agent on

default-agent
 
connect EB:06:EF:6A:D4:17

```


> If anyhow doesn't workout then only use this cmmnd:

> `sudo pactl load-module module-bluetooth-discover`

##### A2DP Support
Now let’s check that A2DP streaming is working.
We start by checking that PulseAudio is listing the Bluetooth sound card:

`pacmd list-cards`

The Bluetooth card will be index #1, you can also see the supported profiles (a2dp, hsp, off…)
Bluetooth Headset will be in index #2, you can also see the supported profiles (a2dp, hsp, off…)
Set A2DP as active profile:

`pacmd set-card-profile bluez_card.EB_06_EF_6A_D4_17 a2dp_sink`

Set the Bluetooth device as output audio:

`pacmd set-default-sink bluez_sink.EB_06_EF_6A_D4_17.a2dp_sink`

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

`pacmd set-card-profile bluez_card.EB_06_EF_6A_D4_17 headset_head_unit`

I got the error:
Failed to set card profile to ‘headset_head_unit’.

So I rebooted, removed the Bluetooth device and started again from the pairing step.
I can’t tell your what was the problem, but I’m used to this kind of instabilities, just try again.

This time the switch to HSP profile was OK:

`pacmd set-card-profile bluez_card.EB_06_EF_6A_D4_17 headset_head_unit`

Set the sink and source:

`pacmd set-default-sink bluez_sink.EB_06_EF_6A_D4_17.headset_head_unit`

`pacmd set-default-source bluez_source.EB_06_EF_6A_D4_17.headset_head_unit`

If you play an audio sound, you will notice the mono quality of headset audio.

`paplay /tmp/h2g2.ogg`

if doesn't work don't worry move ahead

Try to record your voice via Bluetooth device:

`parecord -v /tmp/voice.wav`

Play it back via Bluetooth device:

`paplay -v /tmp/voice.wav`

IT WORKS!
 
 > If you don't want to do this bluetooth configuration everytime you just have to paste a cmmnd in your /etc/rc.local file:

`sudo vi /etc/rc.local `

![Screenshot (1803)](https://user-images.githubusercontent.com/88953654/136788218-0b814cb3-6249-4483-a9b9-335e15b61b79.png)

#### Configuring recorder and speaker for raspberry pi 4b via external audio card recorder 3.5mm 

Reference:
https://www.youtube.com/watch?v=mu-Ghn-aeO8&t=93s
 
#### Steps for enabling google home assistant to raspberrypi 4b
Reference:
https://developers.google.com/assistant/sdk/guides/service/python/embed/audio?hardware=rpi

 
 Goto `.asoundrc` to edit in this way for bluetooth headset:

`sudo nano .asoundrc`

Paste below cmmnds in `.asoundrc` with your Bluetooth mac address:

```
defaults.bluealsa.interface "hci0"
defaults.bluealsa.device "EB:06:EF:6A:D4:17"
defaults.bluealsa.profile "sco"
defaults.bluealsa.delay 10000
```

-------------------------------------------------------------------------------------OR------------------------------------------------------------------------------------------

```
pcm.!default {
type asym
capture.pcm "mic"
playback.pcm "speaker"
}
pcm.mic {
  type plug 
slave.pcm {
type bluealsa device "EB:06:EF:6A:D4:17"
profile "a2dp"
}
}
pcm.speaker {
type plug
slave.pcm {
type bluealsa device "EB:06:EF:6A:D4:17"
profile "a2dp"
}
}

ctl.!default {
type bluealsa
}
```
 
![Screenshot (1805)](https://user-images.githubusercontent.com/88953654/136802094-5b7ca687-8161-41b9-b975-223aaf2bf3ea.png)
 
 .asoundrc format:
 https://github-wiki-see.page/m/Arkq/bluez-alsa/wiki/Using-the-bluealsa-ALSA-pcm-plugin
 https://github.com/Arkq/bluez-alsa/wiki/Using-the-bluealsa-ALSA-pcm-plugin
 
 Check if your format for .asoundrc is correct:
 https://developers.google.com/assistant/sdk/guides/service/python/embed/audio
 
 Configure a Developer Project and Account Settings:
 https://developers.google.com/assistant/sdk/guides/service/python/embed/config-dev-project-and-account
 
![1](https://user-images.githubusercontent.com/88953654/137185002-e852f24d-f040-4b55-914d-0c7c441edc38.png)
![2](https://user-images.githubusercontent.com/88953654/137185011-6fa29484-d790-4c14-bd58-92894d000ae7.png)
![3](https://user-images.githubusercontent.com/88953654/137185069-735d15c1-d656-4f0e-a28e-319741493bbd.png)
![4](https://user-images.githubusercontent.com/88953654/137185075-a23af57d-8451-46f9-8b58-a41d6f08fb13.png)
![5](https://user-images.githubusercontent.com/88953654/137185086-649f2288-2e94-411e-a1b7-8538bb9d2fa2.png)
![6](https://user-images.githubusercontent.com/88953654/137185096-0f1b4c63-ff0f-4e74-afe9-b2b2f7f66171.png)
![7](https://user-images.githubusercontent.com/88953654/137185115-c3adbb79-0c8f-4b64-8e79-6b73cf85cb76.png)

 Next follow these steps:
 Register the Device Model:
 https://developers.google.com/assistant/sdk/guides/service/python/embed/register-device
 
 After registring Model Download OAuth 2.0 Credentials:
 ![8](https://user-images.githubusercontent.com/88953654/137186359-146c8508-eaf6-41f5-afeb-dc761bf1936d.png)

 Use this Cmd, to transfer json file from your sytem to Raspberry pi:
 
 `scp ~/Downloads/client_secret_`client-id`.json pi@`raspberry-pi-ip-address`:/home/pi/`
 
 Install the SDK and Sample Code:
 https://developers.google.com/assistant/sdk/guides/service/python/embed/install-sample
 
 If Error-400 Authorization error caused, Then:
 
 ![Screenshot (1861)](https://user-images.githubusercontent.com/88953654/137188777-d6507356-ae3d-4df3-b498-725c832396f0.png)
 
 Final test of Google Home implemented or not on Raspberry pi:
 
 ![Screenshot (1857)](https://user-images.githubusercontent.com/88953654/137190452-647908b8-9e2b-4b29-961d-b8d4a3cf4d02.png)
 
 
References:

https://peppe8o.com/fixed-connect-bluetooth-headphones-with-your-raspberry-pi/

http://youness.net/raspberry-pi/how-to-connect-bluetooth-headset-or-speaker-to-raspberry-pi-3

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



