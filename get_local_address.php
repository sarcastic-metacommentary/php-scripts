<?php

// Get LAN IP address of the hosting server
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $ipconfig = shell_exec("ipconfig");
} else {
        $ip = shell_exec("/sbin/ifconfig  | grep 'inet '| grep -v '127.0.0.1' | cut -d: -f2 | awk '{ print $1}'");
}

// prepend address to protocol and app name
$appname = "moodle";
$url = "http://$ip/$appname";

echo "Application address: <a href='$url'>$url</a>";
