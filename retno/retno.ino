#include <SPI.h>
#include <MFRC522.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <Wire.h> // Include the Wire library for I2C communication
#include <LiquidCrystal_I2C.h> // Include the LiquidCrystal_I2C library
#include <ArduinoJson.h>

#define RST_PIN D4
#define SDA_PIN D3
#define BUZZER_PIN D8

MFRC522 mfrc522(SDA_PIN, RST_PIN);
bool printedUIDMessage = false;
bool rfidEnabled = true;  // Flag to control RFID function

const char* ssid = "KAFA";
const char* password = "21041003!";
const char* serverUrl = "http://192.168.1.11/puskesmas/public/";

LiquidCrystal_I2C lcd(0x27, 16, 2);  // Set the LCD address to 0x27 for a 16x2 display

void setup() {
  Serial.begin(115200);
  SPI.begin();
  mfrc522.PCD_Init();
//  buzzer
  pinMode(BUZZER_PIN, OUTPUT);

//  lcd
  lcd.init();                      // Initialize the LCD
  lcd.backlight();                 // Turn on the backlight
  lcd.setCursor(0, 0);            // Set cursor to first column of first row
  lcd.print("Connecting to WiFi");

  // Connect to WiFi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("Connecting WiFi");
    Serial.println("Connecting to WiFi...");
  }
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Connected");
  Serial.println("Connected to WiFi");
}

void loop() {
  WiFiClient client;
  HTTPClient http;
  if (http.begin(client, String(serverUrl) + "control-scan")) {
    int httpResponseCode = http.GET();

    if (httpResponseCode == 200) {
      String payload = http.getString();
      if (payload == "1") {
        readRFID();  // Toggle RFID functionality when switch is pressed
        delay(1000);   // Debounce delay
      } else {
        antrianRFID();
        delay(1000); 
      }
    } else {
      lcd.clear();
      lcd.setCursor(0, 0);
      lcd.print("Error http");
      Serial.println("Error get HTTP request.");
      Serial.println(httpResponseCode);
      digitalWrite(BUZZER_PIN, HIGH);
      delay(1000);                    // Wait for 1 second
      digitalWrite(BUZZER_PIN, LOW);
      delay(1000); 
      digitalWrite(BUZZER_PIN, HIGH);
      delay(1000);
      digitalWrite(BUZZER_PIN, LOW);
      delay(1000); 
      digitalWrite(BUZZER_PIN, HIGH);
      delay(1000);
      digitalWrite(BUZZER_PIN, LOW);
    }

    http.end(); // Close the HTTP connection
  } else {
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("Failed connect");
    Serial.println("Failed to connect to server.");
  }

  // Check for other conditions or functions to run
}

void readRFID() {
  if (!printedUIDMessage) {
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("Daftar Kartu");
    Serial.println("Daftarkan Kartu");
    printedUIDMessage = true;
  }

  if (mfrc522.PICC_IsNewCardPresent() && mfrc522.PICC_ReadCardSerial()) {
    String tagUID = getTagUID();
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print(tagUID);
    Serial.println("Kartu :" + tagUID);
    WiFiClient client;
    HTTPClient http;
    if (http.begin(client, String(serverUrl) + "rfid-tag?tag=" + tagUID)) {
      int httpResponseCode = http.GET();

      if (httpResponseCode == 200) {
        lcd.clear();
        lcd.setCursor(0, 0);
        Serial.print("HTTP Response code: ");
        Serial.println(httpResponseCode);
        String payload = http.getString();
        if (payload.indexOf("error") != -1) {
             // Extract the error message
            DynamicJsonDocument doc(512);
            deserializeJson(doc, payload);
            String errorMessage = doc["error"];
            // Print the error message to the LCD display
            digitalWrite(BUZZER_PIN, HIGH);
            lcd.clear();
            lcd.setCursor(0, 0);
            lcd.print(errorMessage);
            delay(1000);                    // Wait for 1 second
            digitalWrite(BUZZER_PIN, LOW);
            delay(1000); 
            digitalWrite(BUZZER_PIN, HIGH);
            delay(1000);
            digitalWrite(BUZZER_PIN, LOW);
        } 
        if (payload.indexOf("success") != -1) {
           // Extract the error message
           DynamicJsonDocument doc(512);
           deserializeJson(doc, payload);
           String successMessage = doc["success"];
           digitalWrite(BUZZER_PIN, HIGH);
           delay(1000);                    // Wait for 1 second
           digitalWrite(BUZZER_PIN, LOW);
           lcd.clear();
           lcd.setCursor(0, 0);
           lcd.print("Terdaftar, "+successMessage);
           delay(5000);
         }
        
        Serial.println("Response: " + payload);
      } else {
        lcd.clear();
        lcd.setCursor(0, 0);
        lcd.print("Error sending");
        lcd.setCursor(0, 1);
        lcd.print(httpResponseCode);
        Serial.println("Error sending HTTP request.");
        Serial.println(httpResponseCode);
      }

      http.end(); // Close the HTTP connection
    } else {
      lcd.clear();
      lcd.setCursor(0, 0);
      lcd.print("Failed connect");
      Serial.println("Failed to connect to server.");
    }

    printedUIDMessage = false; // Reset the flag to print the message again
    delay(1000); // Wait before reading the next RFID tag
    mfrc522.PICC_HaltA(); // Halt the current tag
  }
}

