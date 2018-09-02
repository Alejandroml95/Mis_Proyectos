from ST.ST import *

St1 = ST(17, "Sounding1.csv", "SoundingData")

#La siguiente variable será una lista donde se añadirán todos los finales
#de carrera que se quieran evaluar.

Lista_ST = []

Lista_ST.append( St1 )

try:
    while True:

        for St in Lista_ST:

            St.UpdateWorkTime("07:00:00", "13:00:00")

            St.UpdateTimeSample()

            if St.WorkTime():
                
                if St.TimerSample():

                    St.readSensor( 20 )

                    # El siguiente paso será escribir los datos en la base de Datos
                    # Pasamos los datos de la base de datos, se conecta Inserta los datos y cierra conexion4
                    St.InsertDataDB("localhost", "doorctrl", "Brggroup27", "doorctrldb")

            
except KeyboardInterrupt:
    print ("quit")
    GPIO.cleanup()

