-- Grant all privileges to appuser for iec_platform database
GRANT ALL PRIVILEGES ON iec_platform.* TO 'appuser'@'%' IDENTIFIED BY 'secret123';
GRANT ALL PRIVILEGES ON iec_platform.* TO 'appuser'@'localhost' IDENTIFIED BY 'secret123';
FLUSH PRIVILEGES;
