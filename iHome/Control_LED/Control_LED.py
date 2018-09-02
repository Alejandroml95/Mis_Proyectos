#!/usr/bin/env python3

#The object of this script is to control the Brightness 
#of the LEDs with a potentiometer

import time
from neopixel import *
import argparse

from gpiozero import MCP3008
from time import sleep


# LED strip configuration:
LED_COUNT      = 4      #Number of LED pixels.
LED_PIN        = 18      #GPIO pin connected to the pixels.
LED_FREQ_HZ    = 800000  #LED signal frequency in hertz (usually 800khz)
LED_DMA        = 10      #DMA channel to use for generating signal
LED_BRIGHTNESS = 255     #Set to 0 for darkest and 255 for brightest
LED_INVERT     = False   #True to invert the signal
LED_CHANNEL    = 0       #set to '1' for GPIOs 13, 19, 41, 45 or 53


#This funtion active the LEDs
#color: is a list with the values of the colors, RGB.
def color(strip, color, wait_ms=50):
    
    for i in range(strip.numPixels()):
        strip.setPixelColor(i, color)
        strip.show()
        time.sleep(wait_ms/1000.0)



if __name__ == '__main__':
    
    sensorPot  = MCP3008(0) #canal 0, potentiometer

    #Create NeoPixel object with appropriate configuration.
    strip = Adafruit_NeoPixel(LED_COUNT, LED_PIN, LED_FREQ_HZ, LED_DMA, LED_INVERT, LED_BRIGHTNESS, LED_CHANNEL)
    
    #Intialize the object strip.
    strip.begin()

    try:

        while True:

            #sensorPot.value: Return a value between 0 and 1. 
            #sensorPot.value * 255: Scale value and this value is between 0 and 255.
            ValueSensorPot  = sensorPot.value * 255 

            ValueSensorPot = round(ValueSensorPot, 2)

            #The Brightness is controled with value of potentiometer
            strip.setBrightness(ValueSensorPot);
            color(strip, Color(255, 255, 255)) 
            

    except KeyboardInterrupt:
        color(strip, Color(0,0,0), 10)
       
