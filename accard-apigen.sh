#!/bin/bash

# Ensure apigen is installed.
if [ ! type "apigen" > /dev/null ]; then

    echo "To run this command, you must first install apigen."
    echo "Visit: http://apigen.org/"
    exit 1

fi

rm -r .api/*
apigen generate --title "Accard API Documentation" --source src --destination .api --exclude "*/Tests/*" --template-theme "bootstrap" --deprecated --download --todo
