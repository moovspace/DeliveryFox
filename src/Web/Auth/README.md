## Authorization component

### Require
- Html Component
- Html::Header()
- Html::Footer()
- MyApp\App\Translate\Trans() class

### Include in router
```php
$r->Include("Web/Auth/routes");
```

### Import mysql user tables
```sh
mysql -u root -p < user-tables.sql
```