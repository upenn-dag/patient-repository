# Template Bundle

Templates are text blobs stored in the database for easy editing on Accard instances. They can override specific blocks or entire templates in the instance.

### Version
1.0.0

### Usage
1. Rename any reference to local views to have the `Template` namespace:
    - from `AccardWebBundle:Frontend/Patient:index.html.twig` to `Template:Frontend/Patient:index.html.twig`
2. Use the Template design view to override a block or template. Example parameters:
    - Name: `frontend-patient-index`
    - Location:  `Theme:Frontend/Patient:index.html.twig`
    - Parent: `AccardWebBundle`

### Block format

Templates in Core have been heavily blockized. They follow a general structure like so:

* Index views.

```
{% block content %}
	{% block page_title %} {% endblock %}

	{% block *resource*_content %}
		{% block *resources*_listing %} {% endblock %}
	{% endblock %}
{% endblock %}
```
* Show views (most are not developed as of Accard v3.1)
```
{% block content %}
	{% block page_title %} {% endblock %}
{% endblock %}
```

* Update views
```
{% block content %}
	{% block page_title %} {% endblock %}

	{% block *resource*_form %}
		{% block *base_field_name*_form %}

		{% endblock %}

		{% block *another_base_field_name*_form %}

		{% endblock %}

		{% block additional_fields_block %} 
			// Additional Fields are any fields provided by the resource's prototype
		{% endblock %}
	{% endblock %}
{% endblock %}
```
#### Navigation blocks
* Views with a navigation bar that shows and hides div's. See [Twitter bootstrap navs].

```
{% block *resource*_nav %}

{% endblock %}

{% block *resource*_content %}
	{% block *name_of_content_header_here* %}

	{% endblock %}

	{% block *name_of_content_header_here2* %}

	{% endblock %}

	// etc.
{% endblock %}
```

### Todo's

 - Write Tests
 - Incorporate App State to show available prototypes and fields per template

[Twitter bootstrap navs]: http://getbootstrap.com/components/#nav
