#!/usr/bin/env bash
BASEDIR=$(dirname "$0")
php=`type -P php`
$php -f "routeLoaderGenerator.php"

LCYAN='\033[1;36m'
NC='\033[0m'

echo -e "${LCYAN}route autoloader generated${NC}";