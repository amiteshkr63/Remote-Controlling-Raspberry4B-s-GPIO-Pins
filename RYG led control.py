#RED=15
#YELLOW=16
#GREEN=18
import sys
import time
import RPi.GPIO as GPIO ## Import GPIO library
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BOARD) ## Use board pin numbering
GPIO.setup(15, GPIO.OUT) ## Setup GPIO Pin 15 to OUT
GPIO.setup(16, GPIO.OUT) ## Setup GPIO Pin 16 to OUT
GPIO.setup(18, GPIO.OUT) ## Setup GPIO Pin 18 to OUT
print(len(sys.argv))
        
status=sys.argv[2]

if(status=="ron"):
    GPIO.output(15,True)
if(status=="roff"):
    GPIO.output(15,False)

if(status=="yon"):
    GPIO.output(16,True)
if(status=="yoff"):
    GPIO.output(16,False)

if(status=="gon"):
    GPIO.output(18,True)
if(status=="goff"):
    GPIO.output(18,False)


