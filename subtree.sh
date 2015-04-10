# ACCARD COMPONENT SUBTREE SPLITS
# =============================================================================
#
# Activity
# Attribute
# Behavior
# Core
# Diagnosis
# Drug
# Field
# Option
# Patient
# Phase
# Prototype
# Regimen
# Resource
# Sample
#

git subtree split --prefix=src/Component/Activity --branch=Activity-split
git checkout Activity-split
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f Activity git@gitlab.med.upenn.edu:prototype/Activity.git
git push Activity Activity-split:master
git remote rm Activity
git checkout develop
git branch -D Activity-split
sleep 1

git subtree split --prefix=src/Component/Attribute --branch=Attribute-split
git checkout Attribute-split
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f Attribute git@gitlab.med.upenn.edu:prototype/Attribute.git
git push Attribute Attribute-split:master
git remote rm Attribute
git checkout develop
git branch -D Attribute-split
sleep 1

git subtree split --prefix=src/Component/Behavior --branch=Behavior-split
git checkout Behavior-split
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f Behavior git@gitlab.med.upenn.edu:prototype/Behavior.git
git push Behavior Behavior-split:master
git remote rm Behavior
git checkout develop
git branch -D Behavior-split
sleep 1

git subtree split --prefix=src/Component/Core --branch=Core-split
git checkout Core-split
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f Core git@gitlab.med.upenn.edu:prototype/Core.git
git push Core Core-split:master
git remote rm Core
git checkout develop
git branch -D Core-split
sleep 1

git subtree split --prefix=src/Component/Diagnosis --branch=Diagnosis-split
git checkout Diagnosis-split
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f Diagnosis git@gitlab.med.upenn.edu:prototype/Diagnosis.git
git push Diagnosis Diagnosis-split:master
git remote rm Diagnosis
git checkout develop
git branch -D Diagnosis-split
sleep 1

git subtree split --prefix=src/Component/Drug --branch=Drug-split
git checkout Drug-split
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f Drug git@gitlab.med.upenn.edu:prototype/Drug.git
git push Drug Drug-split:master
git remote rm Drug
git checkout develop
git branch -D Drug-split
sleep 1

git subtree split --prefix=src/Component/Field --branch=Field-split
git checkout Field-split
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f Field git@gitlab.med.upenn.edu:prototype/Field.git
git push Field Field-split:master
git remote rm Field
git checkout develop
git branch -D Field-split
sleep 1

git subtree split --prefix=src/Component/Option --branch=Option-split
git checkout Option-split
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f Option git@gitlab.med.upenn.edu:prototype/Option.git
git push Option Option-split:master
git remote rm Option
git checkout develop
git branch -D Option-split
sleep 1

git subtree split --prefix=src/Component/Patient --branch=Patient-split
git checkout Patient-split
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f Patient git@gitlab.med.upenn.edu:prototype/Patient.git
git push Patient Patient-split:master
git remote rm Patient
git checkout develop
git branch -D Patient-split
sleep 1

git subtree split --prefix=src/Component/Phase --branch=Phase-split
git checkout Phase-split
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f Phase git@gitlab.med.upenn.edu:prototype/Phase.git
git push Phase Phase-split:master
git remote rm Phase
git checkout develop
git branch -D Phase-split
sleep 1

git subtree split --prefix=src/Component/Prototype --branch=Prototype-split
git checkout Prototype-split
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f Prototype git@gitlab.med.upenn.edu:prototype/Prototype.git
git push Prototype Prototype-split:master
git remote rm Prototype
git checkout develop
git branch -D Prototype-split
sleep 1

git subtree split --prefix=src/Component/Regimen --branch=Regimen-split
git checkout Regimen-split
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f Regimen git@gitlab.med.upenn.edu:prototype/Regimen.git
git push Regimen Regimen-split:master
git remote rm Regimen
git checkout develop
git branch -D Regimen-split
sleep 1

git subtree split --prefix=src/Component/Resource --branch=Resource-split
git checkout Resource-split
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f Resource git@gitlab.med.upenn.edu:prototype/Resource.git
git push Resource Resource-split:master
git remote rm Resource
git checkout develop
git branch -D Resource-split
sleep 1

git subtree split --prefix=src/Component/Sample --branch=Sample-split
git checkout Sample-split
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f Sample git@gitlab.med.upenn.edu:prototype/Sample.git
git push Sample Sample-split:master
git remote rm Sample
git checkout develop
git branch -D Sample-split
sleep 1



