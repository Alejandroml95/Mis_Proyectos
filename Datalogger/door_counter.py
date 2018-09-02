from FC.FC import *

#Configuramos los pines GPIO como BCM
GPIO.setmode(GPIO.BCM)
GPIO.setwarnings(False)
#Variables de los pines del sensor y Led
Led = 3
Fc1 = FC(2, "Door1.csv", "doordata")

Fc2 = FC(17, "Door2.csv", "doord2")

#Configuramos los pines de Entrada o de salida
#Incluimos la resistencia pull down -> conectar señal y tierra(Sensor)
GPIO.setup(Led, GPIO.OUT)

#La siguiente variable será una lista donde se añadirán todos los finales
#de carrera que se quieran evaluar.

Lista_FC = []

Lista_FC.append( Fc1 )

Lista_FC.append( Fc2 )

try:
    while True:

        for Fc in Lista_FC:

            Fc.DataDB() #Actualiza los datos para insertarla en la base de datos

            if Fc.FlankDecent():

                # El siguiente paso será escribir los datos en la base de Datos
                # Pasamos los datos de la base de datos, se conecta Inserta los datos y cierra conexion4
                Fc.InsertDataDB("localhost", "doorctrl", "Brggroup27", "doorctrldb")

            Fc.UpdateStatus()

            time.sleep(0.5)

except KeyboardInterrupt:
    print ("quit")
    GPIO.cleanup()
