#!/bin/bash
clear;
echo "####################################################################################################"
echo "# Generating the Doctrine files for a given entity, be carefull that the entities are CamelCased". #"
echo "####################################################################################################"
date

# Testing arguments
EXPECTED_ARGS=1
E_BADARGS=65
if [ $# -ne $EXPECTED_ARGS ]
then
    echo "Usage: ./`basename $0` MyEntity"
      exit $E_BADARGS
    fi

    php bin/console doctrine:mapping:import AppBundle --filter=$1
    php bin/console doctrine:generate:entities Radenviro\\AppBundle\\Entity\\$1
    echo "  --> Done!"
    date
