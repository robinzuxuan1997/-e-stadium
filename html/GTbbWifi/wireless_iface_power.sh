#!/bin/sh
#!/bin/bash

echo "----------eStadium Wireless Interface Power On/Off--------------"

# Retrieve the status to power on/off the wireless interfaces from eStadium
wget "http://estadium.gatech.edu/GTbbWifi/GTbbWifiStatus.txt" -O ~/tmpwifiStatus.txt
status=$(awk '{print;}' ~/tmpwifiStatus.txt)

# Retrieve the number of currently used interfaces
numInterfaces=$(ifconfig | grep -ohc "^wlan[0-9]\|^mesh[0-9]")

currentStatus="down"
# If there are currently used wireless interfaces, then the status is up
if [ $numInterfaces -gt 0 ]; then
currentStatus="up"
fi;

# If there is a change in status, then proceed to make the power on/off the wireless interfaces.
if [ "$status" != "$currentStatus" ]; then

# Retrieve the currently used interfaces and store them.
# ONLY if bringing down AND ONLY if the interfaces are currently down
# If an interface is already down, the grep will not find it and create an empty file
# We need this record to bring back the correct interfaces
if [ "$status" = "down" ]; then
# If there are no current interfaces, then there is no need to store currently used interfaces
if [ $numInterfaces -gt 0 ]; then
echo "Creating record of active wlan and mesh interfaces"
ifconfig | grep -oh "^wlan[0-9]\|^mesh[0-9]" > ~/activeinterfaces.txt
fi; # end if numInterfaces > 0
fi; # end if status == down

# Power on/off each of the recorded active wireless interfaces. This ensures we do not
# lose any existing mesh/wlan interface configurations
# For example, if mesh0 is turned off and wlan0 is turned on at a later time, due to
# lack of remembering if wireless card 0 was configured as mesh or wlan, then it will
# go to wlan0 and lose the mesh0 configuration

while read interface; do
# Name of the current interface wlanX being powered on/off

# Turn on/off the wlan and mesh interfaces
echo "Turning $status $interface"
ifconfig $interface $status

done < ~/activeinterfaces.txt

else # This else is for if status == currentStatus
echo "No change in interface power. Remaining $status."
fi; # end if status == currentStatus

