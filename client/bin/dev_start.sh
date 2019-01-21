#!/bin/bash
npm install
export API_IP=$(getent hosts api | awk '{ print $1 }')
sed -i "s@api_base:.*@api_base: 'http://${API_IP}'@g" src/environments/environment.ts
ng serve --host 0.0.0.0