# test_project_ish
Fake Stocks is a Wordpress widget that provides fake stock quotes.  

This uses an API provides fake, but realistic-looking stock quotes that assumes the NASDAQ will continue to grow at its historical average rate of 9.13% per year. Do not confuse this for a real stock quotes; you will be sorely disappointed.

## Plugin Features

* **Easy Install:** Install and enable the plugin on a fresh installation of the latest version of WordPress.
* **Small Size:** The plugin extend the base `WP_Widget` class.
* **Configurable:** Site administrator can enter their personal API key, and to select how many stock price updates they wish to display in the widget.
* **Caching:** Display stock price data fetched from the API within the last 1 minute
* **Security:** Plugin uses the administrator-provided API key to generate a signed hash for its requests to the endpoint.
* **Viewer Friendly:** Plugin handles any possible response from the endpoint gracefully, and does not display error messages, inaccurate information, or broken markup due to not having valid data to show. Note: When there is an error from API that stock will not be displayed.
* **Valid HTML:**  Both the administrator configuration form and the public widget display use properly formatted, semantic HTML5 to render form elements and fetched data

## Installation Steps

 1. Place downloaded `wp-fake-stocks` folder in  Wordpress plugins folder (e.g. `wp-content/plugins/`).
 2. Enable plugin on admin plugins page.
 3. Add fake stocks widget to a sidebar.
 4. Enter your API key.
 5. Done! Watch the market!


## Documentation

### Widget Theming Guide

This widget is vary simple and easy to restyle. The HTML structure of a stock ticker is simply a div that is holding the stock ticker symbol, price, and %change in a flex box. The ticker can be restyled with the `.fake-stocks .stock` class. The data can be restyled with the `.fake-stocks .ticker`, `.fake-stocks .price`, and `.fake-stocks .change` classes receptively.
![Screenshot with theme structure](https://raw.githubusercontent.com/alleyinteractive/test_project_ish/master/theme-screenshot.png?token=ADTBzXRwN4yOBb7igt7udhnbLQnBHAYrks5XMkcGwA==)