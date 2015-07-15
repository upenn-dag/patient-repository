CHANGELOG for 1.0.x
===================

This changelog references the relevant changes (bugs and security fixes) done in 1.0 minor versions.

To get the diff for a specific change, go to https://gitlab.med.upenn.edu/prototype/PatientRepository/commit/XXX where XXX is the change hash. To get the diff between two versions, go to https://gitlab.med.upenn.edu/prototype/PatientRepository/compare/1.0.0...1.0.1

* 1.0.0-beta1 (Initial release 07/01/2015)
    - No changes recorded, initial release.
* 1.0.0-beta2
    - [CoreBundle]
        + Symfony form type's invalid_message's have been overridden to provide more sensible defaults.
    - [FieldBundle]
        + Supports ordering additions from component.
    - [OptionBundle]
        + Supports ordering additions from component.
    - [OutcomesBundle]
        + Minor adjustments made to support loading outcomes inside UIBundle.
    - [ResourceBundle]
        + Expression language dates are now cloned prior to use, this avoids overwriting dates.
    - [UIBundle]
        + Non HTML5 browsers now support common date picker in UI.
        + Dates now properly render on grid in Safari.
        + Integrated new credits page.
        + All npm dependencies updated, and all deprecations resolved.
        + Patient grid now infinitely scrollable.
        + Outcomes incorporated into UI, experimentally.
        + Left drawer auto-hides when a valid menu item is selected.
        + Patient grid columns resized to better accommodate values.
        + Top-level alerts now only assume 90% of the overall width when displayed within a modal.
        + Filtering and create buttons are now distinctly separated on app patient show object sub-tables.
        + Patient and diagnosis phases once again support phase delete.
        + Behavior forms now show patient, just as all other object forms do.
        + Required form element labels now clearly marked with red asterisk.
        + Unnecessary tooltips removed from patient filtering inspector.
        + New default diagnosis partial template created.
        + Double clicking help message added to the bottom of the patient grid.
        + Patient filtering inspector date fields now have common placeholder values.
        + Create patient button added to grid subapplication.
        + New state.js state object handler introduced, more to come!
        + Subapplications now automatically refresh when the modal is closed; note, this feature is a temporary fix to a larger issue. Simple solution was used for brevity.
    - [WebBundle]
        + Bugfix in administration where there was a missing diagnosis code update view.
    - [Activity]
        + Now fully unit tested, minor code inconsistencies found and fixed.
    - [Core]
        + Now fully unit tested, minor code inconsistencies found and fixed.
    - [Field]
        + Now support new Option ordering feature. In addition, they provide override values to support A-Z, Z-A, Newest first and Oldest first as well as default ordering by provided value.
    - [Option]
        + Options are now orderable, and will be ordered according to the provided values wherever needed.
        + Convenience class OptionOrder added to simplify options used when ordering options.
    - [Patient]
        + Now fully unit tested, minor code inconsistencies found and fixed.
    - [Resource]
        + Now fuly unit tested, minor code inconsistencies found and fixed.
        + Orderable trait and interface now available for common use.