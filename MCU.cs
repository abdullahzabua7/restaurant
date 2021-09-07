#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <Arduino_JSON.h>

#include <ESP8266WiFiMulti.h>
ESP8266WiFiMulti WiFiMulti;

const char* ssid = "M J GTPL";
const char* password = "mustafa@gtpl";


// Your IP address or domain name with URL path
const char* serverName1 = "http://192.168.0.105/Two_way_led_control/convert_json.php?action=outputs_state";
const char* serverName2 = "http://192.168.0.105/Two_way_led_control/convert_json.php?action=btn_web";
// Update interval time set to 5 seconds
const long interval = 5000;
unsigned long previousMillis = 0;
#define button D6
int btn_st = 0;
int read_btn = 0;

String outputsState;

void setup() {
  Serial.begin(115200);
  pinMode(button, INPUT);
  WiFi.mode(WIFI_STA);
  Serial.print("Connecting to ");
  Serial.println(ssid);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("Connected to WiFi");
}

void loop() {

  // Check WiFi connection status
  if ((WiFiMulti.run() == WL_CONNECTED)) {
    read_btn =  digitalRead(button);
    Serial.print("read_btn: ");
    Serial.println(read_btn);
    if (read_btn == 1)
    {
      btn_st = !btn_st;
    httpSENDrequest( serverName2,  btn_st);
    }
    Serial.print("button state: ");
    Serial.println(btn_st);
    outputsState = httpGETRequest(serverName1);
    Serial.println(" output state");
    Serial.println(outputsState);
    JSONVar myObject = JSON.parse(outputsState);
    // JSON.typeof(jsonVar) can be used to get the type of the var
    if (JSON.typeof(myObject) == "undefined") {
      Serial.println("Parsing input failed!");
      return ;
    }
    Serial.print("JSON object = ");
    Serial.println(myObject);
    myObject.keys(); //can be used to get an array of all the keys in the object
    JSONVar keys = myObject.keys();

    for (int i = 0; i < keys.length(); i++) {
      JSONVar value = myObject[keys[i]];
      int st = myObject[keys[i]];
      if (atoi(value) == 1) {
        btn_st = 1;
      }
      else
        btn_st = 0;
      Serial.print("GPIO: ");
      Serial.print(keys[i]);
      Serial.print(" - SET to: ");
      Serial.println(value);
      pinMode(atoi(keys[i]), OUTPUT);
      digitalWrite(atoi(keys[i]), atoi(value));
    }
  }
  else {
    Serial.println("WiFi Disconnected");
  }
  delay(1000);
}
void httpSENDrequest(const char* serverName2, int btn_st){
   WiFiClient client;
      HTTPClient http;


      // Specify content-type header
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");
      String httpRequestData = "&state=" + String(btn_st) + "";
      Serial.print("httpRequestData is: ");
      Serial.println(serverName2 + httpRequestData);
      http.begin(client, serverName2 + httpRequestData);
      int httpResponseCode = http.GET();
      if (httpResponseCode > 0) {
        Serial.print("HTTP Response code: ");
        Serial.println(httpResponseCode);
      }
      else {
        Serial.print("Error code: ");
        Serial.println(httpResponseCode);
      }
      // Free resources
      http.end();
}
String httpGETRequest(const char* serverName1) {
  WiFiClient client;
  HTTPClient http;

  // Your IP address with path or Domain name with URL path
  http.begin(client, serverName1);

  // Send HTTP POST request
  int httpResponseCode = http.GET();

  String payload = "{}";

  if (httpResponseCode > 0) {
    Serial.print("HTTP Response code: ");
    Serial.println(httpResponseCode);
    payload = http.getString();
    Serial.println("payload is");
    Serial.println(payload);
  }
  else {
    Serial.print("Error code: ");
    Serial.println(httpResponseCode);
  }
  // Free resources
  http.end();

  return payload;
}