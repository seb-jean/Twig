``sort_localized``
==================

.. versionadded:: 3.30

    The ``sort_localized`` filter was added in Twig 3.30.

The ``sort_localized`` filter sorts a sequence or a mapping by comparing strings
the way the locale does:

.. code-block:: twig

    {# fr: Benoît, Éric, François #}
    {{ ['François', 'Éric', 'Benoît']|sort_localized(locale: 'fr')|join(', ') }}

The ``sort`` filter compares strings byte per byte, which puts ``Éric`` last;
sorting the way a French reader expects requires the collation rules of the
locale, which is what this filter uses.

The order depends on the locale: German sorts ``Ä`` with ``A``, Swedish sorts it
after ``Z``::

    {# de: Ähre, Alt, Zeder #}
    {{ ['Alt', 'Zeder', 'Ähre']|sort_localized(locale: 'de')|join(', ') }}

    {# sv: Alt, Zeder, Ähre #}
    {{ ['Alt', 'Zeder', 'Ähre']|sort_localized(locale: 'sv')|join(', ') }}

By default, the filter uses the current locale.

To sort values that are not strings, pass an arrow function returning the string
to sort each value on::

    {% for city in cities|sort_localized((city) => city.name) %}
        {{ city.name }}
    {% endfor %}

.. note::

    Unlike the arrow of the :doc:`sort<sort>` filter, which compares two values,
    the arrow here returns the string to sort a value on, as the collator does
    the comparing.

On Symfony projects, this composes with the ``trans`` filter to sort translated
labels, which is otherwise hard to get right::

    {% for sport in user.sports|sort_localized((sport) => sport|trans) %}
        {{ sport|trans }}
    {% endfor %}

As with the ``sort`` filter, the keys are preserved.

.. note::

    The ``sort_localized`` filter is part of the ``IntlExtension`` which is not installed by default. Install it first:

    .. code-block:: sh

        $ composer require twig/intl-extra

    Then, on Symfony projects, install the ``twig/extra-bundle``:

    .. code-block:: sh

        $ composer require twig/extra-bundle

    Otherwise, add the extension explicitly on the Twig environment::

        use Twig\Extra\Intl\IntlExtension;

        $twig = new \Twig\Environment(...);
        $twig->addExtension(new IntlExtension());

Arguments
---------

* ``arrow``: An arrow function returning the string to sort each value on
* ``locale``: The locale code as defined in `RFC 5646`_

.. _RFC 5646: https://www.rfc-editor.org/info/rfc5646
