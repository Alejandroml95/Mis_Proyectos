from FC.FC import *

GPIO.setmode(GPIO.BCM)
GPIO.setwarnings(False)

#Set up Limit sensores and Led
Led = 3
Fc1 = FC(2, "Door1.csv", "doordata")

Fc2 = FC(17, "Door2.csv", "doord2")

#Set Up Output and input pins
GPIO.setup(Led, GPIO.OUT)

#The list "List_FC" keep all limit sensor that we create
List_FC = []

List_FC.append( Fc1 )

List_FC.append( Fc2 )

try:
    while True:

        for Fc in List_FC:

            Fc.DataDB() #Update the data of sensors

            if Fc.FlankDecent():

                #Write the data of sensor in the data base. The variables of function is data about data base
                Fc.InsertDataDB("localhost", "doorctrl", "Brggroup27", "doorctrldb")

            Fc.UpdateStatus()

            time.sleep(0.5)

except KeyboardInterrupt:
    print ("quit")
    GPIO.cleanup()