# ACCARD BUNDLE SUBTREE SPLITS
# =============================================================================
#
# ActivityBundle
# AttributeBundle
# BehaviorBundle
# CPDBundle
# CoreBundle
# DiagnosisBundle
# DrugBundle
# FieldBundle
# HMTBBundle
# OptionBundle
# OutcomesBundle
# PDSBundle
# PatientBundle
# PhaseBundle
# PrototypeBundle
# RegimenBundle
# ResourceBundle
# SampleBundle
# SettingsBundle
# TemplateBundle
# WebBundle
#


git subtree split --prefix=src/Bundle/ActivityBundle --branch=ActivityBundle
git checkout ActivityBundle
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f ActivityBundle git@gitlab.med.upenn.edu:prototype/ActivityBundle.git
git push ActivityBundle ActivityBundle:master
git remote rm ActivityBundle
git checkout develop
git branch -D ActivityBundle
sleep 1

git subtree split --prefix=src/Bundle/AttributeBundle --branch=AttributeBundle
git checkout AttributeBundle
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f AttributeBundle git@gitlab.med.upenn.edu:prototype/AttributeBundle.git
git push AttributeBundle AttributeBundle:master
git remote rm AttributeBundle
git checkout develop
git branch -D AttributeBundle
sleep 1

git subtree split --prefix=src/Bundle/BehaviorBundle --branch=BehaviorBundle
git checkout BehaviorBundle
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f BehaviorBundle git@gitlab.med.upenn.edu:prototype/BehaviorBundle.git
git push BehaviorBundle BehaviorBundle:master
git remote rm BehaviorBundle
git checkout develop
git branch -D BehaviorBundle
sleep 1

git subtree split --prefix=src/Bundle/CPDBundle --branch=CPDBundle
git checkout CPDBundle
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f CPDBundle git@gitlab.med.upenn.edu:prototype/CPDBundle.git
git push CPDBundle CPDBundle:master
git remote rm CPDBundle
git checkout develop
git branch -D CPDBundle
sleep 1

git subtree split --prefix=src/Bundle/CoreBundle --branch=CoreBundle
git checkout CoreBundle
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f CoreBundle git@gitlab.med.upenn.edu:prototype/CoreBundle.git
git push CoreBundle CoreBundle:master
git remote rm CoreBundle
git checkout develop
git branch -D CoreBundle
sleep 1

git subtree split --prefix=src/Bundle/DiagnosisBundle --branch=DiagnosisBundle
git checkout DiagnosisBundle
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f DiagnosisBundle git@gitlab.med.upenn.edu:prototype/DiagnosisBundle.git
git push DiagnosisBundle DiagnosisBundle:master
git remote rm DiagnosisBundle
git checkout develop
git branch -D DiagnosisBundle
sleep 1

git subtree split --prefix=src/Bundle/DrugBundle --branch=DrugBundle
git checkout DrugBundle
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f DrugBundle git@gitlab.med.upenn.edu:prototype/DrugBundle.git
git push DrugBundle DrugBundle:master
git remote rm DrugBundle
git checkout develop
git branch -D DrugBundle
sleep 1

git subtree split --prefix=src/Bundle/FieldBundle --branch=FieldBundle
git checkout FieldBundle
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f FieldBundle git@gitlab.med.upenn.edu:prototype/FieldBundle.git
git push FieldBundle FieldBundle:master
git remote rm FieldBundle
git checkout develop
git branch -D FieldBundle
sleep 1

git subtree split --prefix=src/Bundle/HMTBBundle --branch=HMTBBundle
git checkout HMTBBundle
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f HMTBBundle git@gitlab.med.upenn.edu:prototype/HMTBBundle.git
git push HMTBBundle HMTBBundle:master
git remote rm HMTBBundle
git checkout develop
git branch -D HMTBBundle
sleep 1

git subtree split --prefix=src/Bundle/OptionBundle --branch=OptionBundle
git checkout OptionBundle
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f OptionBundle git@gitlab.med.upenn.edu:prototype/OptionBundle.git
git push OptionBundle OptionBundle:master
git remote rm OptionBundle
git checkout develop
git branch -D OptionBundle
sleep 1

