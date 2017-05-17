#!/usr/bin/python
import serial
import time
import mysql.connector

conn = mysql.connector.connect(
         user='techno',
         password='techno',
         host='localhost',
         database='ts5')

cur = conn.cursor()

query = ("SELECT * FROM usuarios WHERE idUsuarios=4 ")

cur.execute(query)

for (idUsuarios) in cur:
  print("{}".format(idUsuarios))

arduino=serial.Serial('/dev/ttyUSB0',baudrate=9600, timeout = 0.5)
cadena=''
 
while True:
      var = "P"
      arduino.write(var)
      
      while arduino.inWaiting() > 0:
            cadena += arduino.readline()
            print cadena
            cadena = ''
			
arduino.close()
cur.close()
conn.close()