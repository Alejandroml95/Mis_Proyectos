from ST.ST import *

St1 = ST(17, "Sounding1.csv", "SoundingData")

#The list "List_ST" keep the object "ST"
List_ST = []

List_ST.append( St1 )

try:
    while True:

        for St in List_ST:

            St.UpdateWorkTime("07:00:00", "13:00:00")

            St.UpdateTimeSample()

            if St.WorkTime():
                
                if St.TimerSample():

                    St.readSensor( 20 )

                    #Write the data of sensor in the data base. The variables of function is data about data base
                    St.InsertDataDB("localhost", "doorctrl", "Brggroup27", "doorctrldb")

            
except KeyboardInterrupt:
    print ("quit")
    GPIO.cleanup()

