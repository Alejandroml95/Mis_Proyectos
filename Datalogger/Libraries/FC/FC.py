import RPi.GPIO as GPIO    #import GPIO (Raspberry Pi)
import time                
from time import gmtime, strftime  

import pymysql.cursors #Connect Python with Mysql

#This object defind a limit sensor connect to raspberry pi.
#It set up is:
#Pin: Pin to which the sensor is connected
#NameFile: In the file with name "NameFile" is written the data of sensor in format "CSV"
#NameTable: Name of table of a data base where it will write the data of sensor 

class FC(object): 
    """docstring for FC."""
    def __init__(self, Pin, NameFile, NameTable):
        super(FC, self).__init__()

        #Define Pin of the raspberry pi and it set up
        self.__Pin = Pin 
        GPIO.setup(self.__Pin, GPIO.IN, GPIO.PUD_UP)

        self.__NameFile = NameFile

        #Variables of rising flank and falling flank
        self.__State = 0
        self.__PreviousState = 0
        self.__time = 0
        
        self.__SensorData = ""
        
        self.__table = NameTable

        #This String keep the data and it insert a row in the data base.
        self.__Data ={ "FechaApertura": "", "HorarioApertura": "", "FechaCierre" : "", "HorarioCierre": "", "TiempoApertura": "" }

    def FlankRise(self):

        self.__State = GPIO.input( self.__Pin ) #Read the limit switch

        if self.__State == 1 and self.__PreviousState == 0:

            return 1

        else:

            return 0


    def FlankDecent(self):

        self.__State = GPIO.input( self.__Pin ) #Read the limit switch

        if self.__State == 0 and self.__PreviousState == 1:

            return 1

        else:

            return 0

    def UpdateStatus(self):

        self.__PreviousState = self.__State

    #Returns the name of the sensor data file
    def NameFile(self):

        return self.__NameFile


    def DataString(self):

        #This String keep the data and it insert a row in the data base.
        SensorData = ""

        Date = strftime("%d-%m-%Y", gmtime())
        Time = strftime("%H:%M:%S", gmtime())

        if self.FlankRise():

            self.__time = time.time()

            self.__SensorData = Date + ";" + Time + ";"

        if self.FlankDecent():

            TimeOFF = time.time()

            Duration = TimeOFF - self.__time
            
            Duration = round( Duration , 2 )
            
            Duration = str (Duration)

            self.__SensorData = self.__SensorData + Date + ";" + Time + ";" + Duration + "\n"


    def getDataString(self):

        return self.__SensorData

    def clearStringData(self):

        self.__SensorData = ""

    #This funtion keep the data sensor in a list
    def DataDB(self):: __Data

        Date = strftime("%Y-%m-%d", gmtime())
        Time = strftime("%H:%M:%S", gmtime())

        if self.FlankRise():

            self.__time = time.time()

            self.__Data["FechaApertura"] = Date
            self.__Data["HorarioApertura"] = Time

        if self.FlankDecent():

            TimeOFF = time.time()

            Duration = TimeOFF - self.__time

            self.__Data["FechaCierre"] = Date
            self.__Data["HorarioCierre"] = Time
            self.__Data["TiempoApertura"] = Duration

    #This funtion insert a row in a data base. The variables set up the data base.
    def InsertDataDB(self, localhost, user, password, namedb):
    
        DB = pymysql.connect(host= localhost,
                    user= user,
                    password= password,
                    db= namedb,
                    charset='utf8mb4',
                    cursorclass = pymysql.cursors.DictCursor)
                
        try:

            with DB.cursor() as cursor:

                        sql = "INSERT INTO " + self.__table + "(`FechaApertura`, `HorarioApertura`, `FechaCierre`, `HorarioCierre`, `TiempoApertura`) VALUES (%s, %s, %s, %s, %s)"

                        cursor.execute(sql, (self.__Data["FechaApertura"], self.__Data["HorarioApertura"], self.__Data["FechaCierre"], self.__Data["HorarioCierre"], self.__Data["TiempoApertura"] ))

                        DB.commit()

        finally:

            DB.close()


