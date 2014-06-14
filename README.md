## Developer Task || TimezoneConverter
=================


Please follow the instructions below and send us your code once you’ve finished.

We want to see how you structure the code in files, classes and methods; how you solve the problem and how you present the code to us and the user within a browser or on the command line.

Write a PHP program that generates an XML file containing every 30th of June since 

the Unix Epoch, at 1pm GMT, similar to the one attached.

```xml
<?xml version="1.0" encoding="UTF-8"?>
<timestamps>
    <timestamp time="1246406400" text="2009-06-30 13:00:00" />
</timestamps>
```
The program must also be able to parse XML in that format and generate a second 

XML file sorted by timestamp in descending order, excluding years that are prime 

numbers. The timestamps generated should be at 1pm PST.

We must be able to run these steps separately.

Remember, you need to solve the problem but also show us your knowledge of 

professional PHP coding and OOP. The code must be written to production standard 

– the kind of thing you’d expect from anyone you work with. And it has to run first 

time.





### USAGE



FILENAME: **GMT.xml**

TIMEZONE: **GMT (optional, default GMT)**

EXCLUDE_PRIME_YEARS: **false  (optional, default true)**
```bash
    php console xml:create GMT.xml GMT false
```

FILENAME: **GMT.xml**

TIMEZONE: **PST**

EXCLUDE_PRIME_YEARS: **false (optional, default true)**
```bash
    php console xml:convert GMT.xml PST true
```


For UnitTests just run:
```bash
    phpunit
```
