# Zweig

Twig extension for component-based templating.

## Installation

```
composer require flammel/zweig
```

## Usage

### Setup

```
$twig = new Environment(...);
$presenterFactory = new DefaultPresenterFactory(new DefaultPresenter());
$componentRenderer = new ComponentRenderer($twig, $presenterFactory);
$runtimeLoader = new ZweigRuntimeLoader(new ZweigRuntimeExtension($componentRenderer));
$twig->addRuntimeLoader($runtimeLoader);
$twig->addExtension(new ZweigExtension());
```

With the settings above, Zweig will look for a template called `ComponentName.twig` to render a component with name `ComponentName`.
Either make sure to add a loader to the twig environment that can find those files, or implement a `Presenter` that returns a different template path.

### Templating

Using functions to render components:

```
{{ component('YouComponentName', 'The Headline', prop2FromContext }}
```

In `YourComponentName.twig`:

```
{{ props("headline", "text", ["footer, ""]) }}
<h1>{{ this.headline }}</h1>
<p>{{ this.text }}</p>
{% if this.footer %}
    <p class="footer">{{ this.footer }}</p>
{% endif %}
```

Using the component tag to fill slots:

```
{% component 'SlottedComponentName' with {'headline': 'The Headline', 'text: prop2FromContext} %}
    {% fill 'main' %}
        <img src="cat.jpg" alt="Image of a grey cat chilling on a window sill">
    {% endfill %}
{% endcomponent %}
```

In `SlottedComponentName.twig`:

```
<h1>{{ this.headline }}</h1>
{% slot 'main' %}
    <img src="fallbackImage.jpg" alt="A picture showing a pipe and the text 'Ceci n'est pas une pipe'">
{% endslot %}
<p>{{ this.text }}</p>
```

### Using presenters

The default presenter passes all props to the component.
If you want to compute some values that should be displayed by a component in PHP, implement a `PresenterFactory` and a `Presenter`.
The presenter contains the code for computing the values.
The factory is responsible for returning the correct presenter object for the given component name.
The `DefaultPresenterFactory` always returns the same presenter, but your implementation can return whatever object you need as long as it implements the `Presenter` interface.

## Development

Run static analysis ([PHPStan](https://github.com/phpstan/phpstan) and [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)):

```make check```

Run tests:

```make test```

## License

MIT
