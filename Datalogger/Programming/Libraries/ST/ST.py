import MyPyDHT #Library of sensor DHT22 and DHT11
import RPi.GPIO as GPIO  #Import the GPIO (Raspberry pi)
GPIO.setwarnings(False)

import time                
from time import gmtime, strftime  

from datetime import datetime

import pymysql.cursors #Connect Python with Mysql

#This object defind a DHT22 sensor connect to raspberry pi.
#It set up is:
#Pin: Pin to which the sensor is connected
#NameFile: In the file with name "NameFile" is written the data of sensor in format "CSV"
#NameTable: Name of table of a data base where it will write the data of sensor 

class ST(object): 
    """docstring for FC."""
    def __init__(self, Pin, NameFile, NameTable):
        super(ST, self).__init__()

        #Definir el Pin y se configura Defind the pin of the raspberry pi and it set up
        self.__Pin = Pin
        GPIO.setup(self.__Pin, GPIO.IN, GPIO.PUD_UP)

        self.__CurrentTime = 0
        self.__Time = time.time()

        self.__TimeSample = 0

        #Variables keep the data for Csv file and data base
        self.__NameFile = NameFile
        self.__NameTable = NameTable
       
        

        #String keep the data for data base
        self.__Data ={ "Date": "", "Schedule": "", "Temperature": "", "Humidity": "" }

        #These variables specify the operating hours of the sensor
        self.__Time1 = datetime.strptime("00:00:00", "%X").time()
        self.__Time2 = datetime.strptime("00:00:00", "%X").time()

    #This funtion update the operating hours of the sensor
    def UpdateWorkTime(self, Time1, Time2):
        
        self.__Time1 = datetime.strptime(Time1, "%X").time() #%X formato de hora local
        self.__Time2 = datetime.strptime(Time2, "%X").time()

    #Return 1 if current time is within working hours
    def WorkTime():
        
        Current_Time = datetime.now().time()

        if self.__Time2 > self.__Time1:

                    if Current_Time > self.__Time1 and Current_Time < self.__Time2:
                        
                        print("Hora de Funcionamiento")
                        return 1

                    else:

                        print("Hora fuera de Funcionamiento")
                        return 0

    #This funtion return 1 when the timer ends. Value the timer is "__TimeSample"
    def TimerSample(self):
        
        self.__CurrentTime = time.time()

        if ( self.__CurrentTime - self.__Time) >= self.__TimeSample:

            self.__Time = self.__CurrentTime

            return 1

        else:

            return 0


    def readSensor(self, Sample):
            
        self.__Data["Humidity"], self.__Data["Temperature"] = MyPyDHT.sensor_read(MyPyDHT.Sensor.DHT22, self.__Pin, Sample, 1)


    #Return the string with data sensor
    def DataString(self):

        Date = strftime("%d-%m-%Y", gmtime())
        Time = strftime("%H:%M:%S", gmtime())

        SensorData = ""
        SensorData = Date + ";" + Time + ";" + self.__Data["Temperature"] + ";" + self.__Data["Humidity"] + "\n"

        return SensorData


    #Insert a row with data sensor in a data base.
    def InsertDataDB(self, localhost, user, password, namedb):
    
        self.__Data["Date"] = strftime("%Y-%m-%d", gmtime())
        self.__Data["Schedule"] = strftime("%H:%M:%S", gmtime())
    
    
        DB = pymysql.connect(host= localhost,
                    user= user,
                    password= password,
                    db= namedb,
                    charset='utf8mb4',
                    cursorclass = pymysql.cursors.DictCursor)
                
        try:
    
            with DB.cursor() as cursor:
    
                sql = "INSERT INTO " + self.__NameTable + "(`Fecha`, `Horario`, `Temperatura`, `Humedad`) VALUES (%s, %s, %s, %s)"
    
                cursor.execute(sql, (self.__Data["Date"], self.__Data["Schedule"], self.__Data["Temperature"], self.__Data["Humidity"] ))
    
                DB.commit()
    
        finally:
    
            DB.close()


