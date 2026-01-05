#!/bin/bash

# Add custom config files to nagios.cfg if not already present
if ! grep -q "cfg_file=/opt/nagios/etc/objects/hosts.cfg" /opt/nagios/etc/nagios.cfg; then
    echo "" >> /opt/nagios/etc/nagios.cfg
    echo "# Custom configuration files for container monitoring" >> /opt/nagios/etc/nagios.cfg
    echo "cfg_file=/opt/nagios/etc/objects/hosts.cfg" >> /opt/nagios/etc/nagios.cfg
    echo "cfg_file=/opt/nagios/etc/objects/services.cfg" >> /opt/nagios/etc/nagios.cfg
    echo "cfg_file=/opt/nagios/etc/objects/custom-commands.cfg" >> /opt/nagios/etc/nagios.cfg
    echo "Custom config files added to nagios.cfg"
fi

# Start Nagios normally
exec /usr/local/bin/start_nagios
