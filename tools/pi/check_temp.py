#!/usr/bin/python
import Adafruit_DHT

DHT_TYPE = Adafruit_DHT.AM2302
DHT_PIN  = 4

# Attempt to get sensor reading.
humidity, temp = Adafruit_DHT.read(DHT_TYPE, DHT_PIN)

if humidity is None and temp is None:
    print('Error reading temperature and humidity. Please try again')
elif humidity is None:
    print('Error reading humidity. Please try again')
elif temp is None:
    print('Error reading temperature. Please try again')
else:
    print('Temperature: {0:0.1f} C'.format(temp))
    print('Humidity:    {0:0.1f} %'.format(humidity))
