#!/usr/bin/python
import serial
import time

arduino=serial.Serial('/dev/ttyUSB0',baudrate=9600, timeout = 3.0)
cadena=''
 
while True:
      var = raw_input("Introduzca  un Comando: ")
      arduino.write(var)
      time.sleep(0.1)
      while arduino.inWaiting() > 0:
            cadena += arduino.readline()
            print cadena.rstrip('\n')
            cadena = ''
arduino.close()