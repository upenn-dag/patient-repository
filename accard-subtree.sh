#!/bin/bash

# Ensure git subsplit is installed.
if [ ! type "git subsplit" >/dev/null 2>&1 ]; then

    echo "To run this command, you must first install git subsplit."
    echo "Visit: https://github.com/dflydev/git-subsplit"
    exit 1

fi

COMPONENTS=false
BUNDLES=false
BRIDGES=false
FULL=false

# Parse incoming arguments
while [[ $# > 0 ]]
do
key="$1"
case $key in
    --components)
    COMPONENTS=true
    shift
    ;;
    --bundles)
    BUNDLES=true
    shift
    ;;
    --bridges)
    BRIDGES=true
    shift
    ;;
    --full)
    FULL=true
    shift
    ;;
esac
shift
done

echo $COMPONENTS
echo $BUNDLES
echo $BRIDGES

components=("Activity" "Attribute" "Behavior" "Core" "Diagnosis" "Drug" "Patient" "Phase" "Regimen" "Sample")
bundles=("ActivityBundle" "AttributeBundle" "BehaviorBundle" "CoreBundle" "CPDBundle" "DiagnosisBundle" "DrugBundle" "HMTBBundle" "OutcomesBundle" "PDSBundle" "PatientBundle" "PhaseBundle" "RegimenBundle" "SampleBundle" "TemplateBundle" "WebBundle")
bridges=("Twig")

# These are here so we can easily, and selectively split certain pieces without running the whole thing.

#components=()
#bundles=()
#bridges=()

git subsplit init git@gitlab.med.upenn.edu:prototype/PatientRepository.git
git subsplit update

if [ "$COMPONENTS" = true ]; then
    for component in "${components[@]}"
    do
        echo "Splitting ${component} component"
        git subsplit publish "src/Component/${component}:git@gitlab.med.upenn.edu:prototype/${component}.git" --heads="master 1.0"
    done
fi

if [ "$BUNDLES" = true ]; then
    for bundle in "${bundles[@]}"
    do
        echo "Splitting ${bundle} bundle"
        git subsplit publish "src/Bundle/${bundle}:git@gitlab.med.upenn.edu:prototype/${bundle}.git" --heads="master 1.0"
    done
fi

if [ "$BRIDGES" = true ]; then
    for bridge in "${bridges[@]}"
    do
        echo "Splitting ${bridge}"
        git subsplit publish "src/Bridge/${bridge}:git@gitlab.med.upenn.edu:prototype/${bridge}.git" --heads="master 1.0"
    done
fi
