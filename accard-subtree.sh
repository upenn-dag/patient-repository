#!/bin/bash

# Ensure git subsplit is installed.
if [ ! type "git subsplit" > /dev/null ]; then

    echo "To run this command, you must first install git subsplit."
    echo "Visit: https://github.com/dflydev/git-subsplit"
    exit 1

fi

components=("Activity" "Attribute" "Behavior" "Core" "Diagnosis" "Drug" "Field" "Option" "Patient" "Phase" "Prototype" "Regimen" "Resource" "Sample")
bundles=("ActivityBundle" "AttributeBundle" "BehaviorBundle" "CoreBundle" "CPDBundle" "DiagnosisBundle" "DrugBundle" "FieldBundle" "HMTBBundle" "OptionBundle" "OutcomesBundle" "PDSBundle" "PatientBundle" "PhaseBundle" "PrototypeBundle" "RegimenBundle" "ResourceBundle" "SampleBundle" "SettingsBundle" "TemplateBundle" "WebBundle")
bridges=("Twig")

# These are here so we can easily, and selectively split certain pieces without running the whole thing.

#components=()
#bundles=()
#bridges=()

git subsplit init git@gitlab.med.upenn.edu:prototype/PatientRepository.git
git subsplit update

for component in "${components[@]}"
do
    echo "Splitting ${component} component"
    git subsplit publish "src/Component/${component}:git@gitlab.med.upenn.edu:prototype/${component}.git" --heads="master develop"
    sleep 1 # Added for coherence of output
done

for bundle in "${bundles[@]}"
do
    echo "Splitting ${bundle} bundle"
    git subsplit publish "src/Bundle/${bundle}:git@gitlab.med.upenn.edu:prototype/${bundle}.git" --heads="master develop"
    sleep 1 # Added for coherence of output
done

for bridge in "${bridges[@]}"
do
    echo "Splitting ${bridge}"
    git subsplit publish "src/Bridge/${bridge}:git@gitlab.med.upenn.edu:prototype/${bridge}.git" --heads="master develop"
    sleep 1 # Added for coherence of output
done

## This is the listing of currently running splits.

#  Activity
#  Attribute
#  Behavior
#  Core
#  Diagnosis
#  Drug
#  Field
#  Option
#  Patient
#  Phase
#  Prototype
#  Regimen
#  Resource
#  Sample#  

#  ActivityBundle
#  AttributeBundle
#  BehaviorBundle
#  CPDBundle
#  CoreBundle
#  DiagnosisBundle
#  DrugBundle
#  FieldBundle
#  HMTBBundle
#  OptionBundle
#  OutcomesBundle
#  PDSBundle
#  PatientBundle
#  PhaseBundle
#  PrototypeBundle
#  RegimenBundle
#  ResourceBundle
#  SampleBundle
#  SettingsBundle
#  TemplateBundle
#  WebBundle#  

#  Twig