void antrianRFID() {
  if (!printedUIDMessage) {
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("Tempelkan Kartu");
    Serial.println("Tempelkan Kartu");
    printedUIDMessage = true;
  }

  if (mfrc522.PICC_IsNewCardPresent() && mfrc522.PICC_ReadCardSerial()) {
    String tagUID = getTagUID();
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print(tagUID);
    Serial.println("Kartu :" + tagUID);

    WiFiClient client;
    HTTPClient http;
    if (http.begin(client, String(serverUrl) + "antrian-tag?tag=" + tagUID)) {
      int httpResponseCode = http.GET();

      if (httpResponseCode == 200) {
        Serial.print("HTTP Response code: ");
        Serial.println(httpResponseCode);
        String payload = http.getString();
        if (payload.indexOf("error") != -1) {
             // Extract the error message
            DynamicJsonDocument doc(512);
            deserializeJson(doc, payload);
            String errorMessage = doc["error"];
            // Print the error message to the LCD display
            digitalWrite(BUZZER_PIN, HIGH);
            lcd.clear();
            lcd.setCursor(0, 0);
            lcd.print(errorMessage);
            delay(1000);                    // Wait for 1 second
            digitalWrite(BUZZER_PIN, LOW);
            delay(1000); 
            digitalWrite(BUZZER_PIN, HIGH);
            delay(1000);
            digitalWrite(BUZZER_PIN, LOW);
        } 
        if (payload.indexOf("success") != -1) {
           // Extract the error message
           DynamicJsonDocument doc(512);
           deserializeJson(doc, payload);
           String successMessage = doc["success"];
           digitalWrite(BUZZER_PIN, HIGH);
           delay(1000);                    // Wait for 1 second
           digitalWrite(BUZZER_PIN, LOW);
           lcd.clear();
           lcd.setCursor(0, 0);
           lcd.print("Antrian: "+successMessage);
           delay(5000);
         }
        Serial.println("Response: " + payload);
      } else {
        lcd.clear();
        lcd.setCursor(0, 0);
        lcd.print("Error sending");
        lcd.setCursor(0, 1);
        lcd.print(httpResponseCode);
        Serial.println("Error sending HTTP request.");
        Serial.println(httpResponseCode);
      }

      http.end(); // Close the HTTP connection
    } else {
      lcd.clear();
      lcd.setCursor(0, 0);
      lcd.print("Failed connect");
      Serial.println("Failed to connect to server.");
    }

    printedUIDMessage = false; // Reset the flag to print the message again
    delay(1000); // Wait before reading the next RFID tag
    mfrc522.PICC_HaltA(); // Halt the current tag
  }
}

String getTagUID() {
  String tagUID = "";
  for (byte i = 0; i < mfrc522.uid.size; i++) {
    tagUID += (mfrc522.uid.uidByte[i] < 0x10 ? "0" : "");
    tagUID += String(mfrc522.uid.uidByte[i], HEX);
  }
  return tagUID;
}
