<!-- ![Kirby tablex ](https://raw.githubusercontent.com/floriankarsten/kirby-tablex/stuff/FKAPPROVED.png "Kirby tablex") -->
# Kirby tablex

Kirby tablex - simple table field for Kirby CMS. Advice, features and sugestions welcome.



![Kirby tablex GIF](https://raw.githubusercontent.com/floriankarsten/kirby-tablex/stuff/kirby-tablex.gif "Kirby tablex GIF")

## Usage

As any field in blueprint:
```yaml
  table:
    label: table
    type: tablex
    options: 
      maxColumns: 10
      minColumns: 3
      header: false
```

Options are not required. Defaults are:
```yaml
        maxColumns: 10
        minColumns: 1
        header: false
```

Content is then structured as regular yaml arrays:
```yaml
Table: 

header:
  - Column 1 heading
  - Column 2 heading
  - Column 3 heading
table:
  - 
    - Column 1 row 1
    - Column 2 row 1
    - Column 3 row 1
  - 
    - Column 2 row 1
    - Will be nothing after this
    - Column 3 row 2
  - 
    - ""
    - nothing
    - Column 3 row 3
  - 
    - Column 4 row 1
    - Real
    - Column 3 row 4
```


In your template you can simply use kirbys ```toStructure()```

Example:
```php
<?php $tableX = $page->table()->toStructure(); ?>
<div class="table">
	<table>
		<thead>
			<tr>
				<?php foreach($tableX->header() as $headerCell): ?>
					<th><?= $headerCell; ?></th>
				<?php endforeach; ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($tableX->table() as $tableRow): ?>
				<tr>
					<?php foreach($tableRow as $tableCell): ?>
						<td><?= $tableCell; ?></td>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
 ```



## Installation
To install the plugin, please put it in the `site/fields` directory.  
The field folder must be named `tablex`.

```
site/fields/
    tablex/
        tablex.php
        ...
```

### Download
Link to latest version https://github.com/floriankarsten/kirby-tablex/releases/latest

### With Kirby CLI
```kirby plugin:install floriankarsten/kirby-tablex```

### With Git
```git clone https://github.com/floriankarsten/kirby-tablex/releases.git tablex```
You can of course have it as submodule.



## What we are not sure about - ideas, opinions welcome :)
- Naming, we chose stupid name kirby-tablex because we were worried about namespace pollution.
- ~~How to properly pass data from kirby to JS. We are rendering ui only with JS. HTML doesn't come rendered from server. All data is passed to data-attribute of root element and taken from there. We are not sure how to make this safe properly. If you start to put \' and stuff like that into Tablex things will break.~~

