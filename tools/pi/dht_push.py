#!/usr/bin/python
import json
import sys
import time
import datetime
import requests

import Adafruit_DHT

# Type of sensor, can be:
# - Adafruit_DHT.DHT11
# - Adafruit_DHT.DHT22
# - Adafruit_DHT.AM2302
DHT_TYPE = Adafruit_DHT.AM2302

# What pin
# Raspberry pi EG: 23
# Beaglebone Black pin 'P8_11'
DHT_PIN  = 4

# How long to wait (in seconds) between measurements.
FREQUENCY_SECONDS      = 60
SENSOR_FAILURE_RETRY_SECONDS  = 2

# API to post information to
API_TOKEN      = 'voziv_dev_token'
POST_URI      = 'http://192.168.0.22/api/rooms/garage/record'

POST_HEADERS = {
    'Accept' : 'application/json',
    'Host' : 'house-api.test',
    'user-agent' : 'dht_push.py',
    'Authorization' : 'Bearer ' + API_TOKEN,
}

while True:
    # Attempt to get sensor reading.
    humidity, temp = Adafruit_DHT.read(DHT_TYPE, DHT_PIN)

    # Skip to the next reading if a valid measurement couldn't be taken.
    # This might happen if the CPU is under a lot of load and the sensor
    # can't be reliably read (timing is critical to read the sensor).
    if humidity is None or temp is None:
        time.sleep(SENSOR_FAILURE_RETRY_SECONDS)
        continue

    print('Temperature: {0:0.1f} C'.format(temp))
    print('Humidity:    {0:0.1f} %'.format(humidity))

    payload = {
     'temperature' : '{0:0.1f}'.format(temp),
     'humidity' : '{0:0.1f}'.format(humidity),
    }

    # Append the data in the spreadsheet, including a timestamp
    try:
        r = requests.post(POST_URI, headers=POST_HEADERS, json=payload)
        print('Wrote a reading to {0}. Responded with: {1}'.format(POST_URI, r.status_code))
        print(r.text)
    except:
        # Error appending data. Wait a bit and try again
        print('Error recording data to API')
        time.sleep(FREQUENCY_SECONDS)
        continue

    # Wait FREQUENCY_SECONDS seconds before continuing
    time.sleep(FREQUENCY_SECONDS)
