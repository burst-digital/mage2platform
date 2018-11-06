# Mage2Platform

Tool for building and deploying Magento 2 projects on Platform.sh.

### Configuration

In the `.platform.app.yaml`, set the Platform.sh application name to:

```yaml
name: magento
```

Also make sure the application upstream is pointed to this same value in `.platform/routes.yaml`

```yaml
'https://www.{default}/':
  type: upstream
  upstream: magento:http
```

In the hooks section of of `.platform.app.yaml` add the following:

```yaml
hooks:
  build: |
    ./vendor/bin/mage2platform build --locale=nl_NL --locale=en_US
  deploy: |
    ./vendor/bin/mage2platform deploy
```

_Note: if the `build flavor` is not set to `composer`, you should add `composer install` in the build hook first._

The `--locale` part of the build hook is optional and depends on your project configuration.

### Roadmap

1. Implement multidomain/multistore support
2. Solr support
3. Install script