git subtree split --prefix=src/Bundle/OutcomesBundle --branch=OutcomesBundle
git checkout OutcomesBundle
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f OutcomesBundle git@gitlab.med.upenn.edu:prototype/OutcomesBundle.git
git push OutcomesBundle OutcomesBundle:master
git remote rm OutcomesBundle
git checkout develop
git branch -D OutcomesBundle
sleep 1

git subtree split --prefix=src/Bundle/PDSBundle --branch=PDSBundle
git checkout PDSBundle
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f PDSBundle git@gitlab.med.upenn.edu:prototype/PDSBundle.git
git push PDSBundle PDSBundle:master
git remote rm PDSBundle
git checkout develop
git branch -D PDSBundle
sleep 1

git subtree split --prefix=src/Bundle/PatientBundle --branch=PatientBundle
git checkout PatientBundle
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f PatientBundle git@gitlab.med.upenn.edu:prototype/PatientBundle.git
git push PatientBundle PatientBundle:master
git remote rm PatientBundle
git checkout develop
git branch -D PatientBundle
sleep 1

git subtree split --prefix=src/Bundle/PhaseBundle --branch=PhaseBundle
git checkout PhaseBundle
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f PhaseBundle git@gitlab.med.upenn.edu:prototype/PhaseBundle.git
git push PhaseBundle PhaseBundle:master
git remote rm PhaseBundle
git checkout develop
git branch -D PhaseBundle
sleep 1

git subtree split --prefix=src/Bundle/PrototypeBundle --branch=PrototypeBundle
git checkout PrototypeBundle
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f PrototypeBundle git@gitlab.med.upenn.edu:prototype/PrototypeBundle.git
git push PrototypeBundle PrototypeBundle:master
git remote rm PrototypeBundle
git checkout develop
git branch -D PrototypeBundle
sleep 1

git subtree split --prefix=src/Bundle/RegimenBundle --branch=RegimenBundle
git checkout RegimenBundle
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f RegimenBundle git@gitlab.med.upenn.edu:prototype/RegimenBundle.git
git push RegimenBundle RegimenBundle:master
git remote rm RegimenBundle
git checkout develop
git branch -D RegimenBundle
sleep 1

git subtree split --prefix=src/Bundle/ResourceBundle --branch=ResourceBundle
git checkout ResourceBundle
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f ResourceBundle git@gitlab.med.upenn.edu:prototype/ResourceBundle.git
git push ResourceBundle ResourceBundle:master
git remote rm ResourceBundle
git checkout develop
git branch -D ResourceBundle
sleep 1

git subtree split --prefix=src/Bundle/SampleBundle --branch=SampleBundle
git checkout SampleBundle
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f SampleBundle git@gitlab.med.upenn.edu:prototype/SampleBundle.git
git push SampleBundle SampleBundle:master
git remote rm SampleBundle
git checkout develop
git branch -D SampleBundle
sleep 1

git subtree split --prefix=src/Bundle/SettingsBundle --branch=SettingsBundle
git checkout SettingsBundle
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f SettingsBundle git@gitlab.med.upenn.edu:prototype/SettingsBundle.git
git push SettingsBundle SettingsBundle:master
git remote rm SettingsBundle
git checkout develop
git branch -D SettingsBundle
sleep 1

git subtree split --prefix=src/Bundle/TemplateBundle --branch=TemplateBundle
git checkout TemplateBundle
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f TemplateBundle git@gitlab.med.upenn.edu:prototype/TemplateBundle.git
git push TemplateBundle TemplateBundle:master
git remote rm TemplateBundle
git checkout develop
git branch -D TemplateBundle
sleep 1

git subtree split --prefix=src/Bundle/WebBundle --branch=WebBundle
git checkout WebBundle
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f WebBundle git@gitlab.med.upenn.edu:prototype/WebBundle.git
git push WebBundle WebBundle:master
git remote rm WebBundle
git checkout develop
git branch -D WebBundle
sleep 1


# ACCARD BRIDGE SUBTREE SPLITS
# =============================================================================
#
# Twig
#

git subtree split --prefix=src/Bridge/Twig --branch=TwigBridge
git checkout TwigBridge
git filter-branch --tag-name-filter cat --prune-empty HEAD
git remote add -f TwigBridge git@gitlab.med.upenn.edu:prototype/TwigBridge.git
git push TwigBridge TwigBridge:master
git remote rm TwigBridge
git checkout develop
git branch -D TwigBridge
sleep 1

