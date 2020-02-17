# DMF Api Seo Url

Custom Shopware 6 API endpoint for seo urls.

## Installation
1. Download Repository 
2. Place files in: custom/plugins/DmfApiSeoUrl
3. ```
   bin/console plugin:refresh
   bin/console plugin:install --activate DmfApiSeoUrl
   ./psh.phar cache
   ```

## Usage

    http://DOMAIN/sales-channel-api/v1/dmf/seo-url
    

You can also set filter or limit parameters like you would do in a regular SW6 api call:
[Shopware 6 - Developer Documentation](https://docs.shopware.com/en/shopware-platform-dev-en/api/filter-search-limit)

Example: Get only entries that matches "myurl":

    http://DOMAIN/sales-channel-api/v1/dmf/seo-url?filter[seoPathInfo]=myurl

## Licence
MIT
