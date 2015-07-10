CHANGELOG for 1.0.x
===================

This changelog references the relevant changes (bugs and security fixes) done in 1.0 minor versions.

To get the diff for a specific change, go to https://gitlab.med.upenn.edu/prototype/PatientRepository/commit/XXX where XXX is the change hash. To get the diff between two versions, go to https://gitlab.med.upenn.edu/prototype/PatientRepository/compare/1.0.0...1.0.1

* 1.0.0-beta1 (Initial release 07/01/2015)
    - No changes recorded, initial release.
* 1.0.0-beta2
    - [OutcomesBundle]
        - Minor adjustments made to support loading outcomes inside UIBundle.
    - [ResourceBundle]
        - Expression language dates are now cloned prior to use, this avoids overwriting dates.
    - [UIBundle]
        - Non HTML5 browsers now support common date picker in UI.
        - Dates now properly render on grid in Safari.
        - Integrated new credits page.
        - All npm dependencies updated, and all deprecations resolved.
        - Patient grid now infinitely scrollable.
        - Outcomes incorporated into UI, experimentally.
        - Left drawer auto-hides when a valid menu item is selected.
    - [Activity] Now fully unit tested, minor code inconsistencies found and fixed.
    - [Core] Now fully unit tested, minor code inconsistencies found and fixed.
    - [Patient] Now fully unit tested, minor code inconsistencies found and fixed.
    - [Resource] Now fuly unit tested, minor code inconsistencies found and fixed.
