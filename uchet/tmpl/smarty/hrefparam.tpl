{if ($url.orderinfo|substr:-1:1=="/")}{$hrefParam}/{$hrefVal}/{else}&{$hrefParam}={$hrefVal}{/if}