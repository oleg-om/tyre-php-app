<?php
header('Content-type: application/json');
//echo(header('Content-type: application/xml;charset=UTF-8'));
//header('Content-type: application/xml;charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
echo $content_for_layout;
echo '</sitemapindex>';