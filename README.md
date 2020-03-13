# DMF Api

Custom Shopware 6 API endpoint for seo urls.

## Installation
1. Download Repository 
2. Place files in: custom/plugins/DmfApi
3. ```
   bin/console plugin:refresh
   bin/console plugin:install --activate DmfApi
   ./psh.phar cache
   ```

## Usage

### Get SEO url
    http://DOMAIN/sales-channel-api/v1/dmf/seo-url
    

You can also set filter or limit https://docs.shopware.com/en/shopware-platform-dev-en/api/filter-search-limit, 

Example: if you want to find only entries that match the url "myurl":
 
    http://DOMAIN/sales-channel-api/v1/dmf/seo-url?filter[seoPathInfo]=myurl

### Get page by url key
    http://DOMAIN/sales-channel-api/v1/dmf/page


## Licence
MIT
