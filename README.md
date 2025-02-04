# Wordpress Markdown Shortcode

Register the _markdown_ shortcode to the admin screen so you can use markdown snippets within your HTML blocks whatever the editor you are using.

Depending from the parser used - currently the library from Michel Fortin - the license can conflict with the WordPress.org requirements so the plugin won't be submitted or listed there.  
Feel free to customize to your own needs.

## Install

Download and install the plugin inside the ``wp-content/plugins`` directory.  

## How to use


### Shortcode

```markdown
[markdown id="awesome" class="foo bar"]## Headline H2
It's working great, isn't it ?[/markdown]
```

will be rendered as :

```html
<div id="awesome" class="foo bar">
<h2>Headline H2</h2>
<p>It's working great, isn't it ?</p>
</div>
```

### Function

You can also call the global helper ``markdown_shortcode``. Exemple:

```php
<?php echo markdown_shortcode::render_content( 'A **bold word** next to an _italic word_' ); ?>
```

will be rendered as :

```html
A <strong>bold word</strong> next to an <em>italic word</em>
```
