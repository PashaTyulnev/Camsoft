/* This arduino code is sending data to mysql server every 30 seconds.
Created By Embedotronics Technologies*/

#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <ESP8266WebServer.h>
#include <ESP8266mDNS.h>
#include <SPI.h>
#include <MFRC522.h>
#include <ESP8266HTTPClient.h>
#include <string> 

#include "DHT.h"        // including the library of DHT11 temperature and humidity sensor
#define DHTTYPE DHT11   // DHT 11

#define dht_dpin 0
DHT dht(dht_dpin, DHTTYPE); 

float humidityData;
float temperatureData;
int earthHum;
int sensorID = 1; 
int interval = 600000; //15 min Interval
int location = 1; //1 - Dresden, 2 - Münster, 3 - Wolfsburg
int timeCounter = 0; 

const char* ssid = "Jupa 2,4";
const char* password = "YouCrazyCat5454"; 


//WiFiClient client;
String server = "91.204.46.193";   //eg: 192.168.0.222

int sense_Pin = 0; // аналоговый ввод A0 для приема информации с датчика

WiFiClient client;    


void setup()
{
   
   dht.begin();
   Serial.begin(9600);
 
  WiFi.begin(ssid, password);
 
  while (WiFi.status() != WL_CONNECTED) {
 
    
    Serial.print("Connecting..");
 
    delay(1000);
  }
 }
void loop()
{ 
    earthHum = analogRead(sense_Pin);
    humidityData = dht.readHumidity();
    temperatureData = dht.readTemperature();    
 
    sendOnStatus();

    if(timeCounter >= interval){
      Sending_To_phpmyadmindatabase() ;
       timeCounter = 0;
    }
    else{
      timeCounter = timeCounter + 1000;
    }
    delay(1000);
 }

 void Sending_To_phpmyadmindatabase()   //CONNECTING WITH MYSQL
 {
 if (WiFi.status() == WL_CONNECTED) { //Check WiFi connection status
 
    HTTPClient http;  //Declare an object of class HTTPClient

   
    http.begin("http://192.168.178.36/home/dht.php?humidity=" +String(humidityData)+ "&temperature=" +String(temperatureData)+ "&earthhum=" +String(earthHum)+"&cityID="+String(location)+"&sensorID="+sensorID);  //Specify request destination
    int httpCode = http.GET();                                  //Send the request
 
    if (httpCode > 0) { //Check the returning code
 
      String payload = http.getString();   //Get the request response payload
      Serial.println(payload);             //Print the response payload
 
    }
 
    http.end();   //Close connection
 
  }
 }

 void sendOnStatus()   //CONNECTING WITH MYSQL
 {
 if (WiFi.status() == WL_CONNECTED) { //Check WiFi connection status
 
    HTTPClient http;  //Declare an object of class HTTPClient

    
    http.begin("http://192.168.178.36/home/functions/updateOnline.php?sensorID="+String(sensorID)+"&cityID="+String(location));  //Specify request destination
    int httpCode = http.GET();//Send the request
    
    Serial.print(httpCode);
    Serial.print(httpCode);
    if (httpCode > 0) { //Check the returning code
      String payload = http.getString();   //Get the request response payload
    }
    http.end();   //Close connection
  }
 }
