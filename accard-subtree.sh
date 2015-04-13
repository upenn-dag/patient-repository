#!/bin/bash

function accard-subtree-executor {

    executor="\
        git subtree split --prefix=src/Component/${1} --branch=${1}-split && \
        git checkout ${1}-split && \
        git filter-branch --tag-name-filter cat --prune-empty HEAD && \
        git remote add -f ${1} git@gitlab.med.upenn.edu:prototype/${1}.git && \
        git push ${1} ${1}-split:master && \
        git remote rm ${1} && \
        git checkout develop && \
        git branch -D ${1}-split"

    echo "  Starting subtree split of $1"

    if eval "$executor"; then
        echo "  Success!"
    else
        echo "  Failure!"
    fi
}

function accard-subtree-marker {
    exit 1
}

function accard-subtree {

    ## Define all entities on which we work.
    components=("Activity") # "Attribute" "Behavior" "Core" "Diagnosis" "Drug" "Field" "Option" "Patient" "Phase" "Prototype" "Regimen" "Resource" "Sample")
    bundles=() #("ActivityBundle" "AttributeBundle" "BehaviorBundle" "CPDBundle" "CoreBundle" "DiagnosisBundle" "DrugBundle" "FieldBundle" "HMTBBundle" "OptionBundle" "OutcomesBundle" "PDSBundle" "PatientBundle" "PhaseBundle" "PrototypeBundle" "RegimenBundle" "ResourceBundle" "SampleBundle" "SettingsBundle" "TemplateBundle" "WebBundle")
    bridges=() #("Twig")

    ## Let's do the components first
    echo "Starting subtree split of components"
    for component in "${components[@]}"
    do
        accard-subtree-executor $component
        sleep 1 # Added for coherence of output
    done

    ## Next the bundles
    echo "Starting subtree split of bundles"
    for bundle in "${bundles[@]}"
    do
        accard-subtree-executor $bundle
        sleep 1 # Added for coherence of output
    done

    ## Finally the bridges
    echo "Starting subtree split of bridges"
    for bridge in "${bridges[@]}"
    do
        accard-subtree-executor $bundle
        sleep 1 # Added for coherence of output
    done
}